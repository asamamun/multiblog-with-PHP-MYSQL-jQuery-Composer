<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use App\Database;
$conn = new Database();
if(isset($_GET['id'])){
    $id = $conn->clean($_GET['id']);
    $conn->table_name = "articles_categories";
   $results = $conn->get_all_where('category_id='.$id);
   if (count($results)) {
       $articlesArr = [];
       foreach ($results as $result) {
           //echo "<h3>".$result['article_id']."</h3>";
           $articlesArr[] = $result['article_id'];
       }
       $articlesInString = implode(",",$articlesArr);
       $sql = "
SELECT `articles`.*,`images`.`imagename`,COUNT(comments.article_id) AS 'totalcomment'
FROM `articles`
LEFT JOIN  comments ON articles.id = comments.article_id
LEFT JOIN `images` ON `articles`.`id` = `images`.`article_id`
where `articles`.`id` in (".$articlesInString.") and `articles`.`status`='1'
group by articles.id
order by `articles`.`created` desc";
$sqlresult = $conn->rawQuery($sql);
   }

}
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
				

					<!-- post -->
					<?php
					
                    while($singlearticle = $sqlresult->fetch_assoc()){
    echo '<div class="col-md-4"><div class="post"><a class="post-img" href="blog-post.php?id='.$singlearticle['id'].'"><img src="assets/articleimages/'.$singlearticle['imagename'].'" alt=""></a><div class="post-body"><div class="post-meta"><a class="post-category cat-1" href="category.html">Web Design</a><span class="post-date">March 27, 2018</span></div><h3 class="post-title"><a href="blog-post.php?id='.$singlearticle['id'].'">'.$singlearticle['title'].'</a></h3></div></div></div>';

}
					
					?>
					<!-- /post -->

					
				</div>
				<!-- /row -->

			

		<?php require "partials/footer.php";?>
	</body>
</html>
