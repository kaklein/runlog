<?php
function updateUserStats($conn) {
    $sqlUpdateYearDistance =
            "UPDATE users
            INNER JOIN (
                SELECT user_id, SUM(distance) as year_distance
                FROM runs
                WHERE user_id = 1 AND YEAR(run_date) = YEAR(now())
            ) runs ON users.id = runs.user_id
            SET users.year_distance = runs.year_distance";

    $sqlUpdateMonthDistance = 
        "UPDATE users
        INNER JOIN (
            SELECT user_id, SUM(distance) as month_distance
            FROM runs
            WHERE user_id = 1 AND MONTH(run_date) = MONTH(now())
        ) runs ON users.id = runs.user_id
        SET users.month_distance = runs.month_distance";

    $sqlUpdateWeekDistance =
        "UPDATE users
        INNER JOIN (
            SELECT user_id, SUM(distance) as week_distance
            FROM runs
            WHERE user_id = 1
                AND CASE
                        WHEN WEEKDAY(now()) = 6 THEN run_date = CURDATE()
                        ELSE run_date BETWEEN (now() - INTERVAL WEEKDAY(now()) + 1 DAY) AND now()
                    END
            ) runs ON users.id = runs.user_id
            SET users.week_distance = runs.week_distance";

    // Insert into database
    try {
        $conn->exec($sqlUpdateYearDistance);
        $conn->exec($sqlUpdateMonthDistance);
        $conn->exec($sqlUpdateWeekDistance);
    } catch(PDOException $e) {
        echo "Error";
    }
}
?>