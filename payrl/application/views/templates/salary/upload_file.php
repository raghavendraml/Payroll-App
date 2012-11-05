<!-- Upload file view page held here
    ================================================== -->

<div class="span10">
<ul class="nav nav-tabs">
      <li ><a href="salary_manage"> ViewFile</a></li>
      <li class="active"><a href="upload_view"> Upload File</a></li>     
  </ul> 
<div class="well">  
 <div class="tab-content">
  <div class="tab-pane active"> 		
  	<div class="span4 columns">
      <!-- <form class="form-horizontal" action="upload_view" method="post"> -->
    
      <?php echo form_open_multipart('salary/check_upload');?>
     
        <div class="fileupload fileupload-new" data-provides="fileupload">
          <div class="input-append">
            <label class="span1" style="float:left;color:#537CA6;">File : </label>
            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Click to Select File<input type="file" name="userfile" size="20" style="display:none;"/></span><span class="fileupload-exists">Change</span><input type="file" name="userfile"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
          </div>
        </div> 

        <div class="control-group">
          <div class="controls" style="text-align:center;margin-top:20px">     
             <!-- <input class="btn" type="Submit" value ="Upload" name="btnupload"/> -->
             <div class="btn-group">    
              <input class="btn" type="Submit" name="btnupload" value="Upload" />
              <span class="btn dropdown-toggle" data-toggle="dropdown" id="infobtn" >
                 <i class="icon-info-sign" id="info-sign" data-placement="right" data-trigger="hover" data-html="true" data-title="<strong>Note</strong>" data-content="Only files with extension .xls or .xlsx are allowed"></i>
                 <!-- data-placement="right" data-title="Note" data-content="Only files with extension .xls or .xlsx are allowed" -->
              </span>
            </div>
          </div>

            <?php if ($this->session->flashdata('upload_error')) : ?>
              <div class="row span8" style="margin-top:10px;">
                <div class="alert alert-error ">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <h4><strong>Error !! </strong><span>Could not upload file .</span></h4>
                  <div style="margin-top:10px;">
                    <div class="pull-left"><span class="label label-info" style="margin-right:5px;">Reason: </span></div><div class="text-info"><?php echo $this->session->flashdata('upload_error'); ?></div>
                  </div>
                </div>  
              </div>
            <?php endif ; ?>

              
          
        </div>            
     <?php echo form_close();?>   
   	</div>  

  </div>

 </div>
</div>
