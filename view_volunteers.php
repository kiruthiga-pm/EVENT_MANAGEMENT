<?php
session_start();

// Database connection parameters
$dbhost = 'localhost';
$dbname = 'postgres';
$dbuser = 'postgres';
$dbpass = 'PMkiruthi';

// Connect to PostgreSQL database
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
  die("Connection failed. Error: " . pg_last_error());
}

// Fetch volunteers data
$query = "SELECT * FROM volunteers";
$result = pg_query($conn, $query);

if (!$result) {
  die("Error: " . pg_last_error($conn));
}

// Store volunteers in an array
$volunteers = [];

while ($row = pg_fetch_assoc($result)) {
  $volunteers[] = $row;
}

// Close database connection
pg_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Volunteers Details</title>
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

    h1 {
      text-align: center;
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

<h1>Volunteers Details</h1><br>

<?php if (count($volunteers) > 0): ?>

  <table border="1">
    <thead>
      <tr>
        <th>Volunteer ID</th>
        <th>Name</th>
        <th>Date of Birth</th>
        <th>Email</th>
        <th>Address</th>
        <th>Contact</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($volunteers as $volunteer): ?>
        <tr>
          <td><?= $volunteer['v_id'] ?></td>
          <td><?= $volunteer['v_name'] ?></td>
          <td><?= $volunteer['dob'] ?></td>
          <td><?= $volunteer['email'] ?></td>
          <td><?= $volunteer['address'] ?></td>
          <td><?= $volunteer['contact'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>
  <p>No volunteers found.</p>
<?php endif; ?><br><br>

<a href="admin_dashboard.php"><button type="button" class="back-button">Prev Page</button></a>

</body>
</html>