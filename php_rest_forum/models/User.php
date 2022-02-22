<?php
class User
{
    private $conn;
    private $table = 'users';

    //user props
    public $id;
    public $email;
    public $password;
    public $confirm;
    public $picture;
    public $createdAt;
    public $role;
    public $name;
    public $refreshToken;

    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function signup()
    {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                email = :email,
                password = :password,
                picture = :picture,
                role = :role,
                name = :name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = md5(htmlspecialchars(strip_tags($this->password)));
        $this->picture = htmlspecialchars(strip_tags($this->picture));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind data
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':picture', $this->picture);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':name', $this->name);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function login()
    {
        //create query
        $query = 'SELECT
                id,
                email,
                password,
                picture,
                createdAt,
                role,
                name
            FROM
                ' . $this->table . '
            WHERE
                email = ?
            LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind email
        $stmt->bindParam(1, $this->email);

        //execute statement
        $stmt->execute();

        return $stmt;
    }

    public function setRefreshToken()
    {
        $query = 'UPDATE ' . $this->table . '
            SET
                refreshToken = :refreshToken
            WHERE
                id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->refreshToken = htmlspecialchars(strip_tags($this->refreshToken));

        //bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':refreshToken', $this->refreshToken);

        //execute query
        if ($stmt->execute()) {
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
    
    public function findRefreshToken()
    {
        //create query
        $query = 'SELECT
                id
            FROM
                ' . $this->table . '
            WHERE
                refreshToken = ?
            LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind refreshToken
        $stmt->bindParam(1, $this->refreshToken);

        //execute statement
        $stmt->execute();

        return $stmt;
    }
}
