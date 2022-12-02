<?php
class MYSQL {

    public const DB_NAME = "TMDB";
    private $conn;

    public function __construct($servername, $username, $password, $port = NULL) {
        // Create connection
        $this->conn = new mysqli($servername, $username, $password, '', $port);

        // Check connection
        if ($this->conn->connect_error) {
            die("<br/>Connection failed: " . $this->conn->connect_error);
        }
        return "<br/>Connected successfully";
    }

    public function create_db($db_name) {
        // Create database
        $sql = "CREATE DATABASE " . $db_name;
        if ($this->conn->query($sql) === TRUE) {
            // "<br/>Database created successfully";
        } else {
            echo "<br/>Error creating database: " . $this->conn->error;
        }
        
        if (mysqli_select_db($this->conn, $db_name)) {
            // "<br/>New DB select successful";
        } else {
             die("<br/>Connection failed: " . mysqli_connect_error());
        }

        // create tables
        $sql = "CREATE TABLE analytics (
            id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            search_term VARCHAR(256) NOT NULL,
            ip_address VARCHAR(20) NOT NULL,
            date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if ($this->conn->query($sql) === TRUE) {
            // "<br/>Table analytics created successfully";
        } else {
            echo "<br/>Error creating table: " . $this->conn->error;
        }
    }

    public function db_save($search_term, $ip_address) {
        // save searches to DB
        if (!$this->conn) {
            die("<br/>Connection failed: " . mysqli_connect_error());
        }

        if (mysqli_select_db($this->conn, self::DB_NAME)) {
            // "<br/>New DB select successful";
        } else {
             die("<br/>Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO analytics (search_term, ip_address) 
            VALUES ('".$search_term."', '".$ip_address."')";

        if (mysqli_query($this->conn, $sql)) {
            // "<br/>New record successful";
        } else {
            echo "<br/>Error: " . mysqli_error($this->conn);
        }
    }
    
}