<?php
class Comment
{
    private $conn;
    private $table = 'comments';
    private $view = 'comments_view';

    //comment props
    public $id;
    public $createdAt;
    public $communityName;
    public $content;
    public $condition;
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
    public function read()
    {
        //create query
        $query = 'SELECT * FROM ' . $this->view . ' WHERE ' . $this->condition . ' = :value';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        if ($this->condition == 'postID') $stmt->bindParam(':value', $this->postID);
        if ($this->condition == 'author') $stmt->bindParam(':value', $this->userName);

        //execute statement
        $stmt->execute();

        return $stmt;
    }

    //create comment
    public function create()
    {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                content = :content,
                postID = :postID,
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->postID = htmlspecialchars(strip_tags($this->postID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':postID', $this->postID);
        $stmt->bindParam(':userID', $this->userID);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //update comment
    public function update()
    {
        //create query
        $query = 'UPDATE ' . $this->table . '
            SET
                content = :content,
                userID = :userID
            WHERE
                id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':userID', $this->userID);
        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //delete comment
    public function delete()
    {
        //create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id AND userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->id = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':userID', $this->userID);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
