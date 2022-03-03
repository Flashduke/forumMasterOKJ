<?php
class Post
{
    private $conn;
    private $table = 'posts';
    private $view = 'posts_view';

    //post props
    public $id;
    public $userID;
    public $communityID;
    public $communityURL;
    public $author;
    public $profileURL;
    public $communityName;
    public $title;
    public $content;
    public $createdAt;
    public $thumbsDowns;
    public $thumbsUps;

    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get posts
    public function read()
    {
        //create query
        $query = "";

        if ($this->communityURL) {
            $query = 'SELECT * FROM ' . $this->view . ' WHERE communityName = ?';

            //prepare statement
            $stmt = $this->conn->prepare($query);
            
            //bind ID
            $stmt->bindParam(1, $this->communityURL);
        } else if ($this->profileURL) {
            $query = 'SELECT * FROM ' . $this->view . ' WHERE author = ?';

            //prepare statement
            $stmt = $this->conn->prepare($query);
            
            //bind ID
            $stmt->bindParam(1, $this->profileURL);
        } else {
            $query = 'SELECT * FROM ' . $this->view;

            //prepare statement
            $stmt = $this->conn->prepare($query);
        }

        //execute statement
        $stmt->execute();

        return $stmt;
    }

    //get single post
    public function readSingle()
    {
        //create query
        $query = 'SELECT *
            FROM
                ' . $this->view . ' p
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
        $this->author = $row['author'];
        $this->communityName = $row['communityName'];
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->createdAt = $row['createdAt'];
        $this->thumbsDowns = $row['thumbsDowns'];
        $this->thumbsUps = $row['thumbsUps'];
    }

    //create post
    public function create()
    {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                communityID = :communityID,
                content = :content,
                userID = :userID,
                title = :title';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->communityID = htmlspecialchars(strip_tags($this->communityID));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->userID = htmlspecialchars(strip_tags($this->userID));
        $this->title = htmlspecialchars(strip_tags($this->title));

        //bind data
        $stmt->bindParam(':communityID', $this->communityID);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':userID', $this->userID);
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
    public function update()
    {
        //create query
        $query = 'UPDATE ' . $this->table . '
            SET
                content = :content,
                title = :title
            WHERE
                id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->title = htmlspecialchars(strip_tags($this->title));

        //bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':content', $this->content);
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
    public function delete()
    {
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
