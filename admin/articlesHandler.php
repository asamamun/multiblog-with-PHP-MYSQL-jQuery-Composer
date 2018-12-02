<?php
require __DIR__ . '/../vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
$conn = new mysqli("localhost","root","","blog");
$conn->set_charset("utf8");
// delete article
if (isset($_POST['action'])) {
    if ($_POST['action'] == "delete") {
        $idtodelete =$conn->escape_string($_POST['articleid']);
        
        $deleteQuery = "delete from articles where id='$idtodelete' limit 1";
        $conn->query($deleteQuery);
        if($conn->affected_rows == 1){
            echo "Article Deleted!!";
        }
        else{
            echo "error";
        }
    }
}
// delete article image
if (isset($_POST['action'])) {
    if ($_POST['action'] == "deleteimage") {
        $idtodelete =$conn->escape_string($_POST['id']);
        $imagename =$conn->escape_string($_POST['name']);
        $deleteQuery = "delete from images where id='$idtodelete' limit 1";
        $conn->query($deleteQuery);
        if($conn->affected_rows == 1){
            $imagelocation = "../assets/articleimages/".$imagename;
            if(is_file($imagelocation)){
                unlink($imagelocation);
            }
            echo "Image Deleted!!";
        }
        else{
            echo "error";
        }
    }
}

// edit article
if (isset($_POST['action'])) {
    if ($_POST['action'] == "edit") {
        $idtoedit =$conn->escape_string($_POST['idtoedit']);
        $singleQuery = "select * from articles where id='$idtoedit' limit 1";
        $singleQueryResult = $conn->query($singleQuery);
        $row = $singleQueryResult->fetch_assoc();
        //get image info
        $imageQuery = "select * from images where article_id='$idtoedit'";
        $imageQueryResult = $conn->query($imageQuery);
        $imagerows = array();
        if($imageQueryResult->num_rows > 0){
            while($i = $imageQueryResult->fetch_assoc()){
                $imagerows[] = $i;
            }
        }
        $info = array();
        $info['articleinfo'] = $row;
        $info['imageinfo'] = $imagerows;
echo json_encode($info);
        
    }
}

//show paged article
if(isset($_GET['action'])){
    if($_GET['action'] == "showall"){
        $page = $_GET['page'];
        $size = 10;
        $articleindex = ($page-1)*$size;
$selectQuery = "select * from articles order by created desc limit $articleindex,$size";
$selectQueryResult = $conn->query($selectQuery);
$totalArticles = "select id from articles";
$totalArticlesResult = $conn->query($totalArticles);
$totalRecords = $totalArticlesResult->num_rows;
$totalPage = ceil($totalRecords/$size);
if($selectQueryResult->num_rows > 0){
    $rows = array();
    while ($row = $selectQueryResult->fetch_assoc()) {
        $intro = strip_tags($row['details']);
        if(mb_strlen($intro) <= 300){
            $intro = mb_substr($intro,0,300);
        }
        else{
            $intro = mb_substr($intro,0,300) . "<a href='javascript:void(0)'>...Details</a>";
        }
        $row['details'] = $intro; 
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
//create start
if(isset($_POST['action'])){
    if ($_POST['action'] == "create") {
        $t = $conn->escape_string($_POST['atitle']);
        $d = $conn->escape_string($_POST['adetails']);
        $tags = $conn->escape_string($_POST['atags']);
        $status = $_POST['astatus'];
        $userid = 1;        
        $articleInsert = "insert into articles values(NULL,'$t','$d','$userid','$tags','$status',CURRENT_TIMESTAMP,NULL)";
        //echo $articleInsert;
        //exit;
        $conn->query($articleInsert);
        if($conn->affected_rows == 1){
$articleid = $conn->insert_id;        
        //var_dump($allfiles);
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

                if(move_uploaded_file($allfiletmpnamesArr[$i], "../assets/articleimages/".$filename)){
                //
                // open and resize an image file
$img = Image::make("../assets/articleimages/".$filename)->resize(800,null,function ($constraint) {
    $constraint->aspectRatio();
//})->insert('assets/images/logo.png','center');
});
$img->save(null,60);
$img = Image::make("../assets/articleimages/".$filename)->resize(120,null,function ($constraint) {
    $constraint->aspectRatio();
//})->insert('assets/images/logo.png','center');
});
$img->save("../assets/articleimages/".$filename_thumb,90);

                //    
                $articleImageQuery = "insert into images values(NULL,'$filename','','$articleid',CURRENT_TIMESTAMP,NULL)";
                $conn->query($articleImageQuery);
                }
            }
            
        }
        echo "Article Created";
}
        //echo "your tags value: " . $tags;
        //echo "hi";
        //$insertQuery = "insert into articles values(NULL,'',)"
        //if affected_rows == 1 then send MessageFormatter"updated"
    }
}
//create end
//update start
if(isset($_POST['action'])){
    if ($_POST['action'] == "update") {
        $id = $conn->escape_string($_POST['hart_id']);
        $t = $conn->escape_string($_POST['atitle']);
        $d = $conn->escape_string($_POST['adetails']);
        $tags = $conn->escape_string($_POST['atags']);
        $status = $_POST['astatus'];
        $userid = 1;        
        //$articleInsert = "insert into articles values(NULL,'$t','$d','$userid','$tags','$status',CURRENT_TIMESTAMP,NULL)";
        $articleUpdate = "UPDATE `articles` SET 
        `title` = '$t',
        `details` = '$d',
        `tags` = '$tags',
        `status` = '$status',
        `updated` = CURRENT_TIMESTAMP        
         WHERE `articles`.`id` = '$id'";
        //echo $articleInsert;
        //exit;
        $conn->query($articleUpdate);
        if($conn->affected_rows == 1){
$articleid = $id;        
        //var_dump($allfiles);
        if (isset($_FILES['articleimages'])) {
            $allfiles = $_FILES['articleimages'];
            $allfilenamesArr = $allfiles['name'];
            $allfiletypesArr = $allfiles['type'];
            $allfilesizesArr = $allfiles['size'];
            $allfiletmpnamesArr = $allfiles['tmp_name'];
            $allfileerrorArr = $allfiles['error'];
            $totalfiles = count($allfilenamesArr);
            for ($i = 0; $i < $totalfiles; $i++) {
                $filename = $articleid."_".time()."_".rand(1000,9999).".jpg";
                if(move_uploaded_file($allfiletmpnamesArr[$i], "../assets/articleimages/".$filename)){
                $articleImageQuery = "insert into images values(NULL,'$filename','','$articleid',CURRENT_TIMESTAMP,NULL)";
                $conn->query($articleImageQuery);
                }
            }
            
        }
        echo "Article Updated";
}        
    }
}
//update end
?>