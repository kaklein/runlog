<?php
    //SQL query to display data from 'runs' table with pagination
    // pagination code modified from https://javatpoint.com/php-pagination
    //TO DO: update to only show data for specific user
    function displayRunsTable($conn) {
        // get current page number
        if(!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        // Pagination formula
        $results_per_page = 10;
        $page_first_result = ($page - 1) * $results_per_page; // which result to start on for the current page
        
        // get number of total rows/pages to display
        $stmt = $conn->prepare("SELECT count(*) FROM runs WHERE user_id = ?");
        $user_id = 1;
        $stmt->execute([$user_id]); // TO DO: use user_id variable as argument when different users are accepted
        $number_of_results = $stmt->fetchColumn();
        $number_of_pages = ceil($number_of_results / $results_per_page);
   
        // query records
        $sql = 'SELECT run_date, run_type, distance, time_hours, time_minutes, time_seconds, average_pace, id ' 
            . 'FROM runs '
            . ' WHERE user_id = 1 '
            . 'ORDER BY run_date DESC '
            . 'LIMIT ' . $page_first_result . ', ' . $results_per_page; // limit # results for pagination
        
        // display records
        foreach($conn->query($sql) as $row) {
            // Display data in table
            echo "<tr>", "<td>", $row['run_date'], "</td>";
            echo "<td>", $row['run_type'], "</td>";
            echo "<td>", $row['distance'], "</td>";
            echo "<td>", sprintf("%02d", $row['time_hours']), ":", sprintf("%02d", $row['time_minutes']), ":", sprintf("%02d", $row['time_seconds']), "</td>";
            echo "<td>", $row['average_pace'], "</td>";

            // Display delete/edit buttons
            echo "<td><form class=delete-form onsubmit='confirmDelete(" . $row['id'] . ")'>"; // Delete button
                echo "<input type='submit' class='delete-button button' value='Delete'></input></form></td>";
            //echo "<td><a href='edit.php?id=", $row['id'], "'>Edit</a></td></tr>"; // Edit button - TO DO: make it function
        }

        // Display page number buttons
        echo "<tr><td colspan='6' class='page-number-row'>";
        
        // previous button
        $previous_disabled = ($page <= 1) ? "disabled" : "enabled";
        echo "<a href='index.php?page=" . ($page - 1) . "' class='page-number " . $previous_disabled . "'>Previous</a>";
        
        // page number buttons
        for($page_number = 1; $page_number <= $number_of_pages; $page_number++) {
            $current_page = ($page == $page_number) ? "current-page disabled" : "not-current-page";
            echo "<a href='index.php?page=" . $page_number . "' class='page-number " . $current_page . "'>" . $page_number . "</a>";
        }
        
        // next button
        $next_disabled = ($page >= $number_of_pages) ? "disabled" : "enabled";
        echo "<a href='index.php?page=" . ($page + 1) . "' class='page-number " . $next_disabled . "'>Next</a>";
        echo "</td></tr>";
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