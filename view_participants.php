<?php
session_start();

$dbhost = 'localhost';
$dbname = 'postgres';
$dbuser = 'postgres';
$dbpass = 'PMkiruthi';

$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
  die("Connection failed. Error: " . pg_last_error());
}

// Begin a transaction
pg_query($conn, "BEGIN");

$query = "DECLARE participant_cursor CURSOR FOR SELECT * FROM participants";
$result = pg_query($conn, $query);

if (!$result) {
  // Rollback transaction and handle error
  pg_query($conn, "ROLLBACK");
  die("Error: " . pg_last_error($conn));
}

$participants = [];

$query = "FETCH ALL FROM participant_cursor";
$result = pg_query($conn, $query);

if (!$result) {
  // Rollback transaction and handle error
  pg_query($conn, "ROLLBACK");
  die("Error: " . pg_last_error($conn));
}

while ($row = pg_fetch_assoc($result)) {
  $participants[] = $row;
}

// Commit transaction
pg_query($conn, "COMMIT");

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Participants Details</title>
  <style>
    table {
      font-family: Arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    table td, table th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    table th {
      text-align: left;
      background-color: #f2f2f2;
    }
    h1{
        text-align:center;
    }
    .back-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        </style>

</head>
<body>

<h1>Participants Details</h1><br>

<?php if (count($participants) > 0): ?>

  <table border="1">
    <thead>
      <tr>
        <th>P_ID</th>
        <th>P_Name</th>
        <th>Email</th>
        <th>College_name</th>
        <th>Contact</th>
        <th>Age</th>
        <th>Date_of_birth</th>
        <th>Address</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($participants as $participant): ?>
        <tr>
          <td><?= $participant['p_id'] ?></td>
          <td><?= $participant['p_name'] ?></td>
          <td><?= $participant['email'] ?></td>
          <td><?= $participant['institution_name'] ?></td>
          <td><?= $participant['contact'] ?></td>
          <td><?= $participant['age'] ?></td>
          <td><?= $participant['dob'] ?></td>
          <td><?= $participant['address'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>
  <p>No participants found.</p>
<?php endif; ?><br><br>

<a href="admin_dashboard.php"><button type="button" class="back-button"> Prev Page</button></a>
</body>
</html>
