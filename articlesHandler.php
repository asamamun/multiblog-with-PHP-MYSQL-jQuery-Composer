<?php
require __DIR__ . '/vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
$conn = new mysqli("localhost","root","","blog");
$conn->set_charset("utf8");



//show paged article
if(isset($_GET['action'])){
    if($_GET['action'] == "showall"){
        $page = $_GET['page'];
        $size = 10;
        $articleindex = ($page-1)*$size;

$selectQuery = "SELECT `articles`.*,`images`.`imagename`,COUNT(comments.article_id) AS 'totalcomment'
FROM `articles`
LEFT JOIN  comments ON articles.id = comments.article_id
LEFT JOIN `images` ON `articles`.`id` = `images`.`article_id`
where `articles`.`status`='1'
group by articles.id
order by `articles`.`created` desc 
limit $articleindex,$size";

//echo $selectQuery; exit;

$selectQueryResult = $conn->query($selectQuery);
$totalArticles = "select id from articles";
$totalArticlesResult = $conn->query($totalArticles);
$totalRecords = $totalArticlesResult->num_rows;
$totalPage = ceil($totalRecords/$size);
if($selectQueryResult->num_rows > 0){
    $rows = array();
    while ($row = $selectQueryResult->fetch_assoc()) {
       
        $rows[] = $row;
    }
    $data = [
        'total_page'=> $totalPage,
        'record_data'=>$rows
    ];
    echo json_encode($data);
    $selectQueryResult->free();
    //$conn->close();
}
    }    
}

?>