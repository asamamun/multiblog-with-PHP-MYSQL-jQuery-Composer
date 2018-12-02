<?php
require __DIR__ . '/vendor/autoload.php';
use App\Database;
use App\Session;
use Intervention\Image\ImageManagerStatic as Image;
$conn = new Database();
$userinfo = Session::user();
if(!$userinfo){
	header("location: login.php");
}
//get all categories
$conn->table_name = "categories";
$all_cat = $conn->get_all();
//var_dump($all_cat);
//exit;
if(isset($_POST['createarticle'])){   
	$conn->table_name = "articles";
	$data = [
		'title'=>$conn->clean($_POST['atitle']),
		'details'=>$conn->clean($_POST['adetails']),
		'user_id'=>$userinfo['userid'],
		'tags'=>$conn->clean($_POST['atags']),
		'status'=>'1'
	];
    $articleid = $conn->create($data);
     //add categories to articles_categories table
     $cats = isset($_POST['acat'])?$_POST['acat']:['1']; 
     $conn->table_name = "articles_categories";
     foreach ($cats as $key => $cat) {
         $data = [
             'article_id'=>$articleid,
             'category_id'=>$cat,
         ];         
         $conn->create($data);
     } 
     //add categories to articles_categories table end
    

    if($articleid){
		if (isset($_FILES['articleimages'])) {
            $allfiles = $_FILES['articleimages'];
            $allfilenamesArr = $allfiles['name'];
            $allfiletypesArr = $allfiles['type'];
            $allfilesizesArr = $allfiles['size'];
            $allfiletmpnamesArr = $allfiles['tmp_name'];
            $allfileerrorArr = $allfiles['error'];
            $totalfiles = count($allfilenamesArr);
            for ($i = 0; $i < $totalfiles; $i++) {
                $r = $articleid."_".time()."_".rand(1000,9999);
                $filename = $r.".jpg";
                $filename_thumb = $r."_thumb.jpg";

                if(move_uploaded_file($allfiletmpnamesArr[$i], "assets/articleimages/".$filename)){
                //
                // open and resize an image file
$img = Image::make("assets/articleimages/".$filename)->resize(800,null,function ($constraint) {
    $constraint->aspectRatio();
//})->insert('assets/images/logo.png','center');
});
$img->save(null,60);
$img = Image::make("assets/articleimages/".$filename)->resize(120,null,function ($constraint) {
    $constraint->aspectRatio();
//})->insert('assets/images/logo.png','center');
});
$img->save("assets/articleimages/".$filename_thumb,90);

                //    
				$articleImageQuery = "insert into images values(NULL,'$filename','','$articleid',CURRENT_TIMESTAMP,NULL)";
				$conn->rawQuery($articleImageQuery);
                //$conn->query($articleImageQuery);
                }
            }
            
        }
		Session::setSessionData("flashmessage","Articles Created");
		header("location:create.php");
		exit;
	}	
}

?>
<?php require "partials/header.php";?>
<link rel="stylesheet" href="assets/css/bootstrap-chosen.css">
</head>
<body>
<?php require "partials/mainmenu.php";?>
<?php if(Session::checkSession('flashmessage')){
    ?>
<div class="container">
<div class="jumbotron">
<h3><?php echo Session::getFlashData('flashmessage'); ?></h3>
</div>
</div>
<?php
}
?>
<section>
<div id="formContainer" class="container">            
            <div class="sign-up">
        
        <form method="post" id="articleForm" name="articleForm" enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="">
        <input type="hidden" name="hart_id" id="hart_id" value="">
        <div class="form-group row">
    <label for="atitle" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="atitle" name="atitle" placeholder="title" tabindex="1">
    </div>
    </div> 
    <div class="form-group row">
    <label for="adetails" class="col-sm-2 col-form-label">Details</label>
    <div class="col-sm-10">
      <textarea id="adetails" name="adetails" class="form-control"></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="atags" class="col-sm-2 col-form-label">Tags</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="atags" name="atags" placeholder="title" tabindex="2">
    </div>
    </div>
    <div class="form-group row">
    <label for="astatus" class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10">
    <select id="astatus" name="astatus" class="form-control">
                            <option value="0">Draft</option>
                            <option value="1" selected>Published</option>
                        </select>
    </div>
	</div> 
	<div class="form-group row">
    <label for="acat" class="col-sm-2 col-form-label">Categories</label>
    <div class="col-sm-10">
        <select data-placeholder="Choose Categories" name="acat[]" multiple class="chosen-select form-control" tabindex="8">
              <option value=""></option>
				<?php
					foreach($all_cat as $k=>$cat){
                        if($cat['id'] == 1){
                            echo '<option value="'.$cat['id'].'" selected>'.$cat['name'].'</option>';
                        }
                        else{
                            echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                        }
								
					}
					?>
            </select>
       </div>
    </div>
		
		<!--  -->
    
   
    <div class="form-group row">
    <label for="aimages" class="col-sm-2 col-form-label">Images</label>
    <div class="col-sm-10">
    <input type="file"  class="form-control" name="articleimages[]" multiple>
    </div>
    </div> 
    <div class="form-group row">    
    <div class="col-sm-12" id="articleImages">
    
    </div>
    </div>

        <div class="form-group row">
    <label for="" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
    <input type="submit" class="btn btn-primary" value="Create Article" id="createarticle" name="createarticle">
    <input type="reset" class="btn btn-info" value="Clear" id="clearArticle">
    </div>
    </div>

 
      </form>
            </div>
            </div>
</section>
<?php require "partials/footer.php";?>
<script src="assets/js/lightbox.js"></script>
<script src="assets/js/chosen.jquery.js"></script>
<script>
$(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        //create article
//         $("#createarticle").click(function(e){
//             e.preventDefault();
//             var data = new FormData();
//             $.each($("input[type='file']")[0].files, function(i, file) {
//     data.append('file', file);
// });
// console.log(data);
//ajax start
// $.ajax({
//     type: 'POST',
//     url: 'createHandler.php',
//     cache: false,
//     contentType: false,
//     processData: false,
//     data : data,
//     success: function(result){
//         console.log(result);
//     },
//     error: function(err){
//         console.log(err);
//     }
// })
//ajax end
        //})
      });
</script>
	</body>
</html>
