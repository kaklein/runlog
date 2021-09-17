<!DOCTYPE html>
<html lang="en">

<head>
    <title>Insert Data</title>
</head>

<body>
    <?php
        // Connect to MySQL database using PDO driver (code from https://www.w3schools.com/php/php_mysql_connect.asp)

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

        // Get values from form input
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_REQUEST['date'];
            $run_type = $_REQUEST['run-type'];
            $distance = $_REQUEST['distance'];
            $time = $_REQUEST['time'];
            $average_pace = $_REQUEST['average-pace'];
        }

        $sql = "INSERT INTO runs (user_id, date, run_type, distance, time, average_pace)
        VALUES (1, '$date', '$run_type', '$distance', '$time', '$average_pace')";

        // Insert into database
        try {
            $conn->exec($sql);
        } catch(PDOException $e) {
            echo "Error";
        }
    ?>

</body>

</html>