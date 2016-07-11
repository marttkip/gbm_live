<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";
class Orders extends admin
{ 
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('ctn_model');
		$this->load->model('orders_model');
		$this->load->model('projects_model');
		$this->load->model('seedling_production_model');
		$this->load->model('meeting_model');
		$this->load->model('admin/users_model');
	}
    
	/*
	*
	*	Default action is to show all the orders
	*
	*/
	public function index($project_id,$nursery_id,$ctn_id) 
	{
		// get my approval roles

		$where = 'orders.order_status_id = order_status.order_status_id AND nursery_id = '.$nursery_id.' AND project_id ='.$project_id.' AND ctn_id ='.$ctn_id;
		$table = 'orders, order_status';
		//pagination
		$segment = 6;
		$this->load->library('pagination');
		$config['base_url'] = base_url().'tree-planing/orders/'.$project_id.'/'.$nursery_id.'/'.$ctn_id;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->orders_model->get_all_orders($table, $where, $config["per_page"], $page);
		//var_dump ($query);die();
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$v_data['project_id'] = $project_id;
		$v_data['nursery_id'] = $nursery_id;
		$v_data['ctn_id'] = $ctn_id;
		$v_data['order_status_query'] = $this->orders_model->get_order_status();
		// $v_data['level_status'] = $this->orders_model->order_level_status();
		$v_data['title'] = "All Orders";
		$data['content'] = $this->load->view('projects/orders/all_orders', $v_data, true);
		
		$data['title'] = 'All orders';
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new order
	*
	*/
	public function add_order($project_id,$nursery_id,$ctn_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('order_instructions', 'Order Instructions', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$order_id = $this->orders_model->add_order($project_id,$nursery_id,$ctn_id);
			//update order
			if($order_id > 0)
			{
				// $query = $this->orders_model->get_order_details_items($order_id);
				// foreach ($query->result() as $key) {
				// 	# code...
				// 	$order_number = $key->order_number;
				// }
				// redirect('cashier/payments/'.$order_id.'/'.$order_number);
				$this->session->set_userdata('success_message', 'You have successfully created an order');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update order. Please try again');
			}
		}
		redirect('tree-planting/orders/'.$project_id.'/'.$nursery_id.'/'.$ctn_id);
		
	}
    

    public function add_order_item($project_id,$nursery_id,$ctn_id,$order_id)
    {

		$this->form_validation->set_rules('seedling_type_id', 'Seedling Type', 'required|xss_clean');
		$this->form_validation->set_rules('species_id', 'Species Id', 'required|xss_clean');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->orders_model->add_ctn_order_item($order_id))
			{
				$this->session->set_userdata('success_message', 'Order created successfully');
			}	
			else
			{
				$this->session->set_userdata('error_message', 'Something went wrong, please try again');
			}
		}
		else
		{

		}
		$v_data['title'] = 'Add Order Item ';
		$v_data['order_status_query'] = $this->orders_model->get_order_status();
		$v_data['order_id'] = $order_id;



		$v_data['order_item_query'] = $this->orders_model->get_order_items($order_id);

		$seedling_type_order = 'seedling_type.seedling_type_name';
		$seedling_type_table = 'seedling_type';
		$seedling_type_where = 'seedling_type.seedling_type_id > 0';

		$seedling_type_query = $this->seedling_production_model->get_active_list($seedling_type_table, $seedling_type_where, $seedling_type_order);
		$rs10 = $seedling_type_query->result();


		$seedling_type_list = '';
		foreach ($rs10 as $seedling_type_rs) :
			$seedling_type_id = $seedling_type_rs->seedling_type_id;
			$seedling_type_name = $seedling_type_rs->seedling_type_name;

		    $seedling_type_list .="<option value='".$seedling_type_id."'>".$seedling_type_name."</option>";

		endforeach;

		$v_data['seedling_type_list'] = $seedling_type_list;
		$v_data['seedling_type_rs'] = $rs10;


		$administrators = $this->personnel_model->retrieve_personnel();
		if ($administrators->num_rows() > 0)
		{
			$admins = $administrators->result();
			$personnel_list = '';
			foreach($admins as $adm)
			{
				$personnel_id = $adm->personnel_id;
				$personnel_fname = $adm->personnel_fname;
				$personnel_onames = $adm->personnel_onames;
				
				$personnel_list .="<option value='".$personnel_id."'>".$personnel_fname." ".$personnel_onames."</option>";
			}
		}
		
		else
		{
			$personnel_list = '';
		}
		$v_data['personnel_list'] = $personnel_list;

		$species_order = 'species.species_name';
		$species_table = 'species';
		$species_where = 'species.species_id > 0';

		$species_query = $this->seedling_production_model->get_active_list($species_table, $species_where, $species_order);
		$rs10 = $species_query->result();


		$species_list = '';
		foreach ($rs10 as $species_rs) :
			$species_id = $species_rs->species_id;
			$species_name = $species_rs->species_name;

		    $species_list .="<option value='".$species_id."'>".$species_name."</option>";

		endforeach;

		$v_data['species_list'] = $species_list;
		$v_data['species_rs'] = $rs10;

		$v_data['project_id'] = $project_id;
		$v_data['nursery_id'] = $nursery_id;
		$v_data['ctn_id'] = $ctn_id;
		$v_data['order_id'] = $order_id;

		$data['content'] = $this->load->view('orders/order_item', $v_data, true);

		$this->load->view('admin/templates/general_page', $data);
    }
    

    public function print_order_item($project_id,$nursery_id,$ctn_id,$order_id)
    {
		$v_data['title'] = 'Add Order Item ';
		$v_data['order_status_query'] = $this->orders_model->get_order_status();
		$v_data['order_details'] = $this->orders_model->get_order($order_id);
		$v_data['order_id'] = $order_id;

		$v_data['order_item_query'] = $this->orders_model->get_order_items($order_id);

		$seedling_type_order = 'seedling_type.seedling_type_name';
		$seedling_type_table = 'seedling_type';
		$seedling_type_where = 'seedling_type.seedling_type_id > 0';

		$seedling_type_query = $this->seedling_production_model->get_active_list($seedling_type_table, $seedling_type_where, $seedling_type_order);
		$rs10 = $seedling_type_query->result();


		$seedling_type_list = '';
		foreach ($rs10 as $seedling_type_rs) :
			$seedling_type_id = $seedling_type_rs->seedling_type_id;
			$seedling_type_name = $seedling_type_rs->seedling_type_name;

		    $seedling_type_list .="<option value='".$seedling_type_id."'>".$seedling_type_name."</option>";

		endforeach;

		$v_data['seedling_type_list'] = $seedling_type_list;
		$v_data['seedling_type_rs'] = $rs10;


		$administrators = $this->personnel_model->retrieve_personnel();
		if ($administrators->num_rows() > 0)
		{
			$admins = $administrators->result();
			$personnel_list = '';
			foreach($admins as $adm)
			{
				$personnel_id = $adm->personnel_id;
				$personnel_fname = $adm->personnel_fname;
				$personnel_onames = $adm->personnel_onames;
				
				$personnel_list .="<option value='".$personnel_id."'>".$personnel_fname." ".$personnel_onames."</option>";
			}
		}
		
		else
		{
			$personnel_list = '';
		}
		$v_data['personnel_list'] = $personnel_list;

		$species_order = 'species.species_name';
		$species_table = 'species';
		$species_where = 'species.species_id > 0';

		$species_query = $this->seedling_production_model->get_active_list($species_table, $species_where, $species_order);
		$rs10 = $species_query->result();


		$species_list = '';
		foreach ($rs10 as $species_rs) :
			$species_id = $species_rs->species_id;
			$species_name = $species_rs->species_name;

		    $species_list .="<option value='".$species_id."'>".$species_name."</option>";

		endforeach;

		$v_data['species_list'] = $species_list;
		$v_data['species_rs'] = $rs10;

		$v_data['project_id'] = $project_id;
		$v_data['nursery_id'] = $nursery_id;
		$v_data['ctn_id'] = $ctn_id;
		$v_data['order_id'] = $order_id;
		$v_data['branch_data'] = $this->meeting_model->get_branch_details();

		$this->load->view('orders/print_order_item', $v_data);
    }


    public function print_lpo_new($supplier_order_id)
	{
		$data = array('supplier_order_id'=>$supplier_order_id);

		$data['contacts'] = $this->site_model->get_contacts();
		
		$this->load->view('orders/views/lpo_print', $data);
		
	}
	public function print_rfq_new($order_id,$supplier_id,$order_number)
	{
		$data = array('order_id'=>$order_id,'supplier_id'=>$supplier_id,'order_number'=>$order_number);

		$data['contacts'] = $this->site_model->get_contacts();
		
		$this->load->view('orders/views/request_for_quotation', $data);
		
	}

    public function update_order_item($order_id,$order_number,$order_item_id)
    {
    	$this->form_validation->set_rules('quantity', 'Quantity', 'numeric|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
	    	if($this->orders_model->update_order_item($order_id,$order_item_id))
			{
				$this->session->set_userdata('success_message', 'Order Item updated successfully');
			}	
			else
			{
				$this->session->set_userdata('error_message', 'Order Item was not updated');
			}
		}
		else
		{
			$this->session->set_userdata('success_message', 'Sorry, Please enter a number in the field');
		}
		redirect('inventory/add-order-item/'.$order_id.'/'.$order_number.'');

    }
    public function update_supplier_prices($order_id,$order_number,$order_item_id)
    {
    	$this->form_validation->set_rules('unit_price', 'Unit Price', 'numeric|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
	    	if($this->orders_model->update_order_item_price($order_id,$order_item_id))
			{
				$this->session->set_userdata('success_message', 'Order Item updated successfully');
			}	
			else
			{
				$this->session->set_userdata('error_message', 'Order Item was not updated');
			}
		}
		else
		{
			$this->session->set_userdata('success_message', 'Sorry, Please enter a number in the field');
		}
		redirect('inventory/add-order-item/'.$order_id.'/'.$order_number.'');

    }
    public function submit_supplier($order_id,$order_number)
    {
    	$this->form_validation->set_rules('supplier_id', 'Quantity', 'numeric|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->orders_model->add_supplier_to_order($order_id))
			{
				$this->session->set_userdata('success_message', 'Order Item updated successfully');
			}
			else
			{
				$this->session->set_userdata('success_message', 'Order Item updated successfully');
			}
		}
		else
		{
			$this->session->set_userdata('success_message', 'Order Item updated successfully');
		}
		redirect('inventory/add-order-item/'.$order_id.'/'.$order_number.'');
    }
	/*
	*
	*	Edit an existing order
	*	@param int $order_id
	*
	*/
	public function edit_order($order_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('order_instructions', 'Order Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('user_id', 'Customer', 'required|xss_clean');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update order
			if($this->orders_model->update_order($order_id))
			{
				$this->session->set_userdata('success_message', 'Order updated successfully');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update order. Please try again');
			}
		}
		
		//open the add new order
		$data['title'] = 'Edit Order';
		
		//select the order from the database
		$query = $this->orders_model->get_order($order_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['order'] = $query->row();
			$query = $this->products_model->all_products();
			$v_data['products'] = $query->result();#
			$v_data['payment_methods'] = $this->orders_model->get_payment_methods();
			
			$data['content'] = $this->load->view('orders/edit_order', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Order does not exist';
		}
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_id
	*	@param int $product_id
	*	@param int $quantity
	*
	*/
	public function add_product($order_id, $product_id, $quantity, $price)
	{
		if($this->orders_model->add_product($order_id, $product_id, $quantity, $price))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_id
	*	@param int $order_item_id
	*	@param int $quantity
	*
	*/
	public function update_cart($order_id, $order_item_id, $quantity)
	{
		if($this->orders_model->update_cart($order_item_id, $quantity))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Delete an existing order
	*	@param int $order_id
	*
	*/
	public function delete_order($order_id)
	{
		//delete order
		$this->db->delete('orders', array('order_id' => $order_id));
		$this->db->delete('order_item', array('order_item_id' => $order_id));
		redirect('all-orders');
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_item_id
	*
	*/
	public function delete_order_item($order_id, $order_item_id)
	{
		if($this->orders_model->delete_order_item($order_item_id))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Complete an order
	*	@param int $order_id
	*
	*/
	public function finish_order($order_id)
	{
		$data = array(
					'order_status'=>2
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('all-orders');
	}
	public function send_order_for_correction($order_id)
	{

    	$data = array(
					'order_approval_status'=>0,
					'order_status_id'=>1
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('inventory/orders');
	}
    public function send_order_for_approval($order_id,$order_status= NULL)
    {
    	if($order_status == NULL)
    	{
    		$order_status = 1;
    	}
    	else
    	{
    		$order_status = $order_status;
    	}
    	
		$this->orders_model->update_order_status($order_id,$order_status);


		redirect('inventory/orders');
    }
	/*
	*
	*	Cancel an order
	*	@param int $order_id
	*
	*/
	public function cancel_order($order_id)
	{
		$data = array(
					'order_status'=>3
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('all-orders');
	}
    
	/*
	*
	*	Deactivate an order
	*	@param int $order_id
	*
	*/
	public function deactivate_order($order_id)
	{
		$data = array(
					'order_status'=>1
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('all-orders');
	}

	public function receivables($project_id,$nursery_id,$ctn_id)
	{
		

		$this->form_validation->set_rules('fruit_trees', 'Fruit Trees', 'required|xss_clean');
		$this->form_validation->set_rules('indegenous_trees', 'Indegenous Trees', 'required|xss_clean');
		$this->form_validation->set_rules('exotic_trees', 'Exotic Trees', 'required|xss_clean');
		$this->form_validation->set_rules('personnel_id', 'Personnel id', 'required|xss_clean');
		$this->form_validation->set_rules('date_given', 'Date', 'required|xss_clean');
		$this->form_validation->set_rules('driver_name', 'Driver Name', 'required|xss_clean');
		$this->form_validation->set_rules('driver_national_id', 'National ID', 'required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			// var_dump($_POST); die();
			if($this->orders_model->add_order_receivables($project_id,$nursery_id,$ctn_id))
			{
				$this->session->set_userdata('success_message', 'Successfully');
			}			
			else
			{
				$this->session->set_userdata('error_message', 'Sorry something went wrong. Please try again');
			}
		}

		$where = 'order_receivables.project_id = '.$project_id.' AND nursery_id ='.$nursery_id.' AND ctn_id ='.$ctn_id;
		$table = 'order_receivables';

		//pagination
		$segment = 6;
		$this->load->library('pagination');
		$config['base_url'] = base_url().'tree-planing/receivables/'.$project_id.'/'.$nursery_id.'/'.$ctn_id;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->orders_model->get_all_receivables($table, $where, $config["per_page"], $page);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$v_data['project_id'] = $project_id;
		$v_data['nursery_id'] = $nursery_id;
		$v_data['ctn_id'] = $ctn_id;
		$v_data['order_status_query'] = $this->orders_model->get_order_status();


		$administrators = $this->personnel_model->retrieve_personnel();
		if ($administrators->num_rows() > 0)
		{
			$admins = $administrators->result();
			$personnel_list = '';
			foreach($admins as $adm)
			{
				$personnel_id = $adm->personnel_id;
				$personnel_fname = $adm->personnel_fname;
				$personnel_onames = $adm->personnel_onames;
				
				$personnel_list .="<option value='".$personnel_id."'>".$personnel_fname." ".$personnel_onames."</option>";
			}
		}
		
		else
		{
			$personnel_list = '';
		}
		$v_data['personnel_list'] = $personnel_list;

		$v_data['title'] = "Receivables";
		$data['content'] = $this->load->view('projects/orders/all_receivables', $v_data, true);
		
		$data['title'] = 'Receivables';
		
		$this->load->view('admin/templates/general_page', $data);
	}

	public function generate_form9($project_id,$nursery_id,$ctn_id)
	{
		$where = 'order_receivables.project_id = '.$project_id.' AND nursery_id ='.$nursery_id.' AND ctn_id ='.$ctn_id;
		$table = 'order_receivables';
		$query = $this->orders_model->get_all_receivables($table, $where);
		$v_data['community_group_query'] = $this->orders_model->get_community_group($nursery_id);
		
		$v_data['query'] = $query;
		$v_data['project_id'] = $project_id;
		$v_data['nursery_id'] = $nursery_id;
		$v_data['ctn_id'] = $ctn_id;
		$v_data['branch_data'] = $this->meeting_model->get_branch_details();
		$v_data['admins'] = $this->personnel_model->retrieve_personnel();
		
		$this->load->view('projects/orders/print_all_receivables', $v_data);
	}

	public function print_receivable($receivable_id)
	{
		$where = 'order_receivables.receivable_id = '.$receivable_id.' AND order_receivables.nursery_id = community_group.community_group_id AND order_receivables.personnel_id = personnel.personnel_id AND projects.project_id = order_receivables.project_id';
		$table = 'order_receivables, community_group, personnel, projects';
		$query = $this->orders_model->get_receivable_details($table, $where);
		
		$v_data['query'] = $query;
		$v_data['branch_data'] = $this->meeting_model->get_branch_details();
		$v_data['admins'] = $this->personnel_model->retrieve_personnel();
		
		$this->load->view('projects/orders/print_receivable', $v_data);
	}
	
	public function edit_recievable($receivable_id)
	{
		$data['title'] = 'Edit recievable';
		//select the order from the database
		$query = $this->orders_model->get_recievable($receivable_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['order'] = $query->row();
			$v_data['products'] = $query->result();#
			$v_data['payment_methods'] = $this->orders_model->get_payment_methods();
			
			$data['content'] = $this->load->view('orders/edit_recievable', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Order does not exist';
		}
		
		$this->load->view('admin/templates/general_page', $data);
	}
}
?>