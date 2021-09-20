<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Run Log</title>
        <link href="styles.css" type="text/css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nova+Round&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">

        <!-- Connect to MySQL database using PDO driver (code from https://www.w3schools.com/php/php_mysql_connect.asp) -->
        <?php
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
        ?>
    </head>

    <body>
        <div class="logo">
            <h1>RUN LOG</h1>
        </div>

        <div class="main-content">
            <div class="form-container inline-block">
                <fieldset>
                    <legend><h2>Add a run</h2></legend>
                    <form action="insert.php" method="post">
                        <div class="form-field">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date">
                        </div>

                        <div class="form-field">
                            <label for="run-type">Run Type:</label>
                            <select id="run-type" name="run-type">
                                <option value="Easy">Easy</option>
                                <option value="Speedwork">Speedwork</option>
                                <option value="Tempo">Tempo</option>
                                <option value="Long Run">Long Run</option>
                            </select>
                        </div>

                        <div class="form-field">
                            <label for="distance">Distance (miles):</label>
                            <input type="number" id="distance" name="distance" step=".1">
                        </div>

                        <div class="form-field-group">
                            <label for="time">Time:</label>
                            <div class="sub-form-field">
                                <input type="number" id="time-hours" name="time-hours" min="0" max="23" placeholder="00">
                                <label for="time-hours">hr</label>
                            </div>
                            <div class="sub-form-field">
                                <input type="number" id="time-minutes" name="time-minutes" min="0" max="59" placeholder="00" >
                                <label for="time-minutes">min</label>
                            </div>
                            <div class="sub-form-field">
                                <input type="number" id="time-seconds" name="time-seconds" min="0" max="59" placeholder="00">
                                <label for="time-seconds">sec</label>
                            </div>
                        </div>

                        <div class="form-field">
                            <input type="submit" name="add-run" value="Add Run">
                        </div>
                    </form>
                </fieldset>
            </div>
                
            <div class="data-display-container inline-block">
                <table>
                    <tr><h2>Logged runs</h2></tr>
                    <tr>
                        <th>Date</th>
                        <th>Run type</th>
                        <th>Distance (miles)</th>
                        <th>Time</th>
                        <th>Average pace</th>
                    </tr>

                    <!-- SQL query to display data from 'runs' table -->
                    <!-- TO DO: update to only show data for specific user -->
                    <?php
                        // query database for variables
                        $sql = 'SELECT date, run_type, distance, time_hours, time_minutes, time_seconds, average_pace FROM runs';
                        foreach($conn->query($sql) as $row) {
                            echo "<tr>", "<td>", $row['date'], "</td>";
                            echo "<td>", $row['run_type'], "</td>";
                            echo "<td>", $row['distance'], "</td>";
                            echo "<td>", $row['time_hours'], ":", $row['time_minutes'], ":", $row['time_seconds'], "</td>";
                            echo "<td>", $row['average_pace'], "</td>", "</tr>";
                        }
                    ?>
                </table>
            </div>

            <div class="side-bar inline-block">
                <h2 class="side-bar-header">Quick Stats</h2>
                <div class="side-bar-stat">
                    <p>Miles this week: <span id="weekly-distance"> </span></p>
                </div>
                <div class="side-bar-stat">
                    <p>Miles this month: <span id="monthly-distance"> </span></p>
                </div>
                <div class="side-bar-stat">
                    <p>Miles this year: <span id="yearly-distance"> </span></p>
                </div>

            </div>
        </div>
    </body>
</html>