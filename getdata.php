<!-- Connect to MySQL database using PDO driver (code from https://www.w3schools.com/php/php_mysql_connect.asp) -->
<?php
    function connectToDatabase() {
        $servername = '127.0.0.1';
        $username = 'runlog_user';
        $password = 'run4FUN';
        $db = 'runlog';

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
        }
        return $conn;
    }
?>


<!-- SQL query to display data from 'runs' table -->
<!-- TO DO: update to only show data for specific user -->
<?php
    function displayData($conn) {
        // query database for variables
        $sql = 'SELECT date, run_type, distance, time_hours, time_minutes, time_seconds, average_pace FROM runs';
        foreach($conn->query($sql) as $row) {
            echo "<tr>", "<td>", $row['date'], "</td>";
            echo "<td>", $row['run_type'], "</td>";
            echo "<td>", $row['distance'], "</td>";
            echo "<td>", $row['time_hours'], ":", $row['time_minutes'], ":", $row['time_seconds'], "</td>";
            echo "<td>", $row['average_pace'], "</td>", "</tr>";
        }
    }
?>