<?php
    class Comment {
        private $conn;
        private $table = 'comments';

        //comment props
        public $id;
        public $createdAt;
        public $content;
        public $postID;
        public $postTitle;
        public $userID;
        public $userName;
        public $thumbsDowns;
        public $thumbsUps;

        //ctor
        public function __construct($db)
        {
            $this->conn = $db;
        }

        //get communities
        public function read() {
            //create query
            $query = 'SELECT
                p.title AS postTitle,
                u.name AS userName,
                c.id,
                c.createdAt,
                c.content,
                c.postID,
                c.userID,
                c.thumbsDowns,
                c.thumbsUps
            FROM
                ' . $this->table . ' c
            LEFT JOIN
                users u ON c.userID = u.id
            LEFT JOIN
                posts p ON c.postID = p.id
            ORDER BY
                c.createdAt DESC';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //execute statement
            $stmt->execute();

            return $stmt;
        }

        //get single comment
        public function readSingle() {
            //create query
            $query = 'SELECT
                p.title AS postTitle,
                u.name AS userName,
                c.id,
                c.createdAt,
                c.content,
                c.postID,
                c.userID,
                c.thumbsDowns,
                c.thumbsUps
            FROM
                ' . $this->table . ' c
            LEFT JOIN
                users u ON c.userID = u.id
            LEFT JOIN
                posts p ON c.postID = p.id
            WHERE
                c.id = ?
            LIMIT 0,1';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind ID
            $stmt->bindParam(1, $this->id);

            //execute statement
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->createdAt = $row['createdAt'];
            $this->content = $row['content'];
            $this->postID = $row['postID'];
            $this->postTitle = $row['postTitle'];
            $this->userID = $row['userID'];
            $this->userName = $row['userName'];
            $this->thumbsDowns = $row['thumbsDowns'];
            $this->thumbsUps = $row['thumbsUps'];
        }

        //create comment
        public function create() {
            //create query
            $query = 'INSERT INTO ' . $this->table . '
            SET
                content = :content,
                postID = :postID,
                userID = :userID,
                thumbsDowns = :thumbsDowns,
                thumbsUps = :thumbsUps';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->content = htmlspecialchars(strip_tags($this->content));
            $this->postID = htmlspecialchars(strip_tags($this->postID));
            $this->userID = htmlspecialchars(strip_tags($this->userID));
            $this->thumbsDowns = htmlspecialchars(strip_tags($this->thumbsDowns));
            $this->thumbsUps = htmlspecialchars(strip_tags($this->thumbsUps));

            //bind data
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':postID', $this->postID);
            $stmt->bindParam(':userID', $this->userID);
            $stmt->bindParam(':thumbsDowns', $this->thumbsDowns);
            $stmt->bindParam(':thumbsUps', $this->thumbsUps);

            //execute query
            if ($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //update comment
        public function update() {
            //create query
            $query = 'UPDATE ' . $this->table . '
            SET
                content = :content,
                postID = :postID,
                userID = :userID,
                thumbsDowns = :thumbsDowns,
                thumbsUps = :thumbsUps
            WHERE
                id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->content = htmlspecialchars(strip_tags($this->content));
            $this->postID = htmlspecialchars(strip_tags($this->postID));
            $this->userID = htmlspecialchars(strip_tags($this->userID));
            $this->thumbsDowns = htmlspecialchars(strip_tags($this->thumbsDowns));
            $this->thumbsUps = htmlspecialchars(strip_tags($this->thumbsUps));

            //bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':postID', $this->postID);
            $stmt->bindParam(':userID', $this->userID);
            $stmt->bindParam(':thumbsDowns', $this->thumbsDowns);
            $stmt->bindParam(':thumbsUps', $this->thumbsUps);

            //execute query
            if ($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //delete comment
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