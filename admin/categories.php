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
              <h2 class="no-margin-bottom">Categories</h2>
            </div>
          </header>
          <section>
          <h3 class="btn btn-primary" id="newCat">Add Categories</h3>
            <div id="formContainer" class="container">            
            <div class="sign-up">
                <h3 class="tittle reg">Add Category Form <i class="glyphicon glyphicon-user"></i></h3>
        <form method="post" id="catForm" name="catForm" enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="">
        <input type="hidden" name="hart_id" id="hart_id" value="">
        <div class="form-group row">
    <label for="atitle" class="col-sm-2 col-form-label">Category_Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="catname" name="catname" placeholder="Category">
    </div>
    </div> 
    <div class="form-group row">
    <label for="adetails" class="col-sm-2 col-form-label">Details</label>
    <div class="col-sm-10">
      <textarea id="cdetails" name="cdetails" class="form-control"></textarea>
    </div>
</div>
     <div class="form-group row">
    <label for="" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
    <input type="submit" class="btn btn-primary" value="Add" id="createcat" name="createcat">
    <input type="button" class="btn btn-primary" value="Update Category" id="updatecat" name="updatecat">
    <input type="button" class="btn btn-info" value="Close" id="closeCat">
    </div>
    </div>

 
      </form>
            </div>
            </div>
<div id="catContainer" class="table-responsive">
<table class="table table-hover">
  <thead>
  <tr>
    <th>ID</th>
    <th>Categorie_Name</th>
    <th>Details</th>
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
      $("#newCat").click(function(){
        $("#createcat").show();
        $("#updatecat").hide();
        $("#formContainer").fadeIn(500);
      });
      $("#closeCat").click(function(){
        $("#formContainer").fadeOut(500);
        $("#catForm")[0].reset();
        $("#createcat").show();
        $("#updatecat").hide();  
        $("#action").val('');
        $("#hart_id").val('');
      });
		
		
      //function show_json_data start
function show_json_data(d){
  $tr = "";
  $.each(d, function (indexInArray, data) { 
     //console.log(data.title);
     $tr += "<tr><td>"+ data.id+"</td><td>"+ data.name+"</td><td>"+ data.details+"</td><td>"+ data.created+"</td><td><a class='edit' href='javascript:void(0)' data-id="+data.id+"><i class='fa fa-edit'></i><a> <a class='delete' href='javascript:void(0)' data-id="+data.id+"><i class='fa fa-trash'></i><a></td></tr>";
     //alert($tr);  
  });
  $("#catContainer table tbody").html($tr);
}
      //function show_json_data end
		

//      pagenation start
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
get_categories($(this).data("pagenum"));
      });
//		pagenation end
      
      
      //function get_categories start
      function get_categories(p){
      $.getJSON("categoriesHandler.php", {
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
//function get_categories end
		
		
//Add categories start
$("#createcat").click(function(e){
e.preventDefault();
$("#action").val("create");
        $('#catForm').ajaxSubmit({ //FormID - id of the form.
        type: "POST",
        url: "categoriesHandler.php",
        data: $('#catForm').serialize(),
        cache: false,
        success: function (response) {
		  alert(response); 
		  get_categories(1);
		  $("#catForm")[0].reset();    
        }
    });
		
});
//Add categories end
		
		
//delete categories start
$("#catContainer").on("click","a.delete",function(){
if(!confirm("Are you sure?")) return;
$.post("categoriesHandler.php",{
  action:"delete",
  catid: $(this).data('id')
},function(d){
if(d != "error"){
  alert(d);
  get_categories(1);
}
});
});
//delete categories end
		
		
//edit categories start
$("#catContainer").on("click","a.edit",function(){
  $("#createcat").hide();
  $("#updatecat").show();
  $idtoedit = $(this).data('id');
  $("#hart_id").val($idtoedit);
  $("#action").val("update");
  $("#formContainer").fadeIn(500);
  $.post("categoriesHandler.php",{
    action:'edit',
    idtoedit:$idtoedit
  },function(d){
    d= JSON.parse(d);
//console.log(d.imageinfo);
populateForm(d);
  });  

});
//edit categories end
		
		
//update categories start
$("#updatecat").click(function(e){
e.preventDefault();
$("#action").val("update");
        $('#catForm').ajaxSubmit({ //FormID - id of the form.
        type: "POST",
        url: "categoriesHandler.php",
        data: $('#catForm').serialize(),
        cache: false,
        success: function (response) {
      alert(response); 
      get_categories(1);
      $("#catForm")[0].reset();    
        }
    });
		
});
//update categories end
		

//populateform start
function populateForm(data){
  $catinfo = data.catinfo;
  $("#catname").val($catinfo.name);
  $("#cdetails").val($catinfo.details);  


window.location.hash="#formContainer";
}
//populateform end
		
		



    ////function get_articles end
    get_categories(1);

    });
    </script>
  </body>
</html>