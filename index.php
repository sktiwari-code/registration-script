<?php
  include_once 'config/Db.php';
  include_once 'autoload.php';

  $userObj=User::getinstance();
  $baseURL = 'getajax_user.php'; 
  $limit = 5;
  $totalRecords=$userObj->getTotalNumberOfRecordUser();
  $allRecords=$userObj->getAllRecordsUser($limit);
  $pagConfig = array( 
            'baseURL' => $baseURL, 
            'totalRows' => $totalRecords["rowCount"], 
            'perPage' => $limit, 
            'contentDiv' => 'postContent', 
            'link_func' => 'searchFilter' 
        );
  $paginationObj=new Pagination($pagConfig);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>User Registration | Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		@media (min-width: 576px)
		{
			.modal-dialog {
			    max-width: 50%;
			    margin: 1.75rem auto;
			}
			#rs_termcondition-error
			{
				position: absolute;
				top: 90%;
			}
		}
		@media (max-width: 576px)
		{

			#rs_termcondition-error
			{
				position: absolute;
				top: 95%;
			}
		}
		label {
			font-weight: 500;
	    	color: #05145f;
	    	margin-bottom: 5px;
		}
		.errorClass
		{
			color: red;
		}
	</style>
</head>
<body>

<!-- =========== start container ==========-->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="d-flex m-auto">

								<h4 class="text-dark text-center m-auto mb-4 text-decoration-underline">USER LIST</h4>
								<a href="javascript:void(0)" onclick="loadformmodal()" title="add user" class="btn btn-primary ml-auto mb-4"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
							</div>
						</div>
					</div>
					<div class="card mb-0" style="background-color: #d3d4d4!important;color: #000;font-weight: 700;">
								  <div class="card-body">
									  <div class="row">
									  	<div class="col-md-8">
									  	<label for="keywords">Search</label>
                            			<input type="text" id="keywords" class="form-control" placeholder="Type keywords..." onkeyup="searchFilter();">
									  	</div>

									  	<div class="col-md-2">
									  		<label for="sortBy">Sort</label>
									  		<select class="form-control select2-no-search" id="sortBy" onchange="searchFilter();">
											<option value="">Sort by Date</option>
                                  			<option value="asc">Ascending</option>
                                  			<option value="desc">Descending</option>
										</select>
									  	</div>
									  	<div class="col-md-2">
									  		<label for="limitset">Display Count</label>
									  	 <select class="form-control select2-no-search" id="limitset" onchange="searchFilter();">
											<option value="5">5</option>
                                  			<option value="10">10</option>
                                  			<option value="20">20</option>
                                  			<option value="50">50</option>
                                  			<option value="100">100</option>
										  </select>
									  	</div>

									  </div>
								  </div>
								</div>
					<div class="loading-overlay" style="display: none;position: absolute;top: 50%;left: 50%;">
						<div class="overlay-content">
							<img src="<?= BASEURL;?>/img/loader.gif" alt="" width="80px" class="loadingclass">
						</div>
				    </div>
				    <div class="row">
						<div class="col-md-12 mt-2">
						<!------========================= table start ========================------->
						<div class="table-responsive" id="postContent">
							<table class="table table-bordered">
								  <thead>
								    <tr>
								      <th class="text-center">S.No.</th>
								      <th class="text-center">Name</th>
								      <th class="text-center">Email</th>
								      <th class="text-center">City</th>
								      <th class="text-center">State</th>
								      <th class="text-center">Country</th>
								      <th class="text-center">Created Date</th>
								       <th class="text-center">Action</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<!--====  display records ===-->
								  	<?php
								    		$i=1;
								    		if(!empty($allRecords)):
								    		foreach ($allRecords as $UserData)
								    		{
								    ?>
							    		<tr>
								        	<td class="text-center"><?= $i++; ?>.</td>
								            <td class="text-center">
								            	<?= ucwords($UserData["first_name"]." ".$UserData["last_name"]); ?>
								            </td>
								            <td class="text-center">
								            	<?= $UserData["email"]; ?>
								            </td>
								            <td class="text-center">
								            	<?= ucwords($UserData["city_name"]); ?>
								            </td>
								            <td class="text-center">
								            	<?= ucwords($UserData["state_name"]); ?>
								            </td>
								            <td class="text-center">
								            	<span class="text-primary"> (<?=$UserData["country_code"];?>) </span> <?= ucwords($UserData["country_name"]); ?>
								            	
								            </td>
								            <td class="text-center">
								            	<?= $UserData["pdate"]; ?>
								            </td>
								            <td class="text-center">
								            	<div class="d-inline-flex">
									            	<a href="javascript:void(0)" onclick="loaduserdata('<?= $UserData["id"];?>');" class="btn btn-dark btn-with-icon btn-block"><i class="fa fa-edit"></i> Edit</a>
								            	</div>
								            </td>
								        </tr>
									<?php } endif; ?>

								  	<!--==== end display records ===-->
								  </tbody>
							</table>
							<!-- Display pagination links -->
                             		<?php echo $paginationObj->createLinks(); ?>
                         </div>
						<!------========================= table end ========================------->
						</div>
					</div>
				</div> <!-- end card body -->
			</div> <!-- end card -->
		</div>
		
	</div><!-- end  row -->
</div> <!-- end container -->

<?php include_once('form-modal.php');?>
<!-- =========== end container ==========-->
<!-- ====================== javascript start ==================== -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js" integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


 <script>
	// Show loading overlay when ajax request starts
	$( document ).ajaxStart(function() {
		$('.loading-overlay').show();
	});

	// Hide loading overlay when ajax request completes
	$( document ).ajaxStop(function() {
		$('.loading-overlay').hide();
	});

/*----------- table script ------------*/
function searchFilter(page_num) 
{
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    var limitset=$('#limitset').val();
    $.ajax({
        type: 'POST',
        url: '<?= BASEURL;?>/getajax_user.php',
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&limitset='+limitset,
        beforeSend: function () {
            $('.loading-overlay').show();
        },
        success: function (response) {
            $('#postContent').html(response);
            $('.loading-overlay').hide();
            $('.toggle-one').bootstrapToggle({
                on: 'Active',
                off: 'Disabled',
                offstyle:'danger'
            });
        }
    });
}
function Updatestatus(val)
{
  var restaurant_id= val;
    $.ajax({
        url: '<?php echo BASEURL ?>/ajax_pages/changerestaurantstatus.php',
        type: 'POST',
        dataType: 'json',
        data: {'restaurant_id':restaurant_id},
        success:function(response)
            {
                if(response.status)
                {
                    $.alert({
                    title: 'Success!',
                    type: 'green',
                    content: '<p class="text-center">'+response.success+'</p>',
                    });
                  
               }
               else
               {
               	  $.alert({
                    title: 'Warning!',
                    type: 'danger',
                    content: '<p class="text-center">'+response.error+'</p>',
                    });
               }
            }
          });
}
</script>

<!-- load modal script -->


<script type="text/javascript">
	function loadformmodal()
	{
		$("#formmodal").modal('show');
	}
	function loadState(val)
	{
		var countryid=val.split('_');
		$.post( "<?= BASEURL;?>/loadstate.php",{"countryid":countryid[1]}, function( data ) {
  			$( "#rs_state" ).html( data );
		});
	}
	function loadCity(val)
	{
		var stateid=val;
		$.post( "<?= BASEURL;?>/loadcity.php",{"stateid":stateid}, function( data ) {
  			$( "#rs_city" ).html( data );
		});
	}
	function loaduserdata(userid)
	{
		var userid=userid;
		$.post( "<?= BASEURL;?>/loaduserdata.php",{"userid":userid}, function(response) {
			
			$("#rs_fullname").val(response.firstname);
			$("#rs_lastname").val(response.lastname);
			$("#rs_email").val(response.email);
			$("#hid").val(response.usercode);
			$("#rs_country").val(response.country).change();
			if(response.termsconditions=="1")
			{
				$("#rs_termcondition").prop('checked',true);
			}
			
			setTimeout(function(){ $("#rs_state").val(response.state).change();;}, 1000);
			setTimeout(function(){ $("#rs_city").val(response.city);}, 2000);
			
			$("#formmodal").modal('show');

		});
	}
</script>

<!--------------------------  form vaidate and submit code --------------------->

<script type="text/javascript">
	$("#rs_form").validate({
	errorClass:'errorClass',
	errorElement:'span',
	rules:{
		rs_fullname:{
			required:true
		},
		rs_email:{
			required:true,
			email:true,
		},
		rs_password:{
			required:true
		},
		rs_city:{
			required:true
		},
		rs_country:{
			required:true
		},
		rs_state:{
			required:true
		},
		rs_termcondition:{
			required:true
		},
	},
	messages:{
		rs_fullname:{
			required:"Full name is required."
		},
		rs_email:{
			required:"Email is required.",
			email:"* Please enter valid email address."
		},
		rs_password:{
			required:"Enter Password",
		},
		rs_city:{
			required:"Please Choose City.",
		},
		rs_country:{
			required:"Please Choose Country.",
		},
		rs_state:{
			required:"Please Choose State.",
		},
		rs_termcondition:{
			required:"Please Select Terms and Conditions.",
		},
	},
	submitHandler:function(form){
		$("#rs_submit").attr('disabled','disabled');
		$("#rs_submit").text('Please wait..');
		$.ajax({
			method:'post',
			url:'<?= BASEURL;?>/user-register.php',
			data:$('#rs_form').serialize(),
			error:function(jqXHR){
              $("#rs_submit").removeAttr('disabled');
		      $("#rs_submit").text('Register');
			},
			success:function(response){
				$("#rs_submit").removeAttr('disabled');
		        $("#rs_submit").text('Register');
				if(response.status){
					$(".msg").css('color','green');
					$(".msg").show().text(response.success);
					location.reload();
				}
				else
				{
					if(response.errors){
						$(".rs_firstname_error").text(response.errors.rs_firstname_error);
						$(".rs_email_error").text(response.errors.rs_email_error);
						$(".rs_password_error").text(response.errors.rs_password_error);
						$(".rs_city_error").text(response.errors.rs_city_error);
						$(".rs_state_error").text(response.errors.rs_state_error);
						$(".rs_country_error").text(response.errors.rs_country_error);
						$(".rs_termcondition_error").text(response.errors.rs_termcondition_error);
					}
					else
					{
						$(".msg").css('color','red');
						$(".msg").show().text(response.error);
					}
				}
			}
		})
	}
});
</script>

<!-- ====================== javascript end ==================== -->
</body>
</html>