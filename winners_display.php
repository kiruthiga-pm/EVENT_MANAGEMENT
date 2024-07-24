<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winners</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        .event {
            flex: 1;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
        }
        .event h2 {
            text-align: center;
        }
        .winner {
            margin-bottom: 20px;
        }
        .winner img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
            display: block;
            margin: 0 auto;
        }
        .winner p {
            text-align: center;
        }
        .event-info {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="event">
            <h2>Event Winners</h2>
            <?php
            // Connect to PostgreSQL database
            $dbconn = pg_connect("host=localhost dbname=postgres user=postgres password=PMkiruthi")
                or die('Could not connect: ' . pg_last_error());

            // Query to get event winners and related information from the view
            $query = "SELECT * FROM event_winners";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());

            // Display event winners and related information
            while ($row = pg_fetch_assoc($result)) {
                echo '<div class="winner">';
                echo '<h3>' . $row['name'] . ' - ' . $row['organisation_name'] . '</h3>';
                echo '<p><strong>Date:</strong> ' . $row['date'] . '</p>';
                echo '<p><strong>Place:</strong> ' . $row['place'] . '</p>';
                echo '<p class="event-info"><strong>Participants:</strong> ';
                
                // Remove curly braces from participants_name
                $participants = str_replace(array('{', '}'), '', $row['participants_name']);
                echo $participants;
                
                echo '</p>';
                echo '</div>';
            }
            echo '<br><h2>Hackathon winners</h2>';
             // Query to get event winners and related information from the view
             $query = "SELECT * FROM hackathon_winners";
             $result = pg_query($query) or die('Query failed: ' . pg_last_error());
 
             // Display event winners and related information
             while ($row = pg_fetch_assoc($result)) {
                 echo '<div class="winner">';
                 echo '<h3>' . $row['name'] . ' - ' . $row['organisation_name'] . '</h3>';
                 echo '<p><strong>Date:</strong> ' . $row['date'] . '</p>';
                 echo '<p><strong>Place:</strong> ' . $row['place'] . '</p>';
                 echo '<p class="event-info"><strong>Participants:</strong> ';
                 
                 // Remove curly braces from participants_name
                 $participants = str_replace(array('{', '}'), '', $row['participants_name']);
                 echo $participants;
                 
                 echo '</p>';
                 echo '</div>';
             }

            // Free result and close connection
            pg_free_result($result);
            pg_close($dbconn);
            ?>
        </div>
    </div>
</body>
</html>