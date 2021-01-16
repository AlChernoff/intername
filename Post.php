<?php

class Post
{
    private $id;
    private $user_id;
    private $title;
    private $body;
    private $created_at;
    private $updated_at;


    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function __construct($id, $user_id, $title, $body)
    {
        $this->id=$id;
        $this->user_id=$user_id;
        $this->title=$title;
        $this->body= $body;
    }

    public function create(DbConnection $connection)
    {
        $db = new PDO($connection->db_config, $connection->db_user, $connection->db_password);

        try {
            $sql = "INSERT INTO posts (id, user_id ,title, body) VALUES (?,?,?,?)";
            $query = $db->prepare($sql);
            $query->execute([$this->id,$this->user_id, $this->title, $this->body]);
            $count = $query->rowCount();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return $count;
    }
}
      
