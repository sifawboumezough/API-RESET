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
   
    // instantiate blog post object
    $result = $post->read();
    // get row Count 

    $num = $result->rowCount();


    // check if any posts
    if($num > 0) {
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name,
            );

            //push to the data

            array_push($posts_arr['data'], $post_item);
            
        }
        // Turn in to JSON 
        echo json_encode($posts_arr);

    }else {
        // if there is NO POSTS
        echo json_encode(
            array('message' => 'No Posts Found')
        );
    }
?>