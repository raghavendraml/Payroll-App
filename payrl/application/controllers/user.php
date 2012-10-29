<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	* This User Controller is mainly used to login the payroll system.
	* And After login landing page will be displayed to that User.
	* Several Processes(links) are held this user controller.
*/

class User extends CI_Controller
{
	// By default, this index page is displaying.
	
	public function index()
	{
		
		if(!$this->set_data->is_logged_in())
		{
			
			$this->layout->view('user/login_page');
		}
		else
		{
			
			redirect('user/data_fetch');
		}
	}

	// Login with valid credential held here.
	public function login()
	{	

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if($this->form_validation->run('signup') == FALSE){
			$this->layout->view('user/login_page');
		}
		else
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$id = $this->user_model->check_login($username ,$password);
			if(!$id)
			{				
				$this->session->set_flashdata('login_error',TRUE);
				redirect('user/login');
			}
			else
			{
				//$this->load->library('session');
				$this->session->set_userdata(array('logged_in'=>'qwerty'));				
				redirect('user/valid_login'); 							
			}				
		}
	}

	// Validation of the login page.

	public function valid_login()
	{
		if($this->set_data->is_logged_in())
		{	
			
			if($this->session->userdata('last_visit'))
			{
				$url = $this->session->userdata('last_visit');
				//log_message('error',"CHK LAST VISIT: ".$url);
				redirect($url);
				
			}
			else
			{
				redirect('user/data_fetch');
			}
		}

		else
		{
			redirect('user/index');
		}
	}

	// Displaying the neccessary information about Employee or Employer.

	public function data_fetch()
	{	
		
		if(!$this->set_data->is_logged_in()){
			redirect('user/index');
		}
		else{ 		
			
			
			/* Auto load pagination library */
			/* Set the pagination configs */
      		$config['base_url'] = '/user/data_fetch';
      		$config['total_rows'] = $this->db->get('UserDetails')->num_rows();
      		$config['per_page'] = '10'; 
      		$this->pagination->initialize($config); 

			$data['query'] = $this->user_model->retrieve(null,$config['per_page']);
			$this->layout->view('user/display_view',$data);	
			
		}
	}
	
	public function get_emp_details()
	{
		if(!$this->session->userdata('logged_in'))
		{
			redirect('user/index');
		}
		else
		{	
			
			if ($this->input->post('empid'))
			{
				
				$empler_id = $this->input->post('empid');
				$this->session->set_userdata('empid',$empler_id);	
				$emp_data['update_emp'] = $this->user_model->retrieve($empler_id);
				$viw = $this->load->view('templates/registration/registration',$emp_data,TRUE);
			 	echo $viw; 
			}
			else
			{
			  	$update_data = array('name'=>$this->input->post('fullname'),
							  'user_name'=>$this->input->post('username'),
							  'designation'=>$this->input->post('designation'),
							  'dept'=>$this->input->post('department')
							  );
			 	//echo $this->input->post('fullname');
			 	$eid = $this->session->userdata('empid');
			 	
			 	$update_res = $this->user_model->update_emp_details($update_data,$eid);
			 	if ($update_res == 1)
			 	{
			 		$this->session->set_flashdata('emp_upd',$eid);
			 		echo 1 ;
			 	}
			 	else
			 	{
			 		echo "Error Occured" ;
			 	}
			 	

			  
		 	}

		}/* Parent else close */
	}

	
	public function search_employee()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('user/index');
		}
		else{	 
			$data['query'] = $this->user_model->retrieve();
			$this->layout->view('user/search_emp_details');	
		}
	}

	public function create_employee()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('user/index');
		}
		else{
			$this->load->view('create_employee');
		}
	}

	public function insert_user()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('user/index');
		}
		else{
			$data['query'] = $this->user_model->retrieve();
			$this->layout->view('form_success');
		}
	}

	// Logout of this application.

	public function logout()
	{
		$this->session->unset_userdata(array('logged_in'=>'','last_visit'=>''));
		$this->session->sess_destroy();
		$this->layout->view('user/login_page');

	}
}
