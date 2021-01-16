<?php

require("./User.php");
require("./Post.php");
require("./DbConnection.php");

define('DB_CONFIG', 'mysql:host=localhost;dbname=intername;charset=utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

$db = new DbConnection(DB_CONFIG, DB_USER, DB_PASSWORD);

function fetch_users($db)
{

    
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://jsonplaceholder.typicode.com/users",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",

    ));
    $response = curl_exec($curl);
    $response = json_decode($response);
    curl_close($curl);

    foreach($response as $user) {
        $user = new User($user->id, $user->name, $user->email);
        $count = $user->create($db);
    }

    echo "Exctraction of users was finished! Inserted:" . $count . "<br>";


}


function fetch_posts($db)
{

    
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://jsonplaceholder.typicode.com/posts",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",

    ));
    $response = curl_exec($curl);
    $response = json_decode($response);

    // var_dump($response);die;
    curl_close($curl);

    foreach($response as $post) {
        $user = new Post($post->id, $post->userId, $post->title, $post->body);
        $count = $user->create($db);
    }

    echo "Exctraction of posts was finished! Inserted:" . $count ."<br>" ;
}

fetch_users($db);
fetch_posts($db);
