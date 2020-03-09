<?php session_start();
require_once('dbconnection.php');

//Code for Registration 
$username = "";
$email    = "";
$errors = array();
//Code for Registration 
if(isset($_POST['signup']))
{
	$fname=mysqli_real_escape_string($con,$_POST['fname']);
	$lname=mysqli_real_escape_string($con,$_POST['lname']);
	$email=mysqli_real_escape_string($con,$_POST['email']);
	$password1=mysqli_real_escape_string($con,$_POST['password1']);
	$password2=mysqli_real_escape_string($con,$_POST['password2']); //edit docs!QQ
	$contact=mysqli_real_escape_string($con,$_POST['contact']);
	$student_id=mysqli_real_escape_string($con,$_POST['academic_year']);
	$roll_no=mysqli_real_escape_string($con,$_POST['roll_no']);
	$student_id .="-" .$roll_no;
	if ($password1 != $password2) {
		array_push($errors, "The two passwords do not match");
		echo  "<script>alert('The two passwords do not match');</script>";
	  }
	 $user_check_query = "SELECT * FROM users WHERE contactno='$contact' OR email='$email' OR student_id='$student_id' LIMIT 1";
 	 $result = mysqli_query($con, $user_check_query);
 	 $user = mysqli_fetch_assoc($result);
  
 	 if ($user) { // if user exists
  	  if ($user['contactno'] === $contact) {
		array_push($errors,"Phone No. already exists");
		echo  "<script>alert('Phone Number already exists');</script>";
    }

    if ($user['email'] === $email) {
	  array_push($errors, "email already exists");
	  echo  "<script>alert('email already exists');</script>";
	}
	
	if ($user['student_id'] === $student_id) {
		array_push($errors, "Student ID already exists");
		echo  "<script>alert('Student ID already exists');</script>";
	  }
  }
 	 if (count($errors) == 0) {
		$enc_password = md5($password1);
		$msg=mysqli_query($con,"insert into users(fname,lname,email,password,contactno,student_id,user_email_status) values('$fname','$lname','$email','$enc_password','$contact','$student_id','not verified')");
		if($msg){
		header("location:http://localhost/dashboard/elibrary/assets/loginsystem2/otp/");
		}
	}
}
// Code for login 
if(isset($_POST['login']))
{
$password=$_POST['password'];
$dec_password=md5($password);
$useremail=$_POST['uemail'];
$ret= mysqli_query($con,"SELECT * FROM users WHERE email='$useremail' and password='$dec_password'");
$num=mysqli_fetch_array($ret);
if($num>0)
{
	$ret2me= mysqli_query($con,"SELECT * FROM users WHERE email='$useremail' and user_email_status='verified'");
	$num2me=mysqli_fetch_array($ret2me);	
	if($num2me>0){
			$extra="welcome2us.php";
			$_SESSION['login']=$_POST['uemail'];
			$_SESSION['id']=$num['id'];
			$_SESSION['name']=$num['fname'];
			$host=$_SERVER['HTTP_HOST'];
			$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
			header("location:http://$host$uri/$extra");
			exit();
	}
	else
	{
		echo "<script>alert('Verify your email address first');</script>";
		$extra="index.php";
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
		//header("location:http://$host$uri/$extra");
		exit();
	}
}
else
{
echo "<script>alert('Invalid username or password');</script>";
$extra="index.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
//header("location:http://$host$uri/$extra");
exit();
}
}

//Code for Forgot Password

if(isset($_POST['send']))
{
$femail=$_POST['femail'];

$row1=mysqli_query($con,"select email,password from users where email='$femail'");
$row2=mysqli_fetch_array($row1);
if($row2>0)
{
$email = $row2['email'];
$subject = "Information about your password";
$password=$row2['password'];
$message = "Your password is ".$password;
mail($email, $subject, $message, "From: $email");
echo  "<script>alert('Your Password has been sent Successfully');</script>";
}
else
{
echo "<script>alert('Email not register with us');</script>";	
}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Login System</title>
<link href="css/style.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Elegent Tab Forms,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements"./>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,0); } </script>
</script>
<script src="js/jquery.min.js"></script>
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#horizontalTab').easyResponsiveTabs({
							type: 'default',       
							width: 'auto', 
							fit: true 
						});
					});
				   </script>
<link href='css/sanspros.css' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="main">
		<h1>Registration and Login System</h1>
	 <div class="sap_tabs">	
			<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
			  <ul class="resp-tabs-list">
			  	  <li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><div class="top-img"><img src="images/top-note.png" alt=""/></div><span>Register</span>
			  	  	
				</li>
				  <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><div class="top-img"><img src="images/top-lock.png" alt=""/></div><span>Login</span></li>
				  <li class="resp-tab-item lost" aria-controls="tab_item-2" role="tab"><div class="top-img"><img src="images/top-key.png" alt=""/></div><span>Reset</span></li>
				  <div class="clear"></div>
			  </ul>		
			  	 
			<div class="resp-tabs-container">
					<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
					<div class="facts">
					<?php
					$connected = @fsockopen("www.google.com",80);
					if($connected){
						echo '<div class="register">
							<form name="registration" method="post" action="" enctype="multipart/form-data">
								<p>First Name </p>
								<input type="text" class="text" value=""  name="fname" required >
								<p>Last Name </p>
								<input type="text" class="text" value="" name="lname"  required >
								<p>Email Address </p>
								<input type="text" class="text" value="" name="email"  required>
								<p>Password </p>
								<input type="password" value="" name="password1" required>
								<p>Confirm Password </p>
								<input type="password" value="" name="password2" required>
								<p>Contact No. </p>
								<input type="text" value="" name="contact"  required><br><br>
								<label>Please select Roll No:</label>
								<select name="academic_year">
									<option>SELECT</option>
									<option value="I-EC">I-EC</option>
									<option value="II-EC">II-EC</option>
									<option value="III-EC">III-EC</option>
									<option value="IV-EC">IV-EC</option>
									<option value="V-EC">V-EC</option>
									<option value="VI-EC">VI-EC</option>
								</select required>&nbsp;
								<input type="number" value="" name="roll_no"  min="1" max="150" required><br><br>
								<input type="checkbox" value="" name="checkbox"  required>
								<label for="checkbox">I agree to the <a href="term.vs.policy.php">terms and Conditions</a></label>
								<div class="sign-up">
									<input type="reset" value="Reset">
									<input type="submit" name="signup"  value="Sign Up" >
									<div class="clear"> </div>
								</div>
							</form>

						</div>';
					}else{
						echo '<div class="register disabled">
							<form name="registration" method="post" action="" enctype="multipart/form-data">
								<p class="error_msg">Server is offline<br>
								New Regersteration is not avaliable now</p>
								<p>First Name </p>
								<input type="text" class="text" value=""  name="fname" required >
								<p>Last Name </p>
								<input type="text" class="text" value="" name="lname"  required >
								<p>Email Address </p>
								<input type="text" class="text" value="" name="email"  required>
								<p>Password </p>
								<input type="password" value="" name="password1" required>
								<p>Confirm Password </p>
								<input type="password" value="" name="password2" required>
								<p>Contact No. </p>
								<input type="text" value="" name="contact"  required><br><br>
								<label>Please select Roll No:</label>
								<select name="academic_year">
									<option>SELECT</option>
									<option value="I-EC">I-EC</option>
									<option value="II-EC">II-EC</option>
									<option value="III-EC">III-EC</option>
									<option value="IV-EC">IV-EC</option>
									<option value="V-EC">V-EC</option>
									<option value="VI-EC">VI-EC</option>
								</select required>&nbsp;
								<input type="number" value="" name="roll_no"  min="1" max="150" required><br><br>
								<input type="checkbox" value="" name="checkbox"  required>
								<label for="checkbox">I agree to the <a href="term.vs.privacy.php">terms and Privacy</a></label>
								<div class="sign-up">
									<input type="reset" value="Reset">
									<input type="submit" name="signup"  value="Sign Up" >
									<div class="clear"> </div>
								</div>
							</form>

						</div>';
					}
					?>
						
					</div>
				</div>		
			 <div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
					 	<div class="facts">
							 <div class="login">
							<div class="buttons">
								
								
							</div>
							<form name="login" action="" method="post">
								<input type="text" class="text" name="uemail" value="" placeholder="Enter your registered email"  ><a href="#" class=" icon email"></a>

								<input type="password" value="" name="password" placeholder="Enter valid password"><a href="#" class=" icon lock"></a>

								<div class="p-container">
								
									<div class="submit two">
									<input type="submit" name="login" value="LOG IN" >
									</div>
									<div class="clear"> </div>
								</div>

							</form>
					</div>
				</div> 
			</div> 			        					 
				 <div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
					 	<div class="facts">
							 <div class="login">
							<div class="buttons">
								
								
							</div>
							<form name="login" action="" method="post">
								<input type="text" class="text" name="femail" value="" placeholder="Enter your registered email" required  ><a href="#" class=" icon email"></a>
									
										<div class="submit three">
											<input type="submit" name="send" onClick="myFunction()" value="Send Email" >
										</div>
									</form>
									</div>
				         	</div>           	      
				        </div>	
				     </div>	
		        </div>
	        </div>
	     </div>
</body>
<script src="assets/js/main.js"></script>
</html>
<style>
div.disabled{
	pointer-events: none;
	opacity : 0.5;
}
p.error_msg{
	margin-left : 30px;
	margin-right : 30px;
	text-align: center;
	color: rgb(255,0,0);
	background : rgb(0,0,0);
	opacity : 0.9;
}
</style>