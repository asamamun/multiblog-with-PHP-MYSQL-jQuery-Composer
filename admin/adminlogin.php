<?php
session_start();
// echo $_SESSION['validadmin'];
// exit;
require __DIR__ . '/../vendor/autoload.php';
use App\Database;
$error = false;
if(!isset($_SESSION['validadmin'])){
    $_SESSION['validadmin'] = false;
}
else if($_SESSION['validadmin']==true){
    header("location: index.php");
}
else {}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>WebMag HTML Template</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet"> 

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="../assets/css/bootstrap3.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="../assets/css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="../assets/css/style.css"/>
<!-- open graph start-->
<!-- You can use Open Graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
<meta property="og:url"           content="http://localhost:8080/r37m/jQuery/class12/blog/blog-post.php?id=153" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="Your Website Title" />
<meta property="og:description"   content="Your description" />
<meta property="og:image"         content="http://localhost:8080/r37m/jQuery/class12/blog/assets/articleimages/153_1542429590_8380_thumb.jpg" /> 
<!-- open graph end--> 
<!-- --> 
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
<style>
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<style type="text/css">
    body {
		font-family: 'Varela Round', sans-serif;
	}
	.modal-login {			
		color: #636363;
		width: 350px;
		margin:0 auto;
	}
	.modal-login .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
	}
	.modal-login .modal-header {
		border-bottom: none;   
        position: relative;
        justify-content: center;
	}
	.modal-login h4 {
		text-align: center;
		font-size: 26px;
		margin: 30px 0 -15px;
	}
	.modal-login .form-control:focus {
		border-color: #70c5c0;
	}
	.modal-login .form-control, .modal-login .btn {
		min-height: 40px;
		border-radius: 3px; 
	}
	.modal-login .close {
        position: absolute;
		top: -5px;
		right: -5px;
	}	
	.modal-login .modal-footer {
		background: #ecf0f1;
		border-color: #dee4e7;
		text-align: center;
        justify-content: center;
		margin: 0 -20px -20px;
		border-radius: 5px;
		font-size: 13px;
	}
	.modal-login .modal-footer a {
		color: #999;
	}		
	.modal-login .avatar {
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -70px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: #60c7c1;
		padding: 15px;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.modal-login .avatar img {
		width: 100%;
	}
	.modal-login.modal-dialog {
		margin-top: 80px;
	}
    .modal-login .btn {
        color: #fff;
        border-radius: 4px;
		background: #60c7c1;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
        border: none;
    }
	.modal-login .btn:hover, .modal-login .btn:focus {
		background: #45aba6;
		outline: none;
	}
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
	#loginContainer{
		margin-top:60px;
	}
</style>

    </head>
	<body>

	<?php	
			
	if(isset($_POST['login'])){		
		$conn = new Database();    	
		$uname = htmlentities(strip_tags($_POST['username']),ENT_QUOTES);
		$userInfoResult = $conn->rawQuery("select * from admin where uname='$uname'");
		if($userInfoResult->num_rows == 1){
			$userinfo = $userInfoResult->fetch_assoc();
			if(password_verify($_POST['password'],$userinfo['pass'])){
				$_SESSION['validadmin'] = true;
				$_SESSION['validadmin'] = $userinfo['uname'];
				header("location: index.php");
			}
			else{
			$error = true;	
			}
		}
		else{
$error = true;
		}
		
		
		// 	$message = "<div class=\"alert alert-success alert-dismissable\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
		//   <strong>Error!!</strong> Username or password not  valid.</div>";
		


}
?>

		
<section>
<!-- Modal HTML -->
			
<?php if($error) echo "<div class=\"alert alert-success alert-dismissable\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Error!!</strong> Username or password not  valid.</div>";?>
<div id="loginContainer">
	<div class="modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<div class="avatar">
					<img src="../assets/images/avatar.png" alt="Avatar">
				</div>				
				<h4 class="modal-title">Admin Login</h4>                
			</div>
			<div class="modal-body">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="username" placeholder="Username" required="required" value="fahim">		
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password" required="required" value="admin">	
					</div>        
					<div class="form-group">
						<button type="submit" name="login" class="btn btn-primary btn-lg btn-block login-btn">Login</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="#">Forgot Password?</a>
			</div>
		</div>
	</div>
</div>     


		</section>
		
		<script src="../assets/js/lightbox.js"></script>
		<script src="../assets/js/jquery.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/js/main.js"></script>

	</body>
</html>
