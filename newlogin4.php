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
            height: 100vh;
            margin: 0;
            overflow: hidden; /* Hide scrollbars */
            background-image: url('https://i.pinimg.com/564x/f0/35/fa/f035fae858ddaee564352eb5936a5f2c.jpg'); /* Use the correct path to your background image */
            background-size: cover;
        }

        #login-box {
            width:20%;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #login-box input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
        }

        #login-button, #signup-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Add transition effect */
        }

        #login-button:hover, #signup-button:hover {
            background-color: #45a049; /* Change color on hover */
        }
    </style>
    <title>Login and Signup Page</title>
</head>
<body>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $org_id = $_POST['org_id'];
    $password = $_POST['password'];

    // Establish a database connection
    $databaseConnection = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=PMkiruthi");

    if (!$databaseConnection) {
        die("Connection failed. Error: " . pg_last_error($databaseConnection));
    }

    // Check if the form is for login or signup
    if (isset($_POST['login'])) {
        // Login form submitted
        
        $result = pg_query_params($databaseConnection, 'SELECT org_name, org_id, password FROM organisation WHERE org_name = $1 AND org_id = $2 AND password = $3', array($name, $org_id, $password));

        if (!$result) {
            die("Query failed. Error: " . pg_last_error($databaseConnection));
        }

        $numRows = pg_num_rows($result);

        if ($numRows > 0) {
            // User exists, allow login
            //$_SESSION['org_id'] ;
            $_SESSION['org_id'] = $org_id;
            // Redirect to participant_home.html
            header("Location: organisation_home.php");
            exit();
        } else{
            header("Location: newlogin4.php");
        }
    } 
    // Close the database connection
    pg_close($databaseConnection);
}
?>
    
    <img src="https://i.pinimg.com/564x/f0/35/fa/f035fae858ddaee564352eb5936a5f2c.jpg" alt="Background Image" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">

    <div id="login-box">
        <h2 id="form-title">ORGANISATION-LOGIN</h2>
        <form action="" method="post">
            <input type="text" name="name" placeholder="name" required><br><br>
            <input type="number" name="org_id" placeholder="org_id" required><br><br>
            <input type="text" name="password" placeholder="password" required><br><br>
            <input type="submit" name="login" value="Login"  id="login-button">
        </form>
    </div>
</body>
</html>