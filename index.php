<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Run Log</title>
        <link href="styles.css" type="text/css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nova+Round&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <?php
            include('getdata.php');
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
                    <form id="data-form" onsubmit="submitForm()">
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
                
                <!-- PHP code to get data from database -->
                <?php
                    $conn = connectToDatabase();
                    displayRunsTable($conn);
                ?>

                </table>
            </div>

            <div class="side-bar inline-block">
                <h2 class="side-bar-header">Quick Stats</h2>
                <?php
                    displayUserStats($conn);
                ?>

            </div>
        </div>

        <!-- function to submit form -->
        <script>
            function submitForm(){
                $.ajax({
                    url: 'insert.php',
                    type: 'post',
                    data: $('#data-form').serialize()
                });
            }
        </script>
    </body>
</html>