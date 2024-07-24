<?php
session_start();
$org_id = isset($_SESSION['org_id']) ? $_SESSION['org_id'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // PostgreSQL connection parameters
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

    $currentDate = date('Y-m-d');

    if (isset($_POST['submitEvent'])) {
        $name = $_POST['name'];
        $place = $_POST['place'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $round = $_POST['round'];
        $capacity = $_POST['capacity'];
        $type = $_POST['type'];
        $fee = $_POST['fee'];
        $o_id = $_POST['o_id'];
        $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';

        if ($date <= $currentDate) {
            echo "<script>alert('Please select a date greater than the current date.');</script>";
            exit; // Stop further execution
        }
        // Insert event details into events table
        $query = "INSERT INTO events (e_name, place, date, description, rounds, capacity,fee, type, image) 
                  VALUES ('$name', '$place', '$date', '$description', '$round', '$capacity','$fee','$type', '$image_url')";
        $result = pg_query($conn, $query);

        // Assuming $conn is the PostgreSQL connection object
    if ($result) {
    $que = pg_query($conn, "SELECT e_id FROM events WHERE e_name='$name' AND place='$place'");
    if($que){
        $eidrow = pg_fetch_assoc($que);
        if ($eidrow) {
            $eid = $eidrow['e_id'];
            $query1 = "UPDATE program SET o_id=$o_id WHERE prog_id=$eid";
            $result1 = pg_query($conn, $query1);
            if ($result1) {
                echo "<script>alert('Event registration successful');</script>";
            }
        }

        } 
    }else {
            echo "<script>alert('Error: " . pg_last_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['submitWorkshop'])) {
        $name = $_POST['name'];
        $place = $_POST['place'];
        $date = $_POST['date'];
        $type = $_POST['type'];
        $capacity = $_POST['capacity'];
        $conductedby = $_POST['conductedby'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
        $fee = $_POST['fee'];
        $o_id = $_POST['o_id'];
        $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';
        if ($date <= $currentDate) {
            echo "<script>alert('Please select a date greater than the current date.');</script>";
            exit; // Stop further execution
        }


        // Insert workshop details into workshops table
        $query = "INSERT INTO workshops (w_name, place, date, capacity,fee, type, conducted_by, start_time, end_time,image) 
                  VALUES ('$name', '$place', '$date', '$capacity','$fee','$type', '$conductedby', '$starttime', '$endtime', '$image_url')";
        $result = pg_query($conn, $query);

        if ($result) {
            $que=pg_query($conn,"SELECT w_id from workshops where w_name='$name' AND place='$place'");   
            $widrow=pg_fetch_assoc($que);
            $wid=$widrow['w_id']; 
            $query1 = "UPDATE program set o_id=$o_id where prog_id=$wid";
            $result1 = pg_query($conn, $query1);
            if($result1){
                echo "<script>alert('Event registration successful');</script>";
            }
           
        }  else {
            // If insertion fails, display error message
            echo "<script>alert('Error: " . pg_last_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['submitGuestLecture'])) {
        $name = $_POST['name'];
        $place = $_POST['place'];
        $date = $_POST['date'];
        $type = $_POST['type'];
        $capacity = $_POST['capacity'];
        $speaker = $_POST['speaker'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
        $fee = $_POST['fee'];
        $o_id = $_POST['o_id'];
        $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';

        if ($date <= $currentDate) {
            echo "<script>alert('Please select a date greater than the current date.');</script>";
            exit; // Stop further execution
        }


        // Insert guest lecture details into guest_lectures table
        $query = "INSERT INTO guest_lectures (gl_name, place, date, capacity,fee, type, speaker, start_time, end_time, image) 
                  VALUES ('$name', '$place', '$date', '$capacity','$fee', '$type', '$speaker', '$starttime', '$endtime', '$image_url')";
        $result = pg_query($conn, $query);

        if ($result) {
            $que=pg_query($conn,"SELECT gl_id from guest_lectures where gl_name='$name' AND place='$place'");   
            $glidrow=pg_fetch_assoc($que);
            $glid=$glidrow['gl_id']; 
            $query1 = "UPDATE program set o_id=$o_id where prog_id=$glid";
            $result1 = pg_query($conn, $query1);
            if($result1){
                echo "<script>alert('Event registration successful');</script>";
            }
           
        }  else {
            // If insertion fails, display error message
            echo "<script>alert('Error: " . pg_last_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['submitHackathon'])) {
        $name = $_POST['name'];
        $place = $_POST['place'];
        $date = $_POST['date'];
        $type = $_POST['type'];
        $capacity = $_POST['capacity'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
        $o_id = $_POST['o_id'];
        $fee = $_POST['fee'];
        $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';
        if ($date <= $currentDate) {
            echo "<script>alert('Please select a date greater than the current date.');</script>";
            exit; // Stop further execution
        }
        // Insert hackathon details into hackathons table
        $query = "INSERT INTO hackathons (h_name, place, date, capacity,fee, type, start_time, end_time,image) 
                  VALUES ('$name', '$place', '$date', '$capacity','$fee', '$type', '$starttime', '$endtime', '$image_url')";
        $result = pg_query($conn, $query);

        if ($result) {
            $que=pg_query($conn,"SELECT h_id from hackathons where h_name='$name' AND place='$place'");   
            $hidrow=pg_fetch_assoc($que);
            $hid=$hidrow['h_id']; 
            $query1 = "UPDATE program set o_id=$o_id where prog_id=$hid";
            $result1 = pg_query($conn, $query1);
            if($result1){
                echo "<script>alert('Event registration successful');</script>";
            }
           
        } else {
            // If insertion fails, display error message
            echo "<script>alert('Error: " . pg_last_error($conn) . "');</script>";
        }
    }

    // Close database connection
    pg_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-+PXE0/7iTLzgMM50ihGqA5LCFX9eoV+9KhBv0AHcQ0JHSpSH6TkQUqVyQlp3d1r4nVctBdJyYIv9ENhCr8QlFQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            padding: 20px;
        }
        .events {
            flex: 1;
            margin-right: 20px;
        }
        .upload-form {
            flex: 1;
        }
        .event {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .event img {
            width: 200px; /* Set a fixed width for the images */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Prevents extra space below image */
            margin-bottom: 10px;
        }
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="file"] {
            display: none;
        }
        .upload-btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            margin-bottom: 10px;
        }
        .upload-btn i {
            margin-right: 5px;
        }
        .upload-btn-label {
            cursor: pointer;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        header {
            background-color: #333;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .user-section {
            display: flex;
            align-items: center;
        }

        .user-info {
            margin-right: 10px;
        }

        .settings i {
            margin-right: 5px;
        }

        .settings a {
            color: #fff;
            text-decoration: none;
        }

        .settings a:hover {
            text-decoration: underline;
        }
        .arrow-icon {
    color: white;
    cursor: pointer;
    margin-right: 20px; /* Adjusted margin */
  }

  .welcome {
    margin-right: 20px; /* Adjusted margin */
  }

  .welcome,
  .login-link {
    color: white;
    text-decoration: none;
  }
    </style>
</head>
<body>
    <header>
        <div class="logo">
        <i class="fas fa-arrow-left" onclick="history.back();" style="color: white; cursor: pointer; margin-left: 5px;margin-right:10px"></i>
            <p style="color:white"><b>EVENT MANAGEMENT SYSTEM</b></p>
        </div>
        <div class="user-section">
        <div class="user-info">
            <?php
            if(isset($_SESSION['org_id'])) {
                // User is logged in
                echo "<span>Welcome, $org_id</span>";
            } else {
                // User is not logged in
                echo "<span>Welcome, Guest</span>";
            }
            ?>
        </div>
        <div class="settings">
            <?php
            if(isset($_SESSION['org_id'])) {
                // User is logged in
                echo "<a href='logout.php'>Logout</a>"; // Assuming logout.php handles logout logic
            } else {
                // User is not logged in
                echo "<a href='loginpage.html'>Login</a>"; // Assuming login.php is your login page
            }
            ?>
        </div>
    </div>
    </header>
    <div class="container">
        <div class="events" id="eventsContainer">
            <h2>What do you want to add?</h2>
            <button name='Add events' id='addevent' onclick='addevent()'>ADD EVENT</button>
            <button name='Add workshop' id='addworkshop' onclick='addworkshop()'>ADD WORKSHOP</button>
            <button name='Add guestlecture' id='addguestlecture' onclick='addguestlecture()'>ADD GUEST LECTURE</button>
            <button name='Add hackathon' id='addhackathon' onclick='addhackathon()'>ADD HACKATHON</button>
           
        </div>
        <div class="upload-form" id='forminput'>
            <br><h2>click the buttons to add</h2>
        </div>   
    </div>
    <script>
        function addevent(){
            document.getElementById("forminput").innerHTML=' <h2>Add New Event</h2>\
            <form id="eventForm" action="" method="POST" enctype="multipart/form-data">\
                <input type="text" name="name" placeholder="Event Name" required><br>\
                <input type="text" name="place" placeholder="Place" required><br>\
                <input type="date" name="date" required><br>\
                <textarea name="description" placeholder="Description" required></textarea><br>\
                <input type="text" name="round" placeholder="Round" required><br>\
                <input type="text" name="capacity" placeholder="Capacity" required><br>\
                <input type="text" name="type" placeholder="type" required><br>\
                <input type="text" name="o_id" placeholder="organiser id" required><br>\
                <input type="text" name="fee" placeholder="fee" required><br>\
                <input type="text" name="image_url" placeholder="Image URL (Optional)"><br>\
                <input type="submit" name="submitEvent" value="Upload Event">\
            </form>';
        }
        function addworkshop(){
            document.getElementById("forminput").innerHTML=' <h2>Add New WORKSHOP</h2>\
            <form id="workshopForm" action="" method="POST" enctype="multipart/form-data">\
                <input type="text" name="name" placeholder="Workshop Name" required><br>\
                <input type="text" name="place" placeholder="Place" required><br>\
                <input type="date" name="date" required><br>\
                <input type="text" name="type" placeholder="type" required><br>\
                <input type="text" name="capacity" placeholder="Capacity" required><br>\
                <input type="text" name="conductedby" placeholder="Conducted By" required><br>\
                Start time: <input type="time" name="starttime" placeholder="Start Time" required><br>\
                End time: <input type="time" name="endtime" placeholder="End Time" required><br>\
                <input type="text" name="fee" placeholder="fee" required><br>\
                <input type="text" name="o_id" placeholder="organiser id" required><br>\
                <input type="text" name="image_url" placeholder="Image URL (Optional)"><br>\
                <input type="submit" name="submitWorkshop" value="Upload Workshop">\
            </form>';
        }
        function addguestlecture(){
            document.getElementById("forminput").innerHTML=' <h2>Add New GUEST LECTURE</h2>\
            <form id="guestLectureForm" action="" method="POST" enctype="multipart/form-data">\
                <input type="text" name="name" placeholder="Guest Lecture Name" required><br>\
                <input type="text" name="place" placeholder="Place" required><br>\
                <input type="date" name="date" required><br>\
                <input type="text" name="type" placeholder="Type" required><br>\
                <input type="text" name="capacity" placeholder="Capacity" required><br>\
                <input type="text" name="speaker" placeholder="Speaker" required><br>\
                Start time: <input type="time" name="starttime" placeholder="Start Time" required><br>\
                End time: <input type="time" name="endtime" placeholder="End Time" required><br>\
                <input type="text" name="fee" placeholder="fee" required><br>\
                <input type="text" name="o_id" placeholder="organiser id" required><br>\
                <input type="text" name="image_url" placeholder="Image URL (Optional)"><br>\
                <input type="submit" name="submitGuestLecture" value="Upload Guest Lecture">\
            </form>';
        }
        function addhackathon(){
            document.getElementById("forminput").innerHTML=' <h2>Add New HACKATHON</h2>\
            <form id="hackathonForm" action="" method="POST" enctype="multipart/form-data">\
                <input type="text" name="name" placeholder="Hackathon Name" required><br>\
                <input type="text" name="place" placeholder="Place" required><br>\
                <input type="date" name="date" required><br>\
                <input type="text" name="type" placeholder="Type" required><br>\
                <input type="text" name="capacity" placeholder="Capacity" required><br>\
                Start time: <input type="time" name="starttime" placeholder="Start Time" required><br>\
                End time: <input type="time" name="endtime" placeholder="End Time" required><br>\
                <input type="text" name="fee" placeholder="fee" required><br>\
                <input type="text" name="o_id" placeholder="organiser id" required><br>\
                <input type="text" name="image_url" placeholder="Image URL (Optional)"><br>\
                <input type="submit" name="submitHackathon" value="Upload Hackathon">\
            </form>';
        }
    </script>
</body>
</html>
