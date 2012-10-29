<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary extends CI_Controller 
{
	// By default, this index page is displaying.
	
   public function index()
	{
		if(!$this->session->userdata('logged_in')){
			$this->layout->view('user/login_page');
		}
		else{
			redirect('salary/salary_manage');
		}
		
	}

	public function salary_manage()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('user/index');
		}
		else{ 
			$data['query'] = $this->salary_model->retrieve();
			$this->layout->view('salary/salary_details',$data);
		}
	}

	public function data_fetch()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('user/index');
		}
		else{
		 	redirect('salary/salary_manage');
		}
	}

	public function upload_view()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('user/index');
		}
		else
		{  
			/* Remove all the warnings */
			error_reporting(E_ALL ^ E_NOTICE);
			$data['query'] = $this->salary_model->retrieve();
			$this->layout->view('salary/upload_file');
			$this->load->library('reader');
			/* Disable fetching Styling inforamtion like font-family etc., by setting 2nd param
			 of Reader() to 'false' */
			$this->reader->Reader('uploads/example.xls',false);
			/* Store the total no of rows in XL for 1st sheet */
			$nrows = $this->reader->rowcount(0);
			/* Similarly store the no of columns in the XL for 1st sheet */
			$ncols = $this->reader->colcount(0);
			/* Get the list of field names for a particular table */
			$field_list = $this->db->list_fields('upld_dummy');
			
			// echo "No Of Rows: ".$this->reader->rowcount(0);
			// echo "<br />";
			// echo "No Of Columns: ".$this->reader->colcount(0);
			// echo "<br />";
			// /* val(row_num,col_num,sheet_index) */
			// echo "VAL: ".$this->reader->val(3,4,0);
			/* Dump the XL data to the screen */
			//echo $this->reader->dump();

			for ($i=1;$i<=$nrows;$i++)
			{
				$key_array = array();
				$val_array = array();
				$xldata = array();
				for ($j=1;$j<=$ncols;$j++)
				{
					  array_push($key_array,$field_list[$j-1]);
					  array_push($val_array,$this->reader->raw($i,$j,0));
					
				}

				$xldata = array_combine($key_array,$val_array);
				$insrt_res = $this->db->insert('upld_dummy',$xldata);
				if ($this->db->affected_rows()==1)
				{
					//error_log("1 Row Inserted ".$insrt_res);
				}
				else
				{
				error_log("Error Inserting ".$insrt_res);	
				}
				
			}
			
			

		}

	} /* Function Close*/

	// Logout the application.

	// public function logout()
	// {
	// 	$this->session->unset_userdata('logged_in');
	// 	$this->session->sess_destroy();
	// 	redirect('user/login');
	// }

}

