<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bootstrap Material Admin by Bootstrapious.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="../assets/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../assets/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../assets/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <style>
          .singleImageEdit:hover{
            border-bottom:1px solid gray;
          }
        .singleImageEdit span.remove{
          display:inline-block;
          
        }
        </style>
  </head>
  <body>
    <div class="page">
      <?php include "partials/mainnavbar.php"; ?>
      <div class="page-content d-flex align-items-stretch"> 
        <?php include "partials/side-navbar.php";?>
        <div class="content-inner container">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Articles</h2>
            </div>
          </header>
          <section>
          <h3 class="btn btn-primary" id="newArticle">Create a new article</h3>
            <div id="formContainer" class="container">            
            <div class="sign-up">
                <h3 class="tittle reg">New Article Form <i class="glyphicon glyphicon-user"></i></h3>
        <form method="post" id="articleForm" name="articleForm" enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="">
        <input type="hidden" name="hart_id" id="hart_id" value="">
        <div class="form-group row">
    <label for="atitle" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="atitle" name="atitle" placeholder="title">
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
      <input type="text" class="form-control" id="atags" name="atags" placeholder="title">
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
    <input type="button" class="btn btn-primary" value="Update Article" id="updatearticle" name="updatearticle">
    <input type="button" class="btn btn-info" value="Close" id="closeArticle">
    </div>
    </div>

 
      </form>
            </div>
            </div>
        <div id="articlesContainer" class="table-responsive">
<table class="table table-hover">
  <thead>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Details</th>
    <th>User</th>
    <th>Tags</th>
    <th>Status</th>
    <th>Create time</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>
            </div>
            <div id="paginationContainer"></div>
          </section>
 


          <?php include "partials/footer.php"; ?>
        </div>
      </div>
    </div>
    <!-- JavaScript files-->    
    <script src="../assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/js/jQueryForm.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/jquery.cookie/jquery.cookie.js"> </script>    
    <script src="../assets/vendor/jquery-validation/jquery.validate.min.js"></script>
    
    <!-- Main File-->
    <script src="../assets/js/front.js"></script>
    <script>
    $(document).ready(function () {
      $("#formContainer").hide();
      $("#newArticle").click(function(){
        $("#createarticle").show();
        $("#updatearticle").hide();
        $("#formContainer").fadeIn(500);
      });
      $("#closeArticle").click(function(){
        $("#formContainer").fadeOut(500);
        $("#articleForm")[0].reset();
        $("#createarticle").show();
        $("#updatearticle").hide();
        $("#articleImages").empty();
        $("#action").val('');
        $("#hart_id").val('');
      });
      //function show_json_data start
function show_json_data(d){
  $tr = "";
  $.each(d, function (indexInArray, data) { 
     //console.log(data.title);
     $tr += "<tr><td>"+ data.id+"</td><td>"+ data.title+"</td><td>"+ data.details+"</td><td>"+ data.user_id+"</td><td>"+ data.tags+"</td><td>"+ data.status+"</td><td>"+ data.created+"</td><td><a class='edit' href='javascript:void(0)' data-id="+data.id+"><i class='fa fa-edit'></i><a> <a class='delete' href='javascript:void(0)' data-id="+data.id+"><i class='fa fa-trash'></i><a></td></tr>";
     //alert($tr);  
  });
  $("#articlesContainer table tbody").html($tr);
}
      //function show_json_data end

      // 
      function createpagination(page,current){
        //Previous
        if (current == "1") {
            $pagination = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center"><li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a>    </li>';
        }
        else{
          $pagination = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center"><li class="page-item"><a class="page-link" href="#" data-pagenum="'+(current-1)+'" tabindex="-1">Previous</a></li>'; 
        }
        for (let index = 1; index <= page; index++) {
          if (Math.abs(current-index) <= 3) {
              if (index == current) {
                  $pagination += '<li class="page-item active"><a class="page-link" href="javascript:void(0)" data-pagenum='+index+'>'+index+'</a></li>';
              } else {
                  $pagination += '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-pagenum='+index+'>'+index+'</a></li>';
              }
          }
          
        }
        //Next
        if(page == current){
          $pagination += '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li></ul></nav>';
 $("#paginationContainer").html($pagination);
        }
        else{
          $pagination += '<li class="page-item"><a class="page-link" href="#">Next</a></li></ul></nav>'; 
        }
        $("#paginationContainer").html($pagination);
      }

      $("#paginationContainer").on("click","a.page-link",function(){
// $pagenum = $(this).data("pagenum");
get_articles($(this).data("pagenum"));
      });
      // 
      
      //function get_articles start
      function get_articles(p){
      $.getJSON("articlesHandler.php", {
        action: "showall",
        page: p
      },
        function (data, textStatus, jqXHR) {
          console.log(data);
          show_json_data(data.record_data);
          createpagination(data.total_page,p);
        }
      );
    }
//create articles start
$("#createarticle").click(function(e){
e.preventDefault();
$("#action").val("create");
//console.log($('#articleForm').serialize());
        //start
        $('#articleForm').ajaxSubmit({ //FormID - id of the form.
        type: "POST",
        url: "articlesHandler.php",
        data: $('#articleForm').serialize(),
        cache: false,
        success: function (response) {
      alert(response); 
      get_articles(1);
      $("#articleForm")[0].reset();    
        }
    });
		
});
//create articles end
//delete articles start
$("#articlesContainer").on("click","a.delete",function(){
if(!confirm("Are you sure?")) return;
$.post("articlesHandler.php",{
  action:"delete",
  articleid: $(this).data('id')
},function(d){
if(d != "error"){
  alert(d);
  get_articles(1);
}
});
});
//delete articles end
//edit articles start
$("#articlesContainer").on("click","a.edit",function(){
  $("#createarticle").hide();
  $("#updatearticle").show();
  $idtoedit = $(this).data('id');
  $("#hart_id").val($idtoedit);
  $("#action").val("update");
  $("#formContainer").fadeIn(500);
  $.post("articlesHandler.php",{
    action:'edit',
    idtoedit:$idtoedit
  },function(d){
    d= JSON.parse(d);
//console.log(d.imageinfo);
populateForm(d);
  });
  //alert($idtoedit);

});
//edit articles end
//update articles start
$("#updatearticle").click(function(e){
e.preventDefault();
$("#action").val("update");
//console.log($('#articleForm').serialize());
//return;
        //start
        $('#articleForm').ajaxSubmit({ //FormID - id of the form.
        type: "POST",
        url: "articlesHandler.php",
        data: $('#articleForm').serialize(),
        cache: false,
        success: function (response) {
      alert(response); 
      get_articles(1);
      $("#articleForm")[0].reset();    
        }
    });
		
});
//update articles end

//populateform start
function populateForm(data){
  $articleinfo = data.articleinfo;
  $imageinfo = data.imageinfo;
  $("#atitle").val($articleinfo.title);
  $("#adetails").val($articleinfo.details);
  $("#atags").val($articleinfo.tags);
  $("#astatus").val($articleinfo.status);
  // articleImages
  if($imageinfo.length){
    $imagestoshow = "";
    $imageinfo.forEach(element => {
      //console.log(element.imagename);
      $imagestoshow += "<div class='singleImageEdit d-inline-block' style='position:relative'><img src='../assets/articleimages/"+element.imagename+"' class='img-thumbnail' width='100px'><span class='remove' data-imageid='"+element.id+"' data-imagename='"+element.imagename+"'><i class='fa fa-times'></i><span></div>";
    });
    $("#articleImages").html($imagestoshow);
  }
  else{
    $("#articleImages").html("");
  }

window.location.hash="#formContainer";
}
//populateform end
//delete image start
$("#formContainer").on("click","span.remove",function(){
  $imagetodelete = $(this);
  
  $.post("articlesHandler.php",{
    action:"deleteimage",
    id: $imagetodelete.data("imageid"),
    name: $imagetodelete.data("imagename")
  },function(d){
    if(d != "error"){
      $imagetodelete.parent().fadeOut(700).remove();
    }
alert(d);

  });
});
//delete image end


    ////function get_articles end
    get_articles(1);

    });
    </script>
  </body>
</html>