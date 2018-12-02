<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use App\Database;
$conn = new Database();
$conn->table_name = "categories";
$allcats = $conn->get_all();
?>
<?php require "partials/header.php";?>
    </head>
	<body>
	
	<?php		
			require("partials/mainmenu.php");		
	?>

		<!-- section -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">	
					<!-- post -->
					<div class="col-md-6">
						<div class="post post-thumb">
							<a class="post-img" href="blog-post.html"><img src="assets/img/post-1.jpg" alt=""></a>
							<div class="post-body">
								<div class="post-meta">
									<a class="post-category cat-2" href="category.html">JavaScript</a>
									<span class="post-date">March 27, 2018</span>
								</div>
								<h3 class="post-title"><a href="blog-post.html">Chrome Extension Protects Against JavaScript-Based CPU Side-Channel Attacks</a></h3>
							</div>
						</div>
					</div>
					<!-- /post -->

					<!-- post -->
					<div class="col-md-6">
						<div class="post post-thumb">
							<a class="post-img" href="blog-post.html"><img src="assets/img/post-2.jpg" alt=""></a>
							<div class="post-body">
								<div class="post-meta">
									<a class="post-category cat-3" href="category.html">Jquery</a>
									<span class="post-date">March 27, 2018</span>
								</div>
								<h3 class="post-title"><a href="blog-post.html">Ask HN: Does Anybody Still Use JQuery?</a></h3>
							</div>
						</div>
					</div>
					<!-- /post -->
				</div>
				<!-- /row -->

				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="section-title">
							<h2>Recent Posts</h2>
						</div>
					</div>
					<div class="col-md-12">
						<div class="section-title">
							<h2>All Categories:</h2>
							<ul class="list-unstyled list-inline">
							<?php
                            foreach ($allcats as $cat) {
                                if ($cat['id'] != '1') {
                                    echo '<li class="list-inline-item"><a href="category.php?id='.$cat['id'].'">'.$cat['name'].'</a></li>';
                                }
                            }
							?>
							</ul>
						</div>
					</div>

					<!-- post -->
					<div id="allpost"></div>
					<!-- /post -->

					
				</div>
				<!-- /row -->

			<div id="paginationContainer" class='text-center'></div>
		<?php require "partials/footer.php";?>
	</body>

   <script>
    $(document).ready(function () {




//function show_json_data start
function show_json_data(d){
  $allnews = "";
  $.each(d, function (indexInArray, data) { 
     //console.log(data.title);
     $allnews +='<div class="col-md-4"><div class="post"><a class="post-img" href="blog-post.php?id='+data.id+'"><img src="assets/articleimages/'+data.imagename+'" alt=""></a><div class="post-body"><div class="post-meta"><a class="post-category cat-1" href="category.html">Web Design</a><span class="post-date">March 27, 2018</span></div><h3 class="post-title"><a href="blog-post.php?id='+data.id+'">'+data.title+'</a></h3></div></div></div>';


  });
  $("#allpost").html($allnews);
  $("img").on("error",function(){
    $(this).replaceWith("<img src='assets/image-not-found.gif' alt='image not found' title='image not found'>");
});
}
      //function show_json_data end





		// pagenation start
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
		  get_articles($(this).data("pagenum"));
      });
	  //
	  
	  

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





	  get_articles(1);

$("img").on("error",function(){
    $(this).replaceWith("<img src='assets/image-not-found.gif' alt='image not found' title='image not found'>");
});

	});
    </script>
</html>
