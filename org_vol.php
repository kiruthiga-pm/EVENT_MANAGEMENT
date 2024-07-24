<?php
session_start();
$org_id = isset($_SESSION['org_id']) ? $_SESSION['org_id'] : "";
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
            <p style="color:white"><b>EVNET MANAGEMENT SYSTEM</b></p>
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
                echo "<a href='loginpage.html'>Logout</a>"; // Assuming logout.php handles logout logic
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
            <h2>VOLUNTEERS</h2>
            <?php
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

            // Execute SELECT query to retrieve event details
            $query = "SELECT V_id, V_name, email, contact FROM volunteers where o_id in (select o_id from organiser where org_id= $org_id)";
            $result = pg_query($conn, $query);

            if (!$result) {
                echo "Failed to retrieve events from the database.";
                exit;
            }

            // Display retrieved event details
            while ($row = pg_fetch_assoc($result)) {
                echo "<div class='event'>";
                echo "<h3>" . $row['v_name'] . "</h3>";
                echo "<p>ID: " . $row['v_id'] . "</p>";
                echo "<p>email: " . $row['email'] . "</p>";
                echo "<p>contact: " . $row['contact'] . "</p>";
                echo "</div>";
            }

            // Close database connection
            pg_close($conn);
            ?>
        </div>
        <div class="upload-form">
            <h2>Add New Volunteer</h2>
            <form id="eventForm" action="" method="POST" enctype="multipart/form-data">
                <input type="number" name="v_id" placeholder="volunteer_id" required><br>
                <input type="number" name="o_id" placeholder="organiser_id" required><br>
                <input type="submit" value="Add volunteers">
            </form>
            <?php
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

            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve form data
                $v_id = $_POST['v_id'];
                $o_id = $_POST['o_id'];
                $query = "SELECT v_id FROM volunteers WHERE v_id = $v_id";
                $result = pg_query($conn, $query);
                
                if (pg_num_rows($result) > 0) {
                    // Volunteer ID exists, proceed with updating organization ID
                    $query1 = "UPDATE volunteers SET o_id = $o_id WHERE v_id = $v_id";
                    $result1 = pg_query($conn, $query1);
            
                    if ($result1) {
                        // Update successful
                        // Redirect to success page or perform any other action
                        header("Location: success.php");
                        exit();
                    } else {
                        // Display error message if update fails
                        echo '<script>alert("Failed to update organization ID."); window.location.href = "org_vol.php";</script>';
                        exit();
                    }
                } else {
                    // Volunteer ID does not exist
                    echo '<script>alert("Invalid volunteer ID."); window.location.href = "org_vol.php";</script>';
                    exit();
                }
            }
            

            // Close database connection
            pg_close($conn);
            ?>
        </div>
    </div>
</body>
</html>
