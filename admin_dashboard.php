
<?php
$dbhost = 'localhost';
$dbname = 'postgres';
$dbuser = 'postgres';
$dbpass = 'PMkiruthi';

// Connect to PostgreSQL database
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
    echo "Failed to connect to PostgreSQL database.";
    exit;
}
$sql1="SELECT COUNT(*) FROM events";
$result1=pg_query($conn,$sql1);
$count1 = pg_fetch_result($result1, 0, 0);

$sql2="SELECT COUNT(*) FROM workshops";
$result2=pg_query($conn,$sql2);
$count2 = pg_fetch_result($result2, 0, 0);

$sql3="SELECT COUNT(*) FROM guest_lectures";
$result3=pg_query($conn,$sql3);
$count3 = pg_fetch_result($result3, 0, 0);

$sql4="SELECT COUNT(*) FROM hackathons";
$result4=pg_query($conn,$sql4);
$count4 = pg_fetch_result($result4, 0, 0);

$sql5="SELECT COUNT(*) FROM participants";
$result5=pg_query($conn,$sql5);
$count5 = pg_fetch_result($result5, 0, 0);

$sql6="SELECT COUNT(*) FROM organiser";
$result6=pg_query($conn,$sql6);
$count6 = pg_fetch_result($result6, 0, 0);

$sql7="SELECT COUNT(*) FROM organisation";
$result7=pg_query($conn,$sql7);
$count7 = pg_fetch_result($result7, 0, 0);

$sql8="SELECT COUNT(*) FROM volunteers";
$result8=pg_query($conn,$sql8);
$count8 = pg_fetch_result($result8, 0, 0);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #0f232b;
            font-family: Arial, sans-serif;
        }

        /* Header Styles */
        .header {
            background-color: #056e6a;
            color: white;
            padding: 20px;
            text-align: center;
            
        }

        /* Sidebar Styles */
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
            
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        /* Content Styles */
        .content {
            margin-left: 200px;
            padding: 20px;
        }

        .container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .box {
            background-color: #c3dfe3;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            flex: 1;
            min-width: 200px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
            transition: 0.3s;
        }

        .box:hover {

            box-shadow: 0 8px 16px rgba(255, 255, 255, 0.2);
        }

        .box h2 {
            text-align: center;
        }

        .box p {
            text-align: center;
            font-size: 20px;
            margin-top: 10px;
        }

        .box a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: 0.3s;
        }

        .box a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #0f232b;
            border-radius: 8px;
            color:#acf0fa;
            font-weight:bolder;
            font-size:20px;
            border: 2px solid rgba(0, 0, 0, 0.1);
        }
        header{
            background-color: #0f232b;
            
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th{
            color: white;
        }
        .event, .workshop, .guest-lecture, .hackathon {
            padding: 8px;
            text-align: center;
            font-size: 14px;
            border-radius: 6px;
            margin: 2px;
            display: inline-block;
        }
        .event {
            background-color: #ffc107;
            color: #333;
        }
        .workshop {
            background-color: #28a745;
            color: #fff;
        }
        .guest-lecture {
            background-color: #007bff;
            color: #fff;
        }
        .hackathon {
            background-color: #dc3545;
            color: #fff;
        }

        /* Responsive Styles */
        @media screen and (max-width: 600px) {
            th, td {
                padding: 8px;
            }
            .event, .workshop, .guest-lecture, .hackathon {
                padding: 6px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Event Management System Dashboard</h1>
    </div>

    <div class="sidebar">
        <br><br><br><br><br>
        <a href="view_events.php">View Events</a>
        <a href="view_workshops.php">View Workshops</a>
        <a href="view_hackathons.php">View Hackathons</a>
        <a href="view_guest_lectures.php">View Guest Lectures</a>
        <a href="view_participants.php">View Participants</a>
        <a href="view_organisers.php">View Organisers</a>
        <a href="view_organisations.php">View Organisations</a>
        <a href="view_volunteers.php">View Volunteers</a>
        <a href="view_p_events.php">View participants registration</a>
        <a href="admin_organisation.php">Add organisation</a>
        <a href="winners_display.php">View Winners</a>
    </div>

    <div class="content">
        <div class="container">
            <div class="box">
                <h2>Total Events</h2>
                <p><?php echo $count1;?></p>
                <a href="view_events.php">View Events</a>
            </div>
            <div class="box">
                <h2>Total Workshops</h2>
                <p><?php echo $count2;?></p>
                <a href="view_workshops.php">View Workshops</a>
            </div>
            <div class="box">
                <h2>Total Hackathons</h2>
                <p><?php echo $count4;?></p>
                <a href="view_hackathons.php">View Hackathons</a>
            </div>
            <div class="box">
                <h2>Total Guest Lectures</h2>
                <p><?php echo $count3;?></p>
                <a href="view_guest_lectures.php">View Guest Lectures</a>
            </div>
            <div class="box">
                <h2>Total participants</h2>
                <p><?php echo $count5;?></p>
                <a href="view_participants.php">View participants</a>
            </div>
            <div class="box">
                <h2>Total organisers</h2>
                <p><?php echo $count6;?></p>
                <a href="view_organisers.php">View participants</a>
            </div>
            <div class="box">
                <h2>Total organisations</h2>
                <p><?php echo $count7;?></p>
                <a href="view_organisations.php">View participants</a>
            </div>
            <div class="box">
                <h2>Total volunteers</h2>
                <p><?php echo $count8;?></p>
                <a href="view_volunteers.php">View participants</a>
            </div>
        </div>
        <table>
    <thead>
        <tr>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Your database connection code
        $db_host = 'localhost';
        $db_name = 'postgres';
        $db_user = 'postgres';
        $db_pass = 'PMkiruthi';

        try {
            $pdo = new PDO("pgsql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }

        // Fetch events, workshops, guest lectures, and hackathons from the database
        $events_query = $pdo->query("SELECT date FROM events");
        $workshops_query = $pdo->query("SELECT date FROM workshops");
        $guest_lectures_query = $pdo->query("SELECT date FROM guest_lectures");
        $hackathons_query = $pdo->query("SELECT date FROM hackathons");

        $events = $events_query->fetchAll(PDO::FETCH_COLUMN);
        $workshops = $workshops_query->fetchAll(PDO::FETCH_COLUMN);
        $guest_lectures = $guest_lectures_query->fetchAll(PDO::FETCH_COLUMN);
        $hackathons = $hackathons_query->fetchAll(PDO::FETCH_COLUMN);

        // Generate calendar
        $month = date('m');
        $year = date('Y');
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $first_day = date('N', strtotime("$year-$month-01"));
        $last_day = date('N', strtotime("$year-$month-$days_in_month"));
        $calendar = [];
        $day_count = 1;

        for ($i = 0; $i < 6; $i++) {
            for ($j = 1; $j <= 7; $j++) {
                if ($i == 0 && $j < $first_day) {
                    $calendar[$i][$j] = '';
                } elseif ($day_count > $days_in_month) {
                    $calendar[$i][$j] = '';
                } else {
                    $calendar[$i][$j] = $day_count;
                    $day_count++;
                }
            }
        }

        // Display calendar
        foreach ($calendar as $week) {
            echo "<tr>";
            foreach ($week as $day) {
                if (!empty($day)) {
                    $date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $event_class = (in_array($date, $events)) ? 'event' : '';
                    $workshop_class = (in_array($date, $workshops)) ? 'workshop' : '';
                    $guest_lecture_class = (in_array($date, $guest_lectures)) ? 'guest-lecture' : '';
                    $hackathon_class = (in_array($date, $hackathons)) ? 'hackathon' : '';

                    $label = '';
                    if ($event_class) $label .= 'Event ';
                    if ($workshop_class) $label .= 'Workshop ';
                    if ($guest_lecture_class) $label .= 'Guest Lecture ';
                    if ($hackathon_class) $label .= 'Hackathon ';

                    echo "<td class='$event_class $workshop_class $guest_lecture_class $hackathon_class'>$day<br>$label</td>";
                } else {
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
    </div>
    

</body>

</html>
