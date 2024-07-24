<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0; /* Changed margin to 0 for better centering */
        }

        #background-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensure the image covers the entire container */
            z-index: -1; /* Place the image behind other elements */
          
        }
        #id1{
            background-color: #136718;}
        #volunteer-signin-box {
            background: rgba(255, 255, 255, 0.8);
            width: 80%; /* Adjusted width */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            z-index: 1; /* Place the login box in front of the background image */
        }

        #volunteer-signin-form {
            width: 60%; /* Changed width to 60% */
            margin: 0 auto; /* Added to center the form horizontally */
        }

        input {
            font-size: 16px; /* Adjust the font size as needed */
            width: 100%; /* Ensure the input fields take up the full width of their container */
            padding: 10px; /* Added padding for better appearance */
            margin-bottom: 10px; /* Added margin for better separation between input fields */
            border-radius: 5px; /* Added border-radius for rounded corners */
            border: 1px solid #ccc; /* Added border for better visibility */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Added box shadow */
        }
        label {
            text-align: left; /* Align labels to the left */
            display: block; /* Ensure labels are on a new line */
        }

        #volunteer-submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <title>volunteer signin Page</title>
    
</head>
<body>
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $user_password = $_POST['pwd1']; // Hash the password before storing
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $cname = $_POST['cname'];
    $mobile = $_POST['mobile'];
    $confirm_password = $_POST['pwd2']; // Added line to retrieve confirm password

    // Check if passwords match
    if ($user_password !== $confirm_password) {
        // Passwords don't match, display error message and terminate script
        echo "Error: Passwords do not match. Please try again.";
        exit();
    }

    

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email format is invalid
        echo "Error: Email is invalid. Please enter a valid email address.";
        exit();
    }

    // Database connection parameters
    $host = "localhost";
    $port = "5432";
    $dbname = "postgres";
    $user = "postgres";
    $password = "PMkiruthi";

    // Connect to the PostgreSQL database
    $dbconn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    // Check if the connection is successful
    if (!$dbconn) {
        die("Error: Unable to connect to the database.");
    }
    
    // Insert data into the user_tab table
    $sql_user = "INSERT INTO user_tab(user_name, user_password) VALUES ('$name', '$user_password')";
    $result_user = pg_query($dbconn, $sql_user);

    if (!$result_user) {
        // Display error message if insertion into user_tab fails
        echo "Error: Unable to register user. Please try again.";
        exit();
    }

    // Retrieve the user_id of the inserted user
    $user_id_query = pg_query($dbconn, "SELECT user_id FROM user_tab WHERE user_name = '$name'");
    $user_id_row = pg_fetch_assoc($user_id_query);
    $user_id = $user_id_row['user_id'];

    // Insert data into the participants table
    $sql_participant = "INSERT INTO volunteers(v_id,v_name, email, contact, dob, address) 
                        VALUES ( '$user_id','$name', '$email', '$mobile', '$dob', '$address')";
    $result_participant = pg_query($dbconn, $sql_participant);

    if (!$result_participant) {
        // Display error message if insertion into participants fails
        echo "Error: Unable to register volunteer. Please try again.";
        exit();
    }
    $query = "SELECT * FROM volunteers WHERE v_id = '$user_id'";
    $result = pg_query($dbconn, $query);
    if (!$result) {
        echo "Error fetching participant details.";
        exit;
    }

    // Loop through participants and send email to each
    while ($row = pg_fetch_assoc($result)) {
        $participant_name = $row['p_name'];
        $participant_email = $row['email'];
        $p_id = $row['v_id'];
        // Email details
        $to = $participant_email;
        $subject = "Payment Confirmation for Program Registration";
        $message = "Dear $participant_name,\n\n";
        $message .= "Thank you for logining in to event management system.\n\n";
        $message .= " your user ID : $user_id\n";
        $message .= "If you have any questions, feel free to contact us.\n\n";
        $message .= "Best regards,\nThe Team";
        $from = 'pmkiruthi1704@gmail.com';
        $headers = 'From: ' . $from;
        // Send email
        $mail_sent = mail($to, $subject, $message, $headers);

        // Check if email is sent successfully
        if ($mail_sent) {
            echo "<script>alert('Email sent to $participant_email successfully.<br>');</script>";
        } else {
            echo "Failed to send email to $participant_email.<br>";
        }
    }
    // Close database connection
    pg_close($dbconn);
    // Redirect to participant_home.html upon successful registration
    header("Location: newlogin2.php");
    exit();
}
?>



    <div id="volunteer-signin-box">
        <h2>volunteer signin</h2>
        <form action="volunteersigninpage.php" method="post" onsubmit="return validateAndLogin(event)">
        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" placeholder="Enter your name" required> <br>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
        <label for="cname">College Name</label><br>
        <input type="text" id="cname" name="cname" placeholder="Enter your college name" required><br>
        <label for="mobile">Mobile</label><br>
        <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" pattern="[0-9]{10}" required><br><br>
        <label for="dob">Date of Birth</label><br>
        <input type="date" id="dob" name="dob"><br>
        <label for="address">Address</label><br>
        <input type="text" id="address" name="address" placeholder="Enter your address" required><br>
        <label for="pwd1">Password</label><br>
        <input type="password" id="pwd1" name="pwd1" placeholder="Enter your password" required><br>
        <label for="pwd2">Confirm Password</label><br>
        <input type="password" id="pwd2" name="pwd2" placeholder="Confirm your password" required><br>
        <input type="submit" value="volunteer" id="id1">
    </form>
    </div>

    <script>
        function validateAndLogin(event) {
            var password = document.getElementById('pwd1').value;
            var confirm_password = document.getElementById('pwd2').value;
            var mobile = document.getElementById('mobile').value;
            var email = document.getElementById('email').value;
            
            // Validate if passwords match
            if (password !== confirm_password) {
                alert('Passwords do not match');
                event.preventDefault(); // Prevent form submission
                return false;
            }
            
            // Validate mobile number
        

            // Validate email
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Email is invalid. Please enter a valid email address.');
                event.preventDefault(); // Prevent form submission
                return false;
            }

            return true; // All validations passed, allow form submission
        }
    </script>
</body>
</html>