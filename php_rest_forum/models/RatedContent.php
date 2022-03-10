<?php
class RatedContent
{
    private $conn;
    private $table;

    public $id;
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
        $query = 'SELECT * FROM rated' . $this->table . 's
            LEFT JOIN users ON rated' . $this->table . 's.userID = users.id 
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
        $query = 'SELECT * FROM rated' . $this->table . 's
            WHERE
                userID = :userID AND
                '.$this->table.'ID = :id;';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':userID', $this->userID);

        //execute statement
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    //create rated
    public function create()
    {
        //create query
        $query = 'INSERT INTO rated' . $this->table . 's
            SET
                '.$this->table.'ID = :id,
                userID = :userID,
                thumbsUp = :thumbsUp,
                thumbsDown = :thumbsDown';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->userID = htmlspecialchars(strip_tags($this->userID));
        $this->thumbsUp = htmlspecialchars(strip_tags($this->thumbsUp));
        $this->thumbsDown = htmlspecialchars(strip_tags($this->thumbsDown));

        //bind data
        $stmt->bindParam(':id', $this->id);
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
        $query = 'UPDATE rated' . $this->table . 's
            SET
                thumbsUp = :thumbsUp,
                thumbsDown = :thumbsDown
            WHERE
                '.$this->table.'ID = :id AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->thumbsUp = htmlspecialchars(strip_tags($this->thumbsUp));
        $this->thumbsDown = htmlspecialchars(strip_tags($this->thumbsDown));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':thumbsUp', $this->thumbsUp);
        $stmt->bindParam(':thumbsDown', $this->thumbsDown);
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

    //delete rated content
    public function delete()
    {
        //create query
        $query = 'DELETE FROM rated' . $this->table . 's
            WHERE
                '.$this->table.'ID = :id AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

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
