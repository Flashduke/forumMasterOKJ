<?php
class Community
{
    private $conn;
    private $table = 'communities';

    //community props
    public $id;
    public $createdAt;
    public $description;
    public $name;

    //ctor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get communities
    public function read()
    {
        //create query
        $query = 'SELECT
                id,
                createdAt,
                description,
                name
            FROM
                ' . $this->table . '
            ORDER BY
                createdAt DESC';

        //prep stmt
        $stmt = $this->conn->prepare($query);

        //exec query
        $stmt->execute();

        return $stmt;
    }

    //get single community
    public function readSingle()
    {
        //create query
        $query = 'SELECT
                id,
                createdAt,
                description,
                name
            FROM
                ' . $this->table . '
            WHERE
                id = ?
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
        $this->description = $row['description'];
        $this->name = $row['name'];
    }

    //create community
    public function create()
    {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                description = :description,
                name = :name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind data
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':name', $this->name);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //update community
    public function update()
    {
        //create query
        $query = 'UPDATE ' . $this->table . '
            SET
                description = :description,
                name = :name
            WHERE
                id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':name', $this->name);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //delete community
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
