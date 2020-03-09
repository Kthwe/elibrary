<?php
$success = "";
$error_message = "";
$conn = mysqli_connect("localhost","root","","loginsystem");
if(!empty($_POST["submit_email"])) {
	$result = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $_POST["email"] . "'");
	$count  = mysqli_num_rows($result);
	if($count>0) {
		$validy = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $_POST["email"] . "' AND user_email_status = 'verified'");
		$vCount  = mysqli_num_rows($validy);
		if($vCount>0){
			$error_message = "Email is already verified";
		}else{
		// generate OTP
		$otp = rand(100000,999999);
		// Send OTP
		require_once("mail_function.php");
		$mail_status = sendOTP($_POST["email"],$otp);
		if($mail_status == 1) {
			$result = mysqli_query($conn,"UPDATE users SET otp = $otp WHERE  email= '" . $_POST["email"] . "'");
			if($result > 0) {
				$success=1;
			}
		}}
	} else {
		$error_message = "Email not exists!";
	}
}
if(!empty($_POST["submit_otp"])) {
	$result = mysqli_query($conn,"SELECT * FROM users WHERE otp='" . $_POST["otp"] . "'");
	$count  = mysqli_num_rows($result);
	if(!empty($count)) {
		foreach($result as $row)
		{
			if($row['user_email_status'] == 'not verified'){
			$result = mysqli_query($conn,"UPDATE users SET user_email_status = 'verified'  WHERE otp = '" . $_POST["otp"] . "'");
			if($result){
				$result = mysqli_query($conn,"UPDATE users SET otp=NULL WHERE otp = '" . $_POST["otp"] . "'");
				$success = 2;
			}else{
				$error_message = "Failed to delete OTP!";
			}
			}
			else{
				echo "email is already verified.";
			}
		}
	} else {
		$success =1;
		$error_message = "Invalid OTP!";
	}	
}
if(!empty($_POST["time_out"])) {

	$error_message = "OTP Time Out!";

}
?>
<html>
<head>
<title>User Login</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
body{
	font-family: calibri;
}
.tblLogin {
	margin-top: 100px;
	margin-left: 30%;
	margin-right: 30%;
	border: #95bee6 1px solid;
    background: #d1e8ff;
    border-radius: 4px;
    max-width: 300px;
	padding:20px 30px 30px;
	text-align:center;
}
.tableheader { font-size: 20px; }
.tablerow { padding:15px; }
.error_message {
	color: #b12d2d;
    background: #ffb5b5;
    border: #c76969 1px solid;
}
.message {
	width: 100%;
    max-width: 300px;
    padding: 10px 30px;
    border-radius: 4px;
    margin-bottom: 5px;   
	margin-left  : 100px; 
}
.login-input {
	border: #CCC 1px solid;
    padding: 10px 20px;
	border-radius:4px;
}
.btnSubmit {
	padding: 10px 20px;
    background: #2c7ac5;
    border: #d1e8ff 1px solid;
    color: #FFF;
	border-radius:4px;
}
</style>
</head>
<body>
	<?php
		if(!empty($error_message)) {
	?>
	<div class="message error_message"><?php echo $error_message; ?></div>
	<?php
		}
	?>

<form name="frmUser" method="post" action="">
	<div class="tblLogin">
		<?php 
			if(!empty($success == 1)) {
		?>
		<div class="tableheader">Enter OTP</div>
		<p style="color:#31ab00;">Check your email for the OTP</p>
			
		<div class="tablerow">
			<input type="text" name="otp" placeholder="One Time Password" class="login-input" required>
		</div>
		<div>Remaining = <span id="timer"></span></div>
		<div class="tableheader"><input type="submit" name="submit_otp" value="Submit" class="btnSubmit"></div>
		<?php 
			} else if ($success == 2) {
        ?>
		<p style="color:#31ab00;">Welcome, You have successfully verified!</p>
		<?php
			}
			else {
		?>
		
		<div class="tableheader">Enter Your Login Email</div>
		<div class="tablerow"><input type="text" name="email" placeholder="Enter Your Registered e-mail" class="login-input" required></div>
		<div class="tableheader"><input type="submit" name="submit_email" value="Submit" class="btnSubmit"></div>
		<?php 
			}
		?>
	</div>
</form>
</body></html>
<script>
let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML = m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  	document.body.innerHTML += '<form id="customForm" action="" method="post"><input type="hidden" name="time_out" value="Submit"></form>';
	document.getElementById("customForm").submit();

}

timer(60);
</script>