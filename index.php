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
        <div id="logo">
            <h1>RUN LOG</h1>
        </div>

        <div id="add-run-form">
            <fieldset>
                <legend><h2>Add a run</h2></legend>
                <form action="">
                    <div class="form-field">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date">
                    </div>

                    <div class="form-field">
                        <label for="run-type">Run Type</label>
                        <select id="run-type" name="run-type">
                            <option value="easy">Easy</option>
                            <option value="speedwork">Speedwork</option>
                            <option value="tempo">Tempo</option>
                            <option value="long">Long Run</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <label for="distance">Distance (miles)</label>
                        <input type="number" id="distance" name="distance" step=".1">
                    </div>

                    <div class="form-field">
                        <label for="time">Time</label>
                        <input type="text" id="time" name="time">
                    </div>

                    <div class="form-field">
                        <label for="average-pace">Average pace</label>
                        <input type="text" id="average-pace" name="average-pace">
                    </div>

                    <div class="form-field">
                        <input type="submit" name="add-run" value="Add Run">
                    </div>
                </form>
            </fieldset>
        </div>
            
        <div id="run-log-table">
            <table>
                <tr><h2>Logged runs</h2></tr>
                <tr>
                    <th>Date</th>
                    <th>Run type</th>
                    <th>Distance (miles)</th>
                    <th>Time</th>
                    <th>Average pace</th>
                </tr>
                <tr>
                    <td>9/1/21</td>
                    <td>Easy</td>
                    <td>5</td>
                    <td>60:01</td>
                    <td>12:02</td>
                </tr>
            </table>
        </div>

        <div id="side-bar">
            <h2 id="side-bar-header">Quick Stats</h2>
            <div class="side-bar-stat">
                <p>Miles this week:</p>
            </div>
            <div class="side-bar-stat">
                <p>Miles this month:</p>
            </div>
            <div class="side-bar-stat">
                <p>Miles this year:</p>
            </div>

        </div>
    </body>
</html>