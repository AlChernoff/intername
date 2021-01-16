<?php



class User {
    private $id;
    private $name;
    private $email;
    private $created_at;
    private $updated_at;


    public function __get($property) {
        if (property_exists($this, $property)) {
          return $this->$property;
        }
      }
    
      public function __set($property, $value) {
          if (property_exists($this, $property)) {
              $this->$property = $value;
          }
      }

      function __construct($id,$name,$email) {
          $this->id=$id;
          $this->name=$name;
          $this->email=$email;
      }

      function create(DbConnection $connection){
        $db = new PDO($connection->db_config,$connection->db_user, $connection->db_password);



        try {
            $sql = "INSERT INTO users (id, name ,email) VALUES (?,?,?)";
            $query = $db->prepare($sql);
            $query->execute([$this->id,$this->name, $this->email]);
            $count = $query->rowCount();

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return $count;
      }

      

 
}  