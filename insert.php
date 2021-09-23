<!DOCTYPE html>
<html lang="en">

<head>
    <title>Insert Data</title>
    <?php
        include('getdata.php');
    ?>
</head>

<body>
    <?php
        $conn = connectToDatabase();

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

        $sqlRunsData = "INSERT INTO runs (user_id, date, run_type, distance, time_hours, time_minutes, time_seconds, average_pace)
        VALUES (1, '$date', '$run_type', '$distance', '$time_hours', '$time_minutes', '$time_seconds', '$average_pace')"; // user_id is currently hardcoded


        //TO DO: 
            //Alter so that these stats get updated whenever runs are added OR deleted/edited
        // SQL statements to update year/month/week distance
        $sqlUpdateYearDistance =
            "UPDATE users
            INNER JOIN (
                SELECT user_id, SUM(distance) as year_distance
                FROM runs
                WHERE user_id = 1 AND YEAR(date) = YEAR(now())
            ) runs ON users.id = runs.user_id
            SET users.year_distance = runs.year_distance";

        $sqlUpdateMonthDistance = 
            "UPDATE users
            INNER JOIN (
                SELECT user_id, SUM(distance) as month_distance
                FROM runs
                WHERE user_id = 1 AND MONTH(date) = MONTH(now())
            ) runs ON users.id = runs.user_id
            SET users.month_distance = runs.month_distance";

        $sqlUpdateWeekDistance =
            "UPDATE users
            INNER JOIN (
                SELECT user_id, SUM(distance) as week_distance
                FROM runs
                WHERE user_id = 1
                    AND CASE
                            WHEN WEEKDAY(now()) = 6 THEN date = CURDATE()
                            ELSE date BETWEEN (now() - INTERVAL WEEKDAY(now()) + 1 DAY) AND now()
                        END
                ) runs ON users.id = runs.user_id
                SET users.week_distance = runs.week_distance";

        // Insert into database
        try {
            $conn->exec($sqlRunsData);
            $conn->exec($sqlUpdateYearDistance);
            $conn->exec($sqlUpdateMonthDistance);
            $conn->exec($sqlUpdateWeekDistance);
        } catch(PDOException $e) {
            echo "Error";
        }
    ?>

</body>

</html>