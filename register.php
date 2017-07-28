<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Register";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_body_prop = array("id"=>"extr-page");
include("inc/header.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
		<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
		<header id="header">
			<!--<span id="logo"></span>-->

			<div id="logo-group">
				<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>

				<!-- END AJAX-DROPDOWN -->
			</div>

			<span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">Already registered?</span> <a href="<?php echo APP_URL; ?>/login.php" class="btn btn-danger">Sign In</a> </span>

		</header>

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 hidden-xs hidden-sm">
						<h1 class="txt-color-red login-header-big">OrisCom</h1>
						<div class="hero">

							<div class="pull-left login-desc-box-l">
								<h4 class="paragraph-header"><!--It's Okay to be Smart. Experience the simplicity of SmartAdmin, everywhere you go!--></h4>
								<div class="login-app-icons">
									<!--<a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
									<a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>-->
								</div>
							</div>
							
							<img src="<?php echo ASSETS_URL; ?>/img/demo/iphoneview.png" alt="" class="pull-right display-image" style="width:210px">
							
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<!--<h5 class="about-heading">About SmartAdmin - Are you up to date?</h5>
								<p>
									Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.
								</p>-->
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<!--<h5 class="about-heading">Not just your average template!</h5>
								<p>
									Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
								</p>-->
							</div>
						</div>

					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<div class="well no-padding">

							<form action="php/demo-register.php" id="smart-form-register" class="smart-form client-form">
								<header>
									Registration is FREE*
								</header>

								<fieldset>
									<section>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="text" name="username" placeholder="Username">
											<b class="tooltip tooltip-bottom-right">Needed to enter the website</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
											<input type="email" name="email" placeholder="Email address">
											<b class="tooltip tooltip-bottom-right">Needed to verify your account</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="password" placeholder="Password" id="password">
											<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="passwordConfirm" placeholder="Confirm password">
											<b class="tooltip tooltip-bottom-right">Don't forget your password</b> </label>
									</section>
								</fieldset>

								<fieldset>
									<div class="row">
										<section class="col col-6">
											<label class="input">
												<input type="text" name="firstname" placeholder="First name">
											</label>
										</section>
										<section class="col col-6">
											<label class="input">
												<input type="text" name="lastname" placeholder="Last name">
											</label>
										</section>
									</div>

									<!--<div class="row">
										<section class="col col-6">
											<label class="select">
												<select name="gender">
													<option value="0" selected="" disabled="">Gender</option>
													<option value="1">Male</option>
													<option value="2">Female</option>
													<option value="3">Prefer not to answer</option>
												</select> <i></i> </label>
										</section>
										<section class="col col-6">
											<label class="input"> <i class="icon-append fa fa-calendar"></i>
												<input type="text" name="request" placeholder="Request activation on" class="datepicker" data-dateformat='dd/mm/yy'>
											</label>
										</section>
									</div>

									<section>
										<label class="checkbox">
											<input type="checkbox" name="subscription" id="subscription">
											<i></i>I want to receive news and special offers</label>
										<label class="checkbox">
											<input type="checkbox" name="terms" id="terms">
											<i></i>I agree with the <a href="#" data-toggle="modal" data-target="#myModal"> Terms and Conditions </a></label>
									</section>-->
								</fieldset>
								<footer>
                                                                    <div class="alert alert-block alert-success "  id="compAlert">
                                                                            <a class="close" data-dismiss="alert" href="#">×</a>
                                                                            <h4 class="alert-heading"><i class="fa fa-check-square-o"></i> Check validation!</h4>
                                                                            <p id="compVali">
                                                                                    You may also check the form validation by clicking on the form action button. Please try and see the results below!
                                                                            </p>
                                                                    </div>
                                                                    <button type="button" id="btnRegis" class="btn btn-primary">
                                                                            Register
                                                                    </button>
								</footer>

								<div class="message">
									<i class="fa fa-check"></i>
									<p>
										Thank you for your registration!
									</p>
								</div>
							</form>

						</div>
						<p class="note text-center">*FREE Registration ends on October 2015.</p>
						<h5 class="text-center">- Or sign in using -</h5>
						<ul class="list-inline text-center">
							<li>
								<a href="javascript:void(0);" class="btn btn-primary btn-circle"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn btn-info btn-circle"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>

		</div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
					</div>
					<div class="modal-body custom-scroll terms-body">
						
 <div id="left">


            </div>
			
			<br><br>

            <p><strong>By using this  WEBSITE TERMS AND CONDITIONS template document, you agree to the 
	 <a href="#">terms and conditions</a> set out on 
	 <a href="#">SmartAdmin.com</a>.  You must retain the credit 
	 set out in the section headed "ABOUT THESE WEBSITE TERMS AND CONDITIONS".  Subject to the licensing restrictions, you should 
	 edit the document, adapting it to the requirements of your jurisdiction, your business and your 
	 website.  If you are not a lawyer, we recommend that you take professional legal advice in relation to the editing and 
	 use of the template.</strong></p>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Cancel
						</button>
						<button type="button" class="btn btn-primary" id="i-agree">
							<i class="fa fa-check"></i> I Agree
						</button>
						
						<button type="button" class="btn btn-danger pull-left" id="print">
							<i class="fa fa-print"></i> Print
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script type="text/javascript">
	runAllForms();
	
	// Model i agree button
	$("#i-agree").click(function(){
		$this=$("#terms");
		if($this.checked) {
			$('#myModal').modal('toggle');
		} else {
			$this.prop('checked', true);
			$('#myModal').modal('toggle');
		}
	});
	
	// Validation
	$(function() {
		// Validation
		$("#smart-form-register").validate({

			// Rules for form validation
			rules : {
				username : {
					required : true
				},
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				},
				passwordConfirm : {
					required : true,
					minlength : 3,
					maxlength : 20,
					equalTo : '#password'
				},
				firstname : {
					required : true
				},
				lastname : {
					required : true
				},
				gender : {
					required : true
				},
				terms : {
					required : true
				}
			},

			// Messages for form validation
			messages : {
				login : {
					required : 'Please enter your login'
				},
				email : {
					required : 'Please enter your email address',
					email : 'Please enter a VALID email address'
				},
				password : {
					required : 'Please enter your password'
				},
				passwordConfirm : {
					required : 'Please enter your password one more time',
					equalTo : 'Please enter the same password as above'
				},
				firstname : {
					required : 'Please select your first name'
				},
				lastname : {
					required : 'Please select your last name'
				},
				gender : {
					required : 'Please select your gender'
				},
				terms : {
					required : 'You must agree with Terms and Conditions'
				}
			},

			// Ajax form submition
			submitHandler : function(form) {
				$(form).ajaxSubmit({
					success : function() {
						$("#smart-form-register").addClass('submited');
					}
				});
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

	});
    $("#compAlert").hide();
    $("#btnRegis").click(saveRegis);
    $("#username").blur(checkUser);
    function saveRegis(){
        //alert("aaa");
        $.ajax({
            type: 'GET', url: 'saveData.php', contentType: "application/json", dataType: 'text', 
            data: { 'flagPage':"staff"
            ,'staff_id': "-"
            ,'staff_username': $("#username").val()
            ,'staff_name_t': $("#firstname").val()
            ,'staff_lastname_t': $("#lastname").val()
            ,'staff_password': $("#password").val()}, 
            success: function (data) {
//                alert('bbbbb'+data);
                var json_obj = $.parseJSON(data);
                for (var i in json_obj){
                    $("#compAlert").removeClass("alert alert-block alert-danger");
                    $("#compAlert").addClass("alert alert-block alert-success");
                    $("#compAlert").empty();
                    $("#compAlert").append(" บันทึกข้อมูลเรียบร้อย ");
                    $("#compAlert").show();
                }
                window.location.assign('login.php');
            }
        });
    }
    function checkUser(){
        $.ajax({
            type: 'GET', url: 'getAmphur.php', contentType: "application/json", dataType: 'text', 
            data: { 'flagPage':"checkUser"
            ,'staff_username': $("#username").val()}, 
            success: function (data) {
//                alert('bbbbb'+data);
                var json_obj = $.parseJSON(data);
                for (var i in json_obj){
                    if((json_obj[i].staff_name_t!="") && (json_obj[i].rows!="0")) {
                        $("#compAlert").removeClass("alert alert-block alert-success");
                        $("#compAlert").addClass("alert alert-block alert-danger");
                        $("#compAlert").empty();
                        $("#compAlert").append("มี username นี้ ได้ถูกใช้งานแล้ว "+json_obj[i].staff_name_t);
                        $("#compAlert").show();
                    }else{
                        $("#compAlert").removeClass("alert alert-block alert-danger");
                        $("#compAlert").addClass("alert alert-block alert-success");
                        $("#compAlert").empty();
                        $("#compAlert").append(" username นี้ OK ");
                        $("#compAlert").show();
                    }
                }
            }
        });
    }
</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>