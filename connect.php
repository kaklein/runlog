<?php
//Connect to MySQL database using PDO driver (code from https://www.w3schools.com/php/php_mysql_connect.asp)
    function connectToDatabase() {
        $servername = '127.0.0.1';
        $username = 'runlog_user';
        $password = 'run4FUN';
        $db = 'runlog';

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
        return $conn;
    }
?>