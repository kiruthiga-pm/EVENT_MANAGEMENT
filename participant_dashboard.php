<?php
// Start session
session_start();

// Example initialization of $userID
$userID = $_SESSION['user_id'];

// Database connection parameters
$dbhost = 'localhost';
$dbname = 'postgres';
$dbuser = 'postgres';
$dbpass = 'PMkiruthi';

// Connect to the database
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
    die("Connection failed. Error: " . pg_last_error());
}

// Fetch participant details
$query = "SELECT p.p_id, p.p_name, p.email, p.institution_name, p.contact, p.age, p.dob, p.address
          FROM participants p
          WHERE p.p_id = $userID";
$result = pg_query($conn, $query);
$participant = pg_fetch_assoc($result);

// Fetch registered programs with payment status
$query = "SELECT pr.prog_id AS program_id, pr.table_name AS program_name, t.t_id AS team_id, t.no_of_participants AS team_details, py.payment_status,
          CASE
              WHEN pr.table_name = 'events' THEN (SELECT e.e_name FROM events e WHERE e.e_id = pr.prog_id)
              WHEN pr.table_name = 'workshops' THEN (SELECT w.w_name FROM workshops w WHERE w.w_id = pr.prog_id)
              WHEN pr.table_name = 'guest_lectures' THEN (SELECT gl.gl_name FROM guest_lectures gl WHERE gl.gl_id = pr.prog_id)
              WHEN pr.table_name = 'hackathons' THEN (SELECT h.h_name FROM hackathons h WHERE h.h_id = pr.prog_id)
          END AS specific_program_name
          FROM participants p
          JOIN team_members tm ON p.p_id = tm.p_id
          JOIN team t ON tm.t_id = t.t_id
          JOIN program pr ON t.prog_id = pr.prog_id
          JOIN payment py ON t.t_id = py.t_id
          WHERE p.p_id = $userID";
$result = pg_query($conn, $query);

// Check if query was successful
if ($result) {
    $registered_programs = pg_fetch_all($result);
} else {
    // Handle query error
    echo "Error fetching registered programs: " . pg_last_error($conn);
    $registered_programs = [];
}

// Close database connection
pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Participant Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    h1, h2 {
      text-align: center;
      color: #333;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .activities {
      margin-top: 20px;
    }
    .paid {
      color: green;
      font-weight: bold;
    }
    .not-paid {
      color: red;
      font-weight: bold;
    }
    .pay-button {
      background-color: #ff4d4d;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-size: 14px;
      margin-top: 10px;
      display: inline-block;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Participant Dashboard</h1>
    <h2>Participant Details</h2>
    <table>
      <tr>
        <th>Participant ID</th>
        <td><?= $participant['p_id'] ?></td>
      </tr>
      <tr>
        <th>Name</th>
        <td><?= $participant['p_name'] ?></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?= $participant['email'] ?></td>
      </tr>
      <tr>
        <th>Institution</th>
        <td><?= $participant['institution_name'] ?></td>
      </tr>
      <tr>
        <th>Contact</th>
        <td><?= $participant['contact'] ?></td>
      </tr>
      <tr>
        <th>Age</th>
        <td><?= $participant['age'] ?></td>
      </tr>
      <tr>
        <th>Date of Birth</th>
        <td><?= $participant['dob'] ?></td>
      </tr>
      <tr>
        <th>Address</th>
        <td><?= $participant['address'] ?></td>
      </tr>
    </table>

    <div class="activities">
      <h2>Registered Programs</h2>
      <table>
        <thead>
          <tr>
            <th>Program ID</th>
            <th>Program Type</th>
            <th>Program Name</th>
            <th>Team ID</th>
            <th>Team Details</th>
            <th>Payment Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($registered_programs)): ?>
            <?php foreach ($registered_programs as $program): ?>
              <tr>
                <td><?= $program['program_id'] ?></td>
                <td><?= $program['program_name'] ?></td>
                <td><?= $program['specific_program_name'] ?></td>
                <td><?= $program['team_id'] ?></td>
                <td><?= $program['team_details'] ?> Participants</td>
                <?php
// Check if payment status is not paid and set the session variable t_id
if (strtolower($program['payment_status']) != 'paid') {
    $_SESSION['t_id'] = $program['team_id'];
}
?>

<td class="<?= strtolower($program['payment_status']) == 'paid' ? 'paid' : 'not-paid' ?>">
    <?= $program['payment_status'] ?>
    <?php if (strtolower($program['payment_status']) != 'paid'): ?>
        <a href="index.php" class="pay-button">Pay Now</a>
    <?php endif; ?>
</td>


<script>
    function setTeamId(teamId) {
        // Set the teamId in the session using JavaScript
        sessionStorage.setItem('t_id', teamId);
    }
</script>


              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No registered programs found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
