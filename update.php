<?php
//TO-DO: when different users are functional - update to select user_id based on variable
function updateUserStats($conn) {
    $sqlUpdateYearDistance =
            "UPDATE users
            INNER JOIN (
                SELECT IFNULL(user_id, 1) as user_id,
                    IFNULL(SUM(distance), 0) as year_distance
                FROM runs
                WHERE user_id = 1 AND YEAR(run_date) = YEAR(now())
            ) runs ON users.id = runs.user_id
            SET users.year_distance = runs.year_distance";

    $sqlUpdateMonthDistance = 
        "UPDATE users
        INNER JOIN (
            SELECT IFNULL(user_id, 1) as user_id,
                IFNULL(SUM(distance), 0) as month_distance
            FROM runs
            WHERE user_id = 1 AND MONTH(run_date) = MONTH(now())
        ) runs ON users.id = runs.user_id
        SET users.month_distance = runs.month_distance";

    $sqlUpdateWeekDistance =
        "UPDATE users
        INNER JOIN (
            SELECT IFNULL(user_id, 1) as user_id,
                IFNULL(SUM(distance), 0) as week_distance
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