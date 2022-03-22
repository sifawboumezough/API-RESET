<?php
    // headers : becuz we're going to access RESET API throught HTTP
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

  
    // instantiate DB & connnect to it

    $database = new DataBase();
    $db = $database->connect();  // connect function is the one we created on Database line 12

    //instantiate  Post object
    $post = new Post($db);

    // get Posted Data

    $data = json_decode(file_get_contents("php://input"));

        $post->title = $data->title;
        $post->body = $data->body;
        $post->author = $data->author;
        $post->category_id = $data->category_id;

    // create Post 

    if($post->create()){
        echo json_encode(
            array('message' => 'Post Created')
        );
    }else {
        array('message' => 'Post Not Created');
    }



