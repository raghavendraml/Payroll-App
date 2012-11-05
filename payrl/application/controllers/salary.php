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

			/* EMAIL TEST */

			// $e_conf ['protocol'] = 'smtp';
			// $e_conf ['smtp_host'] = 'ssl://smtp.googlemail.com';
			// $e_conf ['smtp_port'] = 465;
			// $e_conf ['smtp_user'] = 'santhosh.v@myshoreitsolutions.co.in';
			// $e_conf ['smtp_pass'] = '';

			// $this->load->library('email',$e_conf);

			// $timezone = new DateTimeZone("Asia/Kolkata" );
			// $date = new DateTime();
			// $date->setTimezone($timezone );
			// error_log("START TIME: ".$date->format( 'H:i:s A' ));
			// for ($i=1;$i<=50;$i++)
			// {
			// $this->email->set_newline("\r\n");
			// $path = $_SERVER['DOCUMENT_ROOT'].'/'.'uploads/';
			
			// $file_nm = $path.'Test_payslip.pdf';
			
			// $this->email->from('santhosh.v@myshoreitsolutions.co.in');
			// $this->email->to('santhosh.v@myshoreitsolutions.co.in');
		
			// $this->email->subject('Test Email');
			// $this->email->message('This is a test payslip from Code Ignitor');
			// $this->email->attach($file_nm);
			// if($this->email->send())
			// {
			// 	echo $i;
			// }
			// else
			// {
			// 	echo 'There is an error dude !!';
			// }
			// }/* FOR close */
			// $timezone1 = new DateTimeZone("Asia/Kolkata" );
			// $date1 = new DateTime();
			// $date1->setTimezone($timezone1);
			// error_log("END TIME: ".$date1->format( 'H:i:s A' ));

				// $this->load->library('reader');
				// /* Disable fetching Styling inforamtion like font-family etc., by setting 2nd param
				//  of Reader() to 'false' */
				// $this->reader->Reader('uploads/example.xls',false);
				// /* Store the total no of rows in XL for 1st sheet */
				// $nrows = $this->reader->rowcount(0);
				// /* Similarly store the no of columns in the XL for 1st sheet */
				// $ncols = $this->reader->colcount(0);
				// /* Get the list of field names for a particular table */
				// $field_list = $this->db->list_fields('upld_dummy');
				
				// // echo "No Of Rows: ".$this->reader->rowcount(0);
				// // echo "<br />";
				// // echo "No Of Columns: ".$this->reader->colcount(0);
				// // echo "<br />";
				// // /* val(row_num,col_num,sheet_index) */
				// // echo "VAL: ".$this->reader->val(3,4,0);
				// /* Dump the XL data to the screen */
				// //echo $this->reader->dump();

				// for ($i=1;$i<=$nrows;$i++)
				// {
				// 	$key_array = array();
				// 	$val_array = array();
				// 	$xldata = array();
				// 	for ($j=1;$j<=$ncols;$j++)
				// 	{
				// 		  array_push($key_array,$field_list[$j-1]);
				// 		  array_push($val_array,$this->reader->val($i,$j,0));
						
				// 	}

				// 	$xldata = array_combine($key_array,$val_array);
				// 	$insrt_res = $this->db->insert('upld_dummy',$xldata);
				// 	if ($this->db->affected_rows()==1)
				// 	{
				// 		//error_log("1 Row Inserted ".$insrt_res);
				// 	}
				// 	else
				// 	{
				// 	error_log("Error Inserting ".$insrt_res);	
				// 	}
				
				// }
			
			}

		//}

	} /* Function close*/

		public function check_upload()
		{
			if ($this->input->post('btnupload'))
			{
				// It is present Payroll/payrl folder.
				$config['upload_path'] = './uploads/'; 
				//If the file already exists with same name , file is over written .
				$config['overwrite'] = TRUE;
				// Allow only excel files(extension .xls & .xlsx).
				$config['allowed_types'] = 'xls|xlsx'; 
				$config['max_size']	= '100';
				$config['remove_spaces']  = TRUE;
		
				$this->load->library('upload',$config);
				/*Alternatively config options can be passed like this , if the upload class
				  is auto-loaded :
				
					$this->upload->intialize($config)
					
				*/

				if (!$this->upload->do_upload())
				{		
					
					$error = $this->upload->display_errors();
					$this->session->set_flashdata('upload_error',$error);
					
					redirect('salary/upload_view');
				}
				else
				{
					//To display details about the uploaded file like filename , size etc.
					//print_r($this->upload->data());

					// $data = array('upload_data'=> $this->upload->data());
					// $this->layout->view('upload/upload',$data);	

					//Load custom library reader .
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
					for ($i=1;$i<=$nrows;$i++)
					{
						$key_array = array();
						$val_array = array();
						$xldata = array();
						for ($j=1;$j<=$ncols;$j++)
						{
							  array_push($key_array,$field_list[$j-1]);
							  array_push($val_array,$this->reader->val($i,$j,0));
							
						}
						$xldata = array_combine($key_array,$val_array);
						$insrt_res = $this->db->insert('upld_dummy',$xldata);
						if (!$this->db->affected_rows()==1)
						{
							error_log("Error Inserting ".$insrt_res);	
						}
				
					}

					echo "DONE INSERTING";


				}	
			}
		}

	// Logout the application.

	// public function logout()
	// {
	// 	$this->session->unset_userdata('logged_in');
	// 	$this->session->sess_destroy();
	// 	redirect('user/login');
	// }

}

