<?php
class Join
{
    private $conn;
    private $table = 'members';

    //join props
    public $communityID;
    public $userID;

    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get joined communities
    public function read()
    {
        //create query
        $query = 'SELECT c.name FROM ' . $this->table . '
            LEFT JOIN users p ON
                c.id = communityID
            LEFT JOIN users u ON
                u.id = userID
            WHERE
                u.name = ';

        //prep stmt
        $stmt = $this->conn->prepare($query);

        //exec query
        $stmt->execute();

        return $stmt;
    }

    //check if joined community
    public function check()
    {
        //create query
        $query = 'SELECT * FROM ' . $this->table . '
            WHERE
                communityID = :communityID AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->communityID = htmlspecialchars(strip_tags($this->communityID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':communityID', $this->communityID);
        $stmt->bindParam(':userID', $this->userID);

        //execute statement
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function create()
    {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                communityID = :communityID,
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->communityID = htmlspecialchars(strip_tags($this->communityID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':communityID', $this->communityID);
        $stmt->bindParam(':userID', $this->userID);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete()
    {
        //create query
        $query = 'DELETE FROM ' . $this->table . '
            WHERE
                communityID = :communityID AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->communityID = htmlspecialchars(strip_tags($this->communityID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':communityID', $this->communityID);
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
