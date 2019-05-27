<?php
class User {
    private $conn;
    private $table_name = "users";
    // properti untuk objek
    public $id;
    public $firtname;
    public $lastname;
    public $email;
    public $password;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $q = "INSERT INTO " . $this->table_name . " SET firtname = :firstname, lastname = :lastname, email = :email, password = :password";
        $statement = $this->conn->prepare($q);

        // sanitize
        $this->firtname = htmlspecialchars(strip_tags($this->firtname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // ikat nilai
        $statement->bindParam(':firstname', $this->firtname);
        $statement->bindParam(':lastname', $this->lastname);
        $statement->bindParam(':email', $this->email);
        $pass_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $statement->bindParam(':password', $pass_hash);

        if($statement->execute()){
            return true;
        }
        return false;
    }

    function emailExists(){
        $q = "SELECT id, firtname, lastname, password FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $statement = $this->conn->prepare($q);
        
        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));
        // bind given email value
        $statement->bindParam(1, $this->email);
        $statement->execute();
        $num = $statement->rowCount();
        if($num > 0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->firtname = $row['firtname'];
            $this->lastname = $row['lastname'];
            $this->password = $row['password'];

            return true;
        }
        return false;
    }

    public function update(){
        $password_set = !empty($this->password) ? ", password = :password" : "";
        // spasi dalam melakukan query juga sangat penting untuk diperhatikan, bila salah dalam melakukan spasi maka bisa jadi query tidak berjalan
        $q = "UPDATE " . $this->table_name . " SET firtname = :firstname, lastname = :lastname, email = :email {$password_set} WHERE id = :id";
        $statement = $this->conn->prepare($q);

        // sanitize
        $this->firtname=htmlspecialchars(strip_tags($this->firtname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));

        $statement->bindParam(':firstname', $this->firtname);
        $statement->bindParam(':lastname', $this->lastname);
        $statement->bindParam(':email', $this->email);

        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $statement->bindParam(':password', $password_hash);
        }
        $statement->bindParam(':id', $this->id);

            if($statement->execute()){
                return true;
            }
            return false;
        

    }
}