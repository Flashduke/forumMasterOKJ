<?php
class Profile
{
    private $conn;
    private $view = 'profiles';

    //profile props
    public $banner;
    public $createdAt;
    public $description;
    public $followerCount;
    public $name;
    public $icon;
    public $id;

    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        //create query
        $query = 'SELECT * FROM ' . $this->view;

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute statement
        $stmt->execute();

        return $stmt;
    }

    public function readSingle()
    {
        //create query
        $query = 'SELECT * FROM ' . $this->view . ' WHERE name = :name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind data
        $stmt->bindParam(':name', $this->name);

        //execute statement
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->createdAt = $row['createdAt'];
        $this->description = $row['description'];
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->icon = $row['icon'];
        $this->banner = $row['banner'];
        $this->followerCount = $row['followerCount'];
    }
}
