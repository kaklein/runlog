<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Run Log</title>
        <link href="styles.css" type="text/css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

        <?php
            include('getdata.php');
            include('connect.php');
            $conn = connectToDatabase();
        ?>
    </head>

    <body>
        <div class="logo">
            <img src="images/runlog_logo.png">
        </div>
        
        <div class="main-content">
            <div class="form-container block">
                <h2>Add a Run</h2>
                <form id="data-form" onsubmit="submitForm()">
                    <div class="form-field">
                        <label for="run-date">Date:</label>
                        <input type="date" id="run-date" name="run-date">
                    </div>

                    <div class="form-field">
                        <label for="run-type">Run Type:</label>
                        <select id="run-type" name="run-type">
                            <option value="Easy">Easy</option>
                            <option value="Speedwork">Speedwork</option>
                            <option value="Tempo">Tempo</option>
                            <option value="Long Run">Long Run</option>
                            <option value="Race">Race</option>
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

                    <input type="submit" name="add-run" value="Add Run" class="button">
                </form>
            </div>
                
            <div class="data-display-container inline-block">
                <div class="data-table">
                    <h2>Logged Runs</h2>
                    <div class="table-contents">
                        <table>
                            <tr>
                                <th class="th-left-end">Date</th>
                                <th>Run Type</th>
                                <th>Distance<br>(miles)</th>
                                <th>Time<br>(HH:MM:SS)</th>
                                <th class="th-right-end">Average<br>Pace</th>
                                <th class="no-styling"></th>
                            </tr>
                        
                        <!-- PHP code to get data from database -->
                        <?php
                            displayRunsTable($conn);
                        ?>

                        </table>
                    </div>
                </div>
            </div>

            <div class="quick-stats">
                <h2 class="quick-stats-header">Quick Stats</h2>
                <?php
                    displayUserStats($conn);
                ?>
            </div>
        </div>

        <!-- function to submit form -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function submitForm(){
                $.ajax({
                    url: 'insert.php',
                    type: 'post',
                    data: $('#data-form').serialize()
                });
                location.reload();
            }
        </script>
    </body>
</html>