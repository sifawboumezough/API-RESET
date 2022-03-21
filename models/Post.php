<?php

    class Post {

        private $conn;
        private $table = 'posts';


            // Posts Propreties 

            public  $id;
            public $category_id;
            public $category_name;   // we're going to use join so that we can combine the 2 table together ! 
            public $title;
            public $author;
            public $created_at;

        // Constructor with DataBase

        public function __construct($db)
        {
            $this->conn = $db;
        }



        // Get (Read) Posts

        public function read() {
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                
                FROM 
                ' . $this->table . ' p
                LEFT JOIN 
                  categories c ON p.category_id = c.id
                ORDER BY 
                p.created_at DESC';


        // Prepare statement
      $stmt = $this->conn->prepare($query);

        // Execute query
            $stmt->execute();

            return $stmt;
    }
    }

    


