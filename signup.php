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
<?php
require __DIR__ . '/vendor/autoload.php';
use App\Database;
$error = FALSE;
$message = "";
if(isset($_POST['register'])){
	$conn = new Database();
	$username = $conn->clean($_POST['username']);
	$usermail = $conn->clean($_POST['email']);
	$userpass1 = $_POST['password'];
	$userpass2 = $_POST['confirm_password'];
	if(trim($username) == '' || trim($usermail) == '' || $userpass1=='' || $userpass2 == ''){
		$error = TRUE;
		$message = "Please fill all the fields!!";
	}
	elseif( $userpass1 !== $userpass2){
		$error = TRUE;
		$message = "Password Mismatched!!";
	}
	else{
		$conn->table_name = "users";
		$data = [
			'username'=>$username,
			'useremail'=>$usermail,
			'userpass'=>password_hash($userpass1,PASSWORD_BCRYPT),
			'status'=>'1'
		];
		if($conn->create($data)){
			$message = "Account Created!!";
		}
		
	}
}
?>
<?php require "partials/header.php";?>
<style type="text/css">
	body {
		color: #fff;		
		font-family: 'Roboto', sans-serif;
	}
	.form-control, .form-control:focus, .input-group-addon {
		border-color: #e1e1e1;
	}
    .form-control, .btn {        
        border-radius: 3px;
    }
	.signup-form {
		width: 390px;
		margin: 0 auto;
		padding: 30px 0;
	}
    .signup-form form {
		color: #999;
		border-radius: 3px;
    	margin-bottom: 15px;
        background: #fff;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
	.signup-form h2 {
		color: #333;
		font-weight: bold;
        margin-top: 0;
    }
    .signup-form hr {
        margin: 0 -30px 20px;
    }
	.signup-form .form-group {
		margin-bottom: 20px;
	}
	.signup-form label {
		font-weight: normal;
		font-size: 13px;
	}
	.signup-form .form-control {
		min-height: 38px;
		box-shadow: none !important;
	}	
	.signup-form .input-group-addon {
		max-width: 42px;
		text-align: center;
	}
	.signup-form input[type="checkbox"] {
		margin-top: 2px;
	}   
    .signup-form .btn{        
        font-size: 16px;
        font-weight: bold;
		background: #19aa8d;
		border: none;
		min-width: 140px;
    }
	.signup-form .btn:hover, .signup-form .btn:focus {
		background: #179b81;
        outline: none;
	}
	.signup-form a {
		color: #fff;	
		text-decoration: underline;
	}
	.signup-form a:hover {
		text-decoration: none;
	}
	.signup-form form a {
		color: #19aa8d;
		text-decoration: none;
	}	
	.signup-form form a:hover {
		text-decoration: underline;
	}
	.signup-form .fa {
		font-size: 21px;
	}
	.signup-form .fa-paper-plane {
		font-size: 18px;
	}
	.signup-form .fa-check {
		color: #fff;
		left: 17px;
		top: 18px;
		font-size: 7px;
		position: absolute;
	}
</style>

    </head>
	<body>
<?php require "partials/mainmenu.php";?>
		<section>
		<div class="signup-form">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<h2>Sign Up</h2>
		<?php
		if($error){
echo "<div class='text-danger'>$message</div>";
		}
		else {
			echo "<div class='text-info'>$message</div><p>Please fill in this form to create an account!</p>";
		}
		?>
				
		<hr>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" class="form-control" name="username" placeholder="Username" required>
			</div>
        </div>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
				<input type="email" class="form-control" name="email" placeholder="Email Address" required>
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="text" class="form-control" name="password" placeholder="Password" required>
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-lock"></i>
					<i class="fa fa-check"></i>
				</span>
				<input type="text" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
			</div>
        </div>
        <div class="form-group">
			<label class="checkbox-inline"><input type="checkbox" required> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
		</div>
		<div class="form-group">
            <button type="submit" name="register" class="btn btn-primary btn-lg">Sign Up</button>
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="#">Login here</a></div>
</div>

		</section>
		<?php require "partials/footer.php";?>
		<script src="assets/js/lightbox.js"></script>

	</body>
</html>
