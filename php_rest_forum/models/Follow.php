<?php
class Follow
{
    private $conn;
    private $table = 'followers';

    //join props
    public $profileID;
    public $userID;
    public $userName;

    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get joined profiles
    public function read()
    {
        //create query
        $query = 'SELECT p.name FROM ' . $this->table . '
        LEFT JOIN users p ON
            p.id = profileID
        LEFT JOIN users u ON
            u.id = userID
        WHERE
            u.name = :userName';

        //prep stmt
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->userName = htmlspecialchars(strip_tags($this->userName));

        //bind data
        $stmt->bindParam(':userName', $this->userName);

        //exec query
        $stmt->execute();

        return $stmt;
    }

    //check if joined profile
    public function check()
    {
        //create query
        $query = 'SELECT * FROM ' . $this->table . '
            WHERE
                profileID = :profileID AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->profileID = htmlspecialchars(strip_tags($this->profileID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':profileID', $this->profileID);
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
                profileID = :profileID,
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->profileID = htmlspecialchars(strip_tags($this->profileID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':profileID', $this->profileID);
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
                profileID = :profileID AND
                userID = :userID';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->profileID = htmlspecialchars(strip_tags($this->profileID));
        $this->userID = htmlspecialchars(strip_tags($this->userID));

        //bind data
        $stmt->bindParam(':profileID', $this->profileID);
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
