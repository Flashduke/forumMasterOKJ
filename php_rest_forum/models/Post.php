<?php
    class Post {
        private $conn;
        private $table = 'posts';

        //post props
        public $id;
        public $communityID;
        public $communityName;
        public $content;
        public $picture;
        public $createdAt;
        public $userID;
        public $profileName;
        public $thumbsDowns;
        public $thumbsUps;
        public $title;

        //constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        //get posts
        public function read() {
            //create query
            $query = 'SELECT 
                c.name AS communityName,
                u.name AS userName,
                p.id,
                p.communityID,
                p.content,
                p.picture,
                p.createdAt,
                p.userID,
                p.thumbsDowns,
                p.thumbsUps,
                p.title
            FROM
                ' . $this->table . ' p
            LEFT JOIN
                communities c ON p.communityID = c.id
            LEFT JOIN
                users u ON p.userID = u.id
            ORDER BY
                p.createdAt DESC';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute statement
            $stmt->execute();

            return $stmt;
        }

        //get single post
        public function readSingle() {
            //create query
            $query = 'SELECT 
                c.name AS communityName,
                u.name AS userName,
                p.id,
                p.communityID,
                p.content,
                p.picture,
                p.createdAt,
                p.userID,
                p.thumbsDowns,
                p.thumbsUps,
                p.title
            FROM
                ' . $this->table . ' p
            LEFT JOIN
                communities c ON p.communityID = c.id
            LEFT JOIN
                users u ON p.userID = u.id
            WHERE
                p.id = ?
            LIMIT 0,1';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind ID
            $stmt->bindParam(1, $this->id);

            //execute statement
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->communityID = $row['communityID'];
            $this->communityName = $row['communityName'];
            $this->content = $row['content'];
            $this->picture = $row['picture'];
            $this->createdAt = $row['createdAt'];
            $this->userID = $row['userID'];
            $this->userName = $row['userName'];
            $this->thumbsDowns = $row['thumbsDowns'];
            $this->thumbsUps = $row['thumbsUps'];
            $this->title = $row['title'];
        }

        //create post
        public function create() {
            //create query
            $query = 'INSERT INTO ' . $this->table . '
            SET
                communityID = :communityID,
                content = :content,
                picture = :picture,
                userID = :userID,
                thumbsDowns = :thumbsDowns,
                thumbsUps = :thumbsUps,
                title = :title';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->communityID = htmlspecialchars(strip_tags($this->communityID));
            $this->content = htmlspecialchars(strip_tags($this->content));
            $this->picture = htmlspecialchars(strip_tags($this->picture));
            $this->userID = htmlspecialchars(strip_tags($this->userID));
            $this->thumbsDowns = htmlspecialchars(strip_tags($this->thumbsDowns));
            $this->thumbsUps = htmlspecialchars(strip_tags($this->thumbsUps));
            $this->title = htmlspecialchars(strip_tags($this->title));

            //bind data
            $stmt->bindParam(':communityID', $this->communityID);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':picture', $this->picture);
            $stmt->bindParam(':userID', $this->userID);
            $stmt->bindParam(':thumbsDowns', $this->thumbsDowns);
            $stmt->bindParam(':thumbsUps', $this->thumbsUps);
            $stmt->bindParam(':title', $this->title);

            //execute query
            if ($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //update post
        public function update() {
            //create query
            $query = 'UPDATE ' . $this->table . '
            SET
                communityID = :communityID,
                content = :content,
                picture = :picture,
                userID = :userID,
                thumbsDowns = :thumbsDowns,
                thumbsUps = :thumbsUps,
                title = :title
            WHERE
                id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->communityID = htmlspecialchars(strip_tags($this->communityID));
            $this->content = htmlspecialchars(strip_tags($this->content));
            $this->picture = htmlspecialchars(strip_tags($this->picture));
            $this->userID = htmlspecialchars(strip_tags($this->userID));
            $this->thumbsDowns = htmlspecialchars(strip_tags($this->thumbsDowns));
            $this->thumbsUps = htmlspecialchars(strip_tags($this->thumbsUps));
            $this->title = htmlspecialchars(strip_tags($this->title));

            //bind data
            $stmt->bindParam(':communityID', $this->communityID);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':picture', $this->picture);
            $stmt->bindParam(':userID', $this->userID);
            $stmt->bindParam(':thumbsDowns', $this->thumbsDowns);
            $stmt->bindParam(':thumbsUps', $this->thumbsUps);
            $stmt->bindParam(':title', $this->title);

            //execute query
            if ($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //delete post
        public function delete() {
            //create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':id', $this->id);

            //execute query
            if ($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
    