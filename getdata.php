<?php
    //SQL query to display data from 'runs' table
    //TO DO: update to only show data for specific user
    function displayRunsTable($conn) {
        // query database for variables
        $sql = 'SELECT run_date, run_type, distance, time_hours, time_minutes, time_seconds, average_pace, id FROM runs WHERE user_id = 1 ORDER BY run_date DESC';
        foreach($conn->query($sql) as $row) {
            // Data population:
            echo "<tr>", "<td>", $row['run_date'], "</td>";
            echo "<td>", $row['run_type'], "</td>";
            echo "<td>", $row['distance'], "</td>";
            echo "<td>", sprintf("%02d", $row['time_hours']), ":", sprintf("%02d", $row['time_minutes']), ":", sprintf("%02d", $row['time_seconds']), "</td>";
            echo "<td>", $row['average_pace'], "</td>";

            // Delete/edit button creation:
            echo "<td><form class=delete-form onsubmit='confirmDelete(" . $row['id'] . ")'>"; // Delete button
                echo "<input type='submit' class='delete-button button' value='Delete'></input></form></td>";
            //echo "<td><a href='edit.php?id=", $row['id'], "'>Edit</a></td></tr>"; // Edit button - TO DO: make it function
        }
    }

    //SQL query to display data from 'users' table (mileage stats)
    function displayUserStats($conn) {
        $sql = 'SELECT week_distance, month_distance, year_distance FROM users WHERE id = 1';
        foreach($conn->query($sql) as $row) {
            echo "<div class='label-stat-block'><div class='stat-block'>".$row['week_distance']." mi</div>";
            echo "<div class='label-block'>This Week</div></div>";

            echo "<div class='label-stat-block'><div class='stat-block'>".$row['month_distance']." mi</div>";
            echo "<div class='label-block'>This Month</div></div>";
            
            echo "<div class='label-stat-block'><div class='stat-block'>".$row['year_distance']." mi</div>";
            echo "<div class='label-block'>This Year</div></div>";
        }
    }
?>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this activity?")) {
            $.ajax({
                url: 'delete.php',
                type: 'post',
                data: {deleteId:id},
                error: function() {
                        alert("Sorry, we had trouble deleting that activity.")
                }
            });
            location.reload();
        }
    }
</script>