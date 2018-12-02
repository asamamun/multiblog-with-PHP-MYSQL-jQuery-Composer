<?php
namespace App;
class Database {

    public  $db;    
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'blog';
    public $table_name = '';

    function __construct() {        
        $this->open();
    }
    function __destruct() {
        //$this->close();
    }

    public function rawQuery($sql){
        return $this->db->query($sql);
    }

    public function open() {
        if (!is_object($this->db)) {            
            $conn = new \mysqli(
                $this->hostname, 
                $this->username, 
                $this->password, 
                $this->database);
            $conn->set_charset('utf8');
            if ($conn->connect_error) {
                error_log('Database connection failed: ' . $conn->connect_error);
                return false;
            }
            $this->db = $conn;            
        }
        
    }
    
    public function close() {
        $this->db->close();
        unset($this->db);
    }

    public function clean($str) {
        return $this->db->escape_string($str);        
    }

    
    public function create($data=array()) {
        if (!is_array($data)) {
            error_log(__METHOD__ . ' Invalid input expecting Array ');
            return false;
        }
        $sql = "INSERT INTO `{$this->table_name}` (";
        foreach ($data as $field => $value) {
            $sql .= "`".$field."`" . ",";            
        }
        $sql = substr($sql, 0, -1);
        $sql .= ") VALUES (";
        foreach ($data as $key => $value) {
            $sql .= "'" . $value . "',";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ")";
        //echo $sql;exit;
        //debug_log($sql);

        $result = $this->db->query($sql);
        if ($result === false) {
            error_log(__METHOD__ . ' DB ERROR query: '.$sql);
            return false;
        } else {
            return $this->db->insert_id;
        }
    }

    public function createWithTable($table,$data=array()) {
        if (!is_array($data)) {
            error_log(__METHOD__ . ' Invalid input expecting Array ');
            return false;
        }
        $sql = "INSERT INTO `{$table}` (";
        foreach ($data as $field => $value) {
            $sql .= "`".$field."`" . ",";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ") VALUES (";
        foreach ($data as $key => $value) {
            $sql .= "'" . $value . "',";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ")";
        //echo $sql;exit;
        debug_log($sql);

        $result = $this->db->query($sql);
        if ($result === false) {
            error_log(__METHOD__ . ' DB ERROR query: '.$sql);
            return false;
        } else {
            return $this->db->insert_id;
        }
    }

    public function set ($data=array(),$whereId){
        if(!is_array($data)) {
            error_log(__METHOD__ . ' Invalid input expecting array: ' );
            return false;
        }
        $sql = "UPDATE `{$this->table_name}` SET ";
        foreach ($data as $key => $value){
            if($key == 'id') continue;
            $sql .= " `".$key."` = '".$value."' ,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " WHERE `id` = ".$whereId;
        $result = $this->db->query($sql);
        if($this->db->affected_rows == 0) {
            error_log(__METHOD__ . ' DB ERROR msqli query on update: ' );
            return false;
        }
        else{
            return true;
        }
    }

    public function delete($id) {
        if ($id == 0 || $id == '') {
            return true;
        }
        $sql = "DELETE FROM `{$this->table_name}` WHERE `id` = " . $id;
        $this->db->query($sql);
        if ($this->db->affected_rows == 0) {
            error_log(__METHOD__ . 'ERROR mysqli query : ' . $sql);
            return false;
        } else {
            return true;
        }
    }

    public function get($id) {
        if ($id != '' && strlen($id) > 0 && $id != 0) {
            $sql = "SELECT * FROM `{$this->table_name}` WHERE `id` = '" . $id . "'";
            $result = $this->db->query($sql);
            if ($result == false) {
                error_log(__METHOD__ . 'ERROR mysqli query : ' . $sql);
                return false;
            }
            return $result->fetch_assoc();
        } else {
            error_log(__METHOD__ . 'ERROR Invalid input : ');
            return false;
        }
    }

    public function get_all (){        
            $sql = "SELECT * FROM `{$this->table_name}` ORDER BY id DESC";
            $result = $this->db->query($sql);
            if($result === false) {
                error_log(__METHOD__ . 'ERROR mysqli query : '.$sql );
                return false;
            }
            $rows = array();
            while ($row = $result->fetch_assoc() ) {
                $rows[] = $row;
            }
            return $rows;
    }
    public function get_all_paged ($start,$count){
        if($this->table_name == 'articles'){
$sql = "
SELECT `articles`.*,`images`.`imagename`,COUNT(comments.article_id) AS 'totalcomment'
FROM `articles`
LEFT JOIN  comments ON articles.id = comments.article_id
LEFT JOIN `images` ON `articles`.`id` = `images`.`article_id`
where `articles`.`status`='1'
group by articles.id
order by `articles`.`created` desc 
limit $start,$count";
        }
        else{
            $sql = "SELECT * FROM `{$this->table_name}` ORDER BY id DESC LIMIT $start,$count";
        }

        $result = $this->db->query($sql);
        if($result === false) {
            error_log(__METHOD__ . 'ERROR mysqli query : '.$sql );
            return false;
        }
        $rows = array();
        while ($row = $result->fetch_assoc() ) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function get_all_where(string $where){
        $sql = "SELECT * FROM `{$this->table_name}` where $where ORDER BY id DESC";
        //debug_log($sql);
        $result = $this->db->query($sql);
        if($result === false) {
            error_log(__METHOD__ . 'ERROR mysqli query : '.$sql );
            return false;
        }
        $rows = array();
        while ($row = $result->fetch_assoc() ) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    public function getCollection (){        
            $rows = $this->get_all();
            return $rows;
    }

    public function for_pagination (){
        $sql = "SELECT * FROM `{$this->table_name}` ORDER BY id DESC";
        $result = $this->db->query($sql);
        $totalrows = $result->num_rows;
        return $totalrows;
    }
    public function singlePost($id){
//        $sql = "SELECT * FROM `{$this->table_name}` where id = '$id' ORDER BY id DESC";
        $sql = "SELECT articles.*,images.imagename
FROM `articles`
LEFT JOIN `images` ON `articles`.id = `images`.article_id
where articles.status='1' and articles.id = '$id'";
        $result = $this->db->query($sql);
        if($result === false) {
            error_log(__METHOD__ . 'ERROR mysqli query : '.$sql );
            return false;
        }
        $images = array();
        $post = array();
        while ($row = $result->fetch_assoc() ) {
            $images[] = $row['imagename'];
            $post = $row;
        }
        $post['imagename'] = $images;
        return $post;
    }
    public function all_Admin_Post(){
        $sql = "SELECT `articles`.*,`users`.`username`
FROM `articles`
LEFT JOIN `users` ON `articles`.`user_id` = `users`.`id`;";

        $result = $this->db->query($sql);
        if($result === false) {
            error_log(__METHOD__ . 'ERROR mysqli query : '.$sql );
            return false;
        }
        return $result;
    }
 public function getall_userinfo(){
     $sql = "select * from users where 1";

     $result = $this->db->query($sql);
     if($result === false) {
         error_log(__METHOD__ . 'ERROR mysqli query : '.$sql );
         return false;
     }
     return $result;



 }

}
?>