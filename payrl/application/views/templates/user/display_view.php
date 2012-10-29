<!-- List of user details view page held here
    ================================================== -->
 
<div class="span10">
	<ul class="nav nav-tabs">
      <li class="active"><a href="data_fetch">List of Employee</a></li>
      <li><a href="search_employee">Search Employee</a></li>   
  	</ul>	



 <div class="well">

 <div class="modal hide fade" style="position:fixed;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="popup">
 	 <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3>Update Details</h3>
  	</div>
  	<div class="modal-body" id="popup_body">
    	
  	</div>
  	<div class="modal-footer">
  	<!--Adding data-dismiss="modal" attribute provides the close functionality to a button -->
    	<a href="#" class="btn" data-dismiss="modal">Close</a>
    	
  	</div>
</div>

  <div class="tab-content">
  
  	<!-- List of Employee navigation bar here-->
    <div class="tab-pane active"> 
		<table class = "table table-bordered" id="emp_detail">
			<tr class= "data_val">
				<th> SLNO </th>
				<th> UserName </th>
				<th> Designation </th>
				<th> Department </th>
			</tr>					
			<!-- <form class="form-horizontal" action="update" method="post"> -->
			
				<?php foreach($query as $row): ?>
			
				<tr>
				<!-- emp_update?empid=<?php echo $row->slno;?> role="button" class="btn" data-toggle="modal" name="empr_id" title="Click to edit data"-->

					<td><a href="#popup" name="empr_id" role="button" class="btn empr_id" data-toggle="modal"><?php echo $row->slno;?></a></td>
					<td><?php echo $row->name;?></td>
					<td><?php echo $row->designation;?></td>
					<td><?php echo $row->dept;?></td>
				
				</tr>

				<?php endforeach;?>	
		<!-- </form> -->

		</table>
		<div class="pull-right"><?php echo $this->pagination->create_links(); ?></div>
		
		<input type="hidden" id="sess_val" value="<?php echo $this->session->flashdata('emp_upd'); ?>">
	  </div>
	</div>						
	</div>	
	
 <!-- tab content closing here-->   
	</div>


