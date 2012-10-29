<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	* This User_model is used to Get model information of user.
*/

class User_model extends CI_Model
{
	// Checking the user logged into the system.

	public function check_login($username,$password)
	{
		$md5_password = md5($password);
		$query = "select slno from UserDetails where user_name= ? and passwrd =?"; 
		$result1 = $this->db->query($query,array($username,$md5_password));

		if($result1->num_rows() ==1){
			return $result1->row(0)->slno;
		}
		else{
			return false;
		}	
	}

	public function save($data)
	{
		$this->db->insert('UserDetails',$data);
		if($this->db->affected_rows() > 0){
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function retrieve($id=null,$per_page=null)
	{
		$this->db->select('*');
		if ($id != null)
		{
			$this->db->where('slno',$id);
			//$query = $this->db->get('UserDetails');
		}

		elseif($per_page != null)
		{
			$pg_no = $this->uri->rsegment(3);
		
			if ($pg_no == null)
			{
				$pg_no = 0;	
			}
		/* Show 5 records strating from 0 . Syntax :- db->get('table',num_of_rec,start_point)*/	
			$query = $this->db->get('UserDetails',$per_page,$pg_no);		
		}

		elseif($per_page == null)
		{
			$query = $this->db->get('UserDetails');
		}
		
		return $query->result();		
	}	

	public function update($data)
	{
		$this->db->where($slno,$this->slno);
		$this->db->update('data',$data);
	}
	/* Employee/Employer details Update */
	public function update_emp_details($data,$id)
	{
		$this->db->where('slno',$id);
		$this->db->update('UserDetails',$data);
		if ($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


}

?>