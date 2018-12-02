<?php
session_start();
if(!isset($_SESSION['validuser'])){
    $_SESSION['validuser'] = false;
}
else if($_SESSION['validuser']==true){
    header("location: index.php");
}
else {}
?>
<?php require "partials/header.php";?>
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
		$conn = new mysqli("localhost","root","","blog");
    	
    	$uname = htmlentities(strip_tags($_POST['username']),ENT_QUOTES);
		$password = $_POST['password'];
		//$pass = password_hash($passtoconvert,PASSWORD_BCRYPT);	
   		//$selectquery = "select * from users where username='$uname' and userpass='$pass'";
    	$selectquery = "select * from users where username='$uname' limit 1";
		  
		$selectqueryResult =  $conn->query($selectquery);
        if ($selectqueryResult->num_rows == 1) {
            $row = $selectqueryResult->fetch_array();
        
            $passfromdatabase = $row['userpass'];
        
        
            if (password_verify($password, $passfromdatabase)) {
                $_SESSION['validuser'] = true;
				$_SESSION['username'] = $row['username'];
				$_SESSION['userid'] = $row['id'];
				
                header("location: index.php");
            } else {
                $message = "<div class=\"alert alert-success alert-dismissable\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
		  <strong>Error!!</strong> Username or password not valid.</div>";
            }
		}
		else{
			$message = "<div class=\"alert alert-success alert-dismissable\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
		  <strong>Error!!</strong> Username  not valid.</div>";
		}


}
?>
<?php require "partials/mainmenu.php";?>
		
<section>
<!-- Modal HTML -->
			
<?php if(isset($message)) echo "<h2 class='text-center text-success'>$message</h2>";?>
<div id="loginContainer">
	<div class="modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<div class="avatar">
					<img src="assets/images/avatar.png" alt="Avatar">
				</div>				
				<h4 class="modal-title">Member Login</h4>                
			</div>
			<div class="modal-body">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="username" placeholder="Username" required="required">		
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password" required="required">	
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
		<?php require "partials/footer.php";?>
		<script src="assets/js/lightbox.js"></script>

	</body>
</html>
