
/* This click javascript function is mainly used to tabbing sub directory of the entire payroll system */

$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});
 
/* This function is used to change the color in nav bar list*/

$(function(){
    
    var url = window.location;
    url = url.toString();  
    var frag = url.split("/");    
    
    var res_url = "http://"+frag[2]+"/"+frag[3];
    // 
    $('#color_change a[href^="'+res_url+'"]').parent().addClass('active');

    /* Detect click for Edit (Employer or Employee Details) */
    $(".empr_id").click(function() {
    	emid = $(this).text();
    	
    	$.post('/user/get_emp_details',{'empid':emid},function(data){
    	
            $('#popup_body').html(data);
            $('#popup_body').find('ul.nav.nav-tabs').remove();


    	 });

    });

    $("#updatebtn").live('click',function(event){
       
      
        $('#empr_form').validate({
        rules: { 
            department: "required" ,
            fullname:"required",
            username:"required",
            designation:"required"
          }, 
          messages: { 
            department: "The Department field is required." ,
            fullname:"The Fullname field is required.",
            username:"The Username filed is required.",
            designation:"The Designation field is required."
          } ,
          /* Pass the form object(similar to 'this' object) to the SubmitHandler */
          submitHandler: function(form) {
            
            /* JQuery post for Employee/Employer update */
            /* Encode the form using Serialize */
            $.post('/user/get_emp_details',$(form).serialize(),function(data){
                /* Load the page to get the updated data */
                
                if (data == 1)
                {
                window.location.href = window.location.toString();
                }
                else
                {
                    alert('Error Updating');
                }

             });/* POST close */

            }/* Submit handler close */
         
        });/* Validate close */
    
    
    });/* Live close */
//
if ($('#sess_val').val() != '')
{
$('table#emp_detail tr').eq($('#sess_val').val()).toggleClass("success");    
$('#sess_val').val('');
}


});/*main function close*/


//  $('#datepicker').datepicker(); 

// $('.fileupload').fileupload();



