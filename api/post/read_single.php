<?php
    // headers : becuz we're going to access RESET API throught HTTP
    
    header('Acess-Control-Allow-Origin: *');  // we put  * : becuz it's completely public API : (NO AUTHORIZATION ..)
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

  
    // instantiate DB & connnect to it

    $database = new DataBase();
    $db = $database->connect();  // connect function is the one we created on Database line 12

    //instantiate  Post object
    $post = new Post($db);
    // get our id from URL 
    $post->id = isset($_GET['id']) ? $_GET['id'] : die(); // if not : die function cuts evreything off and nothing will happen

    // get Post (readsingle)

    $post->read_single();

    $post_arr = array(
        'id'  => $post->id,
        'title'  => $post->title,
        'body'  => $post->body,
        'author'  => $post->author,
        'category_id'  => $post->category_id,
        'category_name'  => $post->category_name,
      
    );


    // convert array to JSON DATA (Make JSON)

        print_r(json_encode($post_arr));  // on the other data form it has no fetch becuz (code is static and does not iterate it self)
