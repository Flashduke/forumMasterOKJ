<?php
class RatedContent
{
    private $conn;
    private $table;

    public $id;
    public $commentID;
    public $postID;
    public $userID;
    public $userName;
    public $thumbsUp;
    public $thumbsDown;

    public function __construct($db, $table_name)
    {
        $this->conn = $db;
        $this->table = $table_name;
    }

    //read rated
    public function read()
    {
        //create query
        $query = 'SELECT * FROM rated' . $this->table . '
            LEFT JOIN users ON rated' . $this->table . '.userID = users.id 
            WHERE users.name = ?';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind ID
        $stmt->bindParam(1, $this->userName);

        //execute statement
        $stmt->execute();

        return $stmt;
    }

    //check rated
    public function check()
    {
        //create query
        $query = 'SELECT * FROM rated' . $this->table . '
            WHERE
                userID = :userID AND
                postID = :postID;';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->postID = htmlspecialchars(strip_tags($this->postID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':postID', $this->postID);
        $stmt->bindParam(':userID', $this->userID);

        //execute statement
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    //create rated
    public function create()
    {
        //create query
        $query = 'INSERT INTO rated' . $this->table . '
            SET
                postID = :postID,
                userID = :userID,
                thumbsUp = :thumbsUp,
                thumbsDown = :thumbsDown';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->postID = htmlspecialchars(strip_tags($this->postID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));
        $this->thumbsUp = htmlspecialchars(strip_tags($this->thumbsUp));
        $this->thumbsDown = htmlspecialchars(strip_tags($this->thumbsDown));

        //bind data
        $stmt->bindParam(':postID', $this->postID);
        $stmt->bindParam(':userID', $this->userID);
        $stmt->bindParam(':thumbsUp', $this->thumbsUp);
        $stmt->bindParam(':thumbsDown', $this->thumbsDown);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //update rated content
    public function update()
    {
        //create query
        $query = 'UPDATE rated' . $this->table . '
            SET
                thumbsUp = :thumbsUp,
                thumbsDown = :thumbsDown
            WHERE
                postID = :postID AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->thumbsUp = htmlspecialchars(strip_tags($this->thumbsUp));
        $this->thumbsDown = htmlspecialchars(strip_tags($this->thumbsDown));
        $this->postID = htmlspecialchars(strip_tags($this->postID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':thumbsUp', $this->thumbsUp);
        $stmt->bindParam(':thumbsDown', $this->thumbsDown);
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

    //delete rated content
    public function delete()
    {
        //create query
        $query = 'DELETE FROM rated' . $this->table . '
            WHERE
                postID = :postID AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->postID = htmlspecialchars(strip_tags($this->postID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
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
}
