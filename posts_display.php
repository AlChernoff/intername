<?php

define('DB_CONFIG', 'mysql:host=localhost;dbname=intername;charset=utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

$db = new PDO(DB_CONFIG, DB_USER, DB_PASSWORD);

function get_posts_from_db_by_post_id($post_id, $db)
{
    $sql = "select * from posts where id=" . $post_id;
    $json = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($json);
    // echo"<pre>";
    // var_dump($json);
    // echo"</pre>";
    return $json;
}

function get_posts_from_db_by_user_id($user_id, $db)
{
    $sql = "select * from posts where user_id=" . $user_id;
    $json = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($json);
    echo"<pre>";
    var_dump($json);
    echo"</pre>";
    return $json;
}

function get_all_posts_from_db( $db)
{
    $sql = "select * from posts";
    $json = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($json);
    echo"<pre>";
    var_dump($json);
    echo"</pre>";
    return $json;
}

function get_query_from_task_six($db) {
    $sql = "select user_id, month(created_at) as monthly_average,  week(created_at) as weekly_average from posts";
    $json = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($json);
    echo"<pre>";
    var_dump($json);
    echo"</pre>";
    return $json;
}


//POST Request resolution
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        get_posts_from_db_by_post_id($post_id, $db);
    } else if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        get_posts_from_db_by_user_id($user_id, $db);
    } else if (isset($_GET['task_six'])) {
        get_query_from_task_six($db); //usage example: http://localhost:8889/intername/posts_display.php?task_six=1
    }
    else {
        get_all_posts_from_db($db);
    }
} 
