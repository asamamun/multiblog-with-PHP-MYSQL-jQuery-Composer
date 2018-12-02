<?php
require __DIR__ . '/../vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
$conn = new mysqli("localhost","root","","blog");
$conn->set_charset("utf8");


// delete categories start
if (isset($_POST['action'])) {
    if ($_POST['action'] == "delete") {
        $idtodelete =$conn->escape_string($_POST['catid']);
        $deleteQuery = "delete from `categories` where id='$idtodelete' limit 1";
        $conn->query($deleteQuery);
        if($conn->affected_rows == 1){
            echo "Category Deleted!!";
        }
        else{
            echo "error";
        }
    }
}
// delete categories end



// edit categories start
if (isset($_POST['action'])) {
    if ($_POST['action'] == "edit") {
        $idtoedit =$conn->escape_string($_POST['idtoedit']);
        $singleQuery = "select * from `categories` where id='$idtoedit' limit 1";
        $singleQueryResult = $conn->query($singleQuery);
        $row = $singleQueryResult->fetch_assoc();      
        $info = array();
        $info['catinfo'] = $row;
        //$info['imageinfo'] = $imagerows;
echo json_encode($info);
        
    }
}
// edit categories end


//show paged categories
if(isset($_GET['action'])){
    if($_GET['action'] == "showall"){
        $page = $_GET['page'];
        $size = 10;
        $articleindex = ($page-1)*$size;
$selectQuery = "select * from `categories` order by created desc limit $articleindex,$size";
$selectQueryResult = $conn->query($selectQuery);
$totalCat = "select id from `categories`";
$totalCatResult = $conn->query($totalCat);
$totalRecords = $totalCatResult->num_rows;
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
}
    }    
}
//show categories end


//add categories start
if(isset($_POST['action'])){
    if ($_POST['action'] == "create") {
        $n = $conn->escape_string($_POST['catname']);
        $d = $conn->escape_string($_POST['cdetails']);
		$pid = 1;
        $articleInsert = "insert into `categories` values(NULL,'$n','$d','$pid',CURRENT_TIMESTAMP,NULL)";     
        $conn->query($articleInsert);
        if($conn->affected_rows == 1){
$articleid = $conn->insert_id;        
  
        echo "Category Added";
}
      
    }
}
//add categories end


//update start
if(isset($_POST['action'])){
    if ($_POST['action'] == "update") {
        $id = $conn->escape_string($_POST['hart_id']);
        $t = $conn->escape_string($_POST['catname']);
        $d = $conn->escape_string($_POST['cdetails']);        
        $catUpdate = "UPDATE `categories` SET 
        `name` = '$t',
        `details` = '$d',        
        `updated` = CURRENT_TIMESTAMP        
         WHERE `categories`.`id` = '$id'";

        $conn->query($catUpdate);
        if($conn->affected_rows == 1){
			$articleid = $id;        

        echo "Category Updated";
}        
    }
}
//update end
?>