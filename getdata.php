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
            //echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
        return $conn;
    }

    //SQL query to display data from 'runs' table
    //TO DO: update to only show data for specific user
    function displayRunsTable($conn) {
        // query database for variables
        $sql = 'SELECT date, run_type, distance, time_hours, time_minutes, time_seconds, average_pace, id FROM runs ORDER BY date DESC';
        foreach($conn->query($sql) as $row) {
            echo "<tr>", "<td>", $row['date'], "</td>";
            echo "<td>", $row['run_type'], "</td>";
            echo "<td>", $row['distance'], "</td>";
            echo "<td>", sprintf("%02d", $row['time_hours']), ":", sprintf("%02d", $row['time_minutes']), ":", sprintf("%02d", $row['time_seconds']), "</td>";
            echo "<td>", $row['average_pace'], "</td>";
            echo "<td><a href='delete.php?id=", $row['id'], "'>Delete</a></td>"; // Delete button - TO DO: create confirm alert instead of immediately deleting
            echo "<td><a href='edit.php?id=", $row['id'], "'>Edit</a></td></tr>"; // Edit button - TO DO: make it function
        }
    }

    function displayUserStats($conn) {
        $sql = 'SELECT week_distance, month_distance, year_distance FROM users WHERE id = 1';
        foreach($conn->query($sql) as $row) {
            echo "<p>This week: ", $row['week_distance'], " miles</p>";
            echo "<p>This month: ", $row['month_distance'], " miles</p>";
            echo "<p>This year: ", $row['year_distance'], " miles</p>";
        }
    }

?>