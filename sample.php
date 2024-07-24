<?php
// PostgreSQL connection details
$host = 'localhost';
$dbname = 'postgres';
$username = 'postgres';
$password = 'PMkiruthi';

// Connect to PostgreSQL database
$conn = pg_connect("host=$host dbname=$dbname user=$username password=$password");
if (!$conn) {
    die("Error: Could not connect to the database.");
}
$program_type = isset($_POST['tab_name']) ? $_POST['tab_name']:''; // Retrieve tab_name from POST data

echo "'$program_type'";
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Create_Team']) && isset($_POST['p_id'])&& isset($_POST['e_id']) && isset($_POST['tab_name'])) {
    $p_id1 = $_POST['p_id'];
    $program_id = $_POST['e_id'];
    $program_type = $_POST['tab_name'];
    // Retrieve other form data
    
    $p_id2 = isset($_POST['p_id2']) && !empty($_POST['p_id2']) ? $_POST['p_id2'] : 'NULL';
    $p_id3 = isset($_POST['p_id3']) && !empty($_POST['p_id3']) ? $_POST['p_id3'] : 'NULL';
    

    // Add debug statements to output the values of form parameters
echo "Program ID: $program_id, Participant ID 1: $p_id1, Participant ID 2: $p_id2, Participant ID 3: $p_id3";

// Execute the SQL query
$check_query = "SELECT COUNT(*) AS count
FROM team t
JOIN team_members tm ON t.t_id = tm.t_id
WHERE t.prog_id = $program_id
  AND t.table_name = '$program_type'
  AND (tm.p_id = $p_id1 or tm.p_id = $p_id2 or tm.p_id = $p_id3)";

$result_check = pg_query($conn, $check_query);
$row_check = pg_fetch_assoc($result_check);

if ($row_check['count'] == 0) {
$query_create = " SELECT create_team_and_members($program_id, '$program_type', $p_id1, $p_id2, $p_id3)";
$result_create = pg_query($conn, $query_create);


    // Check if the query was successful
    if ($result_create) {
        // Fetch the result
        $row = pg_fetch_assoc($result_create);
        $team_id = $row['create_team_and_members'];
 
        // Check if team creation was successful
        if ($team_id !== null) {
            echo "<script>alert('Team created with ID: $team_id. Event registration successful!')</script>";
            session_start();
            $_SESSION['t_id'] = $team_id; 
            echo "<script>window.location.href='index.php'</script>";
        } else {
            echo "<script>alert('Error: Unable to register for the program.')</script>";
        }
    } else {
        die("Error: Query failed.");
    }
}
else{
    echo "<script>alert('Error: Unable to register for the program.Team already exists')</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Team</title>
    <style>
        body {
            background-color: #f8f9fa;
            color: #000;
            font-family: Arial, sans-serif;
        }
        form {
            margin: 20px;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 10px;
            background-color: #fff;
        }
        input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #000;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #000;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Create Team</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="p_id2">Enter team member Participant ID 1(Optional):</label><br>
        <input type="number" id="p_id2" name="p_id2"><br>
        <label for="p_id3">Enter team member Participant ID 2 (Optional):</label><br>
        <input type="number" id="p_id3" name="p_id3"><br>
        <input type="hidden" name="e_id" value="<?php echo isset($_POST['e_id']) ? $_POST['e_id'] : ''; ?>"> <!-- Pass the event ID -->
        <input type="hidden" name="p_id" value="<?php echo isset($_POST['p_id']) ? $_POST['p_id'] : ''; ?>">
        <input type="hidden" name="tab_name" value="<?php echo isset($_POST['tab_name']) ? $_POST['tab_name'] : ''; ?>">
        <input type="submit" name="Create_Team" value="Create Team">
        
    </form>
</body>
</html>
