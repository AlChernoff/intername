<?php

class DbConnection {
    private $db_config;
    private $db_user;
    private $db_password;

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

      function __construct($db_config,$db_user,$db_password) {
        $this->db_config = $db_config;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
      }
}