<?php
 class Content {
    private $conn;
    private $table_name = "contens";

    public $id;
    public $author;
    public $isi;
    public $created;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $q = "SELECT * FROM " . $this->table_name . " ORDER BY author";
        $statement = $this->conn->prepare($q);
        $statement->execute();
        return $statement;
    }

    public function readOne(){
        $q = "SELECT author, isi, created FROM content WHERE id = ?";
        $statement = $this->conn->prepare($q);
        $statement->execute();
        return $statement;

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->author = $row['author'];
        $this->isi = $row['isi'];
    }

    public function update(){
        $q = "UPDATE " . $this->table_name . " SET author = :author, isi = :isi WHERE id = :id";
        $statement = $this->conn->prepare($q);

        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->isi = htmlspecialchars(strip_tags($this->isi));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':isi', $this->isi);
        if($statement->execute()){
            return true;
        }
        return false;
    }

    function delete() {
        $q = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $statement = $this->conn->prepare($q);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindParam(1, $this->id);

        if($statement->execute()){
            return true;
        }
        return false;
    }

    function search($keywords){
        $q = "SELECT author, isi FROM " . $this->table_name . " WHERE author LIKE = ? OR isi LIKE = ?";
        $statement->conn->prepare($q);
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "% {$keywords} %";
        $statement->bindParam(1, $keywords);
        $statement->bindParam(2, $keywords);
        $statement->bindParam(3, $keywords);

        $statement->execute();
        return $statement;

    }

    public function readPaging($from_record_num, $records_per_page){
        $q = "SELECT author, isi FROM " . $this->table_name . " LIMIT ? ?";
        $statement = $this->conn->prepare($q);
        $statement->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $statement->bindParam(2, $records_per_page, PDO::PARAM_INT);
        $statement->execute();
        return $statement;
    }

    public function count(){
        $q = "SELECT COUNT(*) AS total_rows FROM " . $this->table_name . "";
        $statement = $this->conn->prepare($q);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];

    }

    

}