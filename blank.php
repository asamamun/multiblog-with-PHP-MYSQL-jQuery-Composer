<?php
require __DIR__ . '/vendor/autoload.php';
use App\Database;
if(isset($_GET['id'])){
	$conn = new Database();
	
}

?>
<?php require "partials/header.php";?>
    </head>
	<body>
<?php require "partials/mainmenu.php";?>
		
		<?php require "partials/footer.php";?>
		<script src="assets/js/lightbox.js"></script>

	</body>
</html>
