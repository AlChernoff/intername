<?php

require("./DbConnection.php");

define('DB_CONFIG', 'mysql:host=localhost;dbname=intername;charset=utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

$db = new DbConnection(DB_CONFIG, DB_USER, DB_PASSWORD);

//Helper to get last inserted user_id for further user INSERT
function get_last_user_id_from_db($db) {
    $sql = "select id from users order by id DESC LIMIT 1";
    $id = $db->query($sql)->fetch();
    return $id;
}

//Helper to get last inserted post_id for further post INSERT
function get_last_post_id_from_db($db) {
    $sql = "select id from posts order by id DESC LIMIT 1";
    $id = $db->query($sql)->fetch();
    return $id;
}

//Insertion of User received via POST to db
function insert_user_to_db($json,$db) {
    $user_id = get_last_user_id_from_db($db);
    try {
        //User creation in DB
        $user_id['id']=(int)$user_id['id']+1; 
        $sql = "INSERT INTO users (id, name ,email) VALUES (?,?,?)";
        $query = $db->prepare($sql);
        $query->execute([$user_id['id'],$json['username'], $json['email']]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

//Insertion of Post received via POST to db
function insert_post_to_db($json,$db) {
    $user_id = get_last_user_id_from_db($db);
    $post_id = get_last_post_id_from_db($db);
    try {
        //Post creation in DB
        $post_id['id']=(int)$post_id['id']+1;
        $sql = "INSERT INTO posts (id, user_id, title ,body) VALUES (?, ?,?,?)";
        $query = $db->prepare($sql);
        $query->execute([$post_id['id'], $user_id['id'],$json['post_title'], $json['post_body']]);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

//POST Request resolution
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = $_POST;

    $db = new PDO($db->db_config,$db->db_user, $db->db_password);

        insert_user_to_db($json,$db);
        insert_post_to_db($json,$db);


    echo("Thank you! Data was inserted!");
}

