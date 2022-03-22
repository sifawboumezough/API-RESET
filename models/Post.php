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

     // Get Single Post 
     public function read_single() {

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
                categories c ON p.category_id = c.id;
        WHERE 
            p.id = ?
            LIMIT 0.1';
             // Prepare statement

             $stmt = $this->conn->prepare($query);

             // BIND id 

             $stmt->bindParam(1,$this->id);
             $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            //set properities
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
     }


     // create Post 

     public function create() {
         $query = 'INSERT INTO ' .$this->table. '
             SET 
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';

            // prepare stmt 
            $stmt = $this->conn->prepare($query);

            // Clean data :)

            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));


            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);


               // Execute query
          if($stmt->execute()) {
            return true;
          }
            // print error 

                printf("ERROR 404", $stmt->error);

            return false;
     }




  }

    


