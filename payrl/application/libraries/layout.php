<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout {

	
   public function __construct()
    {
       $this->obj =& get_instance();
       
    }


   public function view($view, $data=null, $return=false){
   	  $output = null;
      $this->obj->load->view('include/header');	
      //log_message('error',"SEGMENT: ".$this->obj->uri->rsegment(2));
      /* Save the current URL in browser to variable */
      $cur_url = $this->obj->uri->uri_string();
   	  if($this->obj->session->userdata('logged_in'))
   	  {
   	  	$this->obj->load->view('include/navigation');
      }
      else
      {
        //log_message('error',"LOGGED OUT BRO: ".$this->obj->uri->uri_string()); 
        
        if ($this->obj->uri->rsegment(2) != 'logout' && $this->obj->uri->rsegment(2) != 'login')
        {
          $this->obj->session->set_userdata(array('last_visit'=>$cur_url));
          //log_message('error',"LAST VIS: ".$this->obj->session->userdata('last_visit'));
        }
        
      }
   	  
      if($return):

         $output = $this->obj->load->view('templates/'.$view,$data, $return);
      else:

         $this->obj->load->view('templates/'.$view,$data, $return);

      endif;

      $this->obj->load->view('include/footer');
      return $output;
   }
   
}
?>
