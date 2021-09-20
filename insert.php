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

        // Function to calculate pace
        function calculatePace($distance, $hrs, $mins, $secs) {
            $total_secs = ($hrs * 3600) + ($mins * 60) + $secs;

            $secs_left = $total_secs;

            $pace_hours = floor(($total_secs / $distance) / 3600);
            $pace_hours = sprintf("%02d", $pace_hours); // format

            $secs_left = (round($total_secs / $distance)) % 3600;

            $pace_mins = floor($secs_left / 60);
            $pace_mins = sprintf("%02d", $pace_mins); // format

            $pace_secs = $secs_left % 60;
            $pace_secs = sprintf("%02d", $pace_secs); // format

            return($pace_hours . ":" . $pace_mins . ":" . $pace_secs);
        }

        // Get values from form input
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_REQUEST['date'];
            $run_type = $_REQUEST['run-type'];
            $distance = $_REQUEST['distance'];
            $time_hours = $_REQUEST['time-hours'];
            $time_minutes = $_REQUEST['time-minutes'];
            $time_seconds = $_REQUEST['time-seconds'];
            

            // calculate pace
            $average_pace = calculatePace($distance, $time_hours, $time_minutes, $time_seconds);
        }

        $sql = "INSERT INTO runs (user_id, date, run_type, distance, time_hours, time_minutes, time_seconds, average_pace)
        VALUES (1, '$date', '$run_type', '$distance', '$time_hours', '$time_minutes', '$time_seconds', '$average_pace')";

        // Insert into database
        try {
            $conn->exec($sql);
        } catch(PDOException $e) {
            echo "Error";
        }
    ?>

</body>

</html>