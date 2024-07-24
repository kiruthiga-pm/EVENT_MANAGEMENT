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

$query = "DECLARE organiser_cursor CURSOR FOR SELECT * FROM organiser";
$result = pg_query($conn, $query);

if (!$result) {
  // Rollback transaction and handle error
  pg_query($conn, "ROLLBACK");
  die("Error: " . pg_last_error($conn));
}

$organisers = [];

$query = "FETCH ALL FROM organiser_cursor";
$result = pg_query($conn, $query);

if (!$result) {
  // Rollback transaction and handle error
  pg_query($conn, "ROLLBACK");
  die("Error: " . pg_last_error($conn));
}

while ($row = pg_fetch_assoc($result)) {
  $organisers[] = $row;
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
  <title>Organisers Details</title>
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

<h1>Organisers Details</h1><br>

<?php if (count($organisers) > 0): ?>

  <table border="1">
    <thead>
      <tr>
        <th>Organiser ID</th>
        <th>Name</th>
        <th>Organisation ID</th>
        <th>Email</th>
        <th>Address</th>
        <th>Contact</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($organisers as $organiser): ?>
        <tr>
          <td><?= $organiser['o_id'] ?></td>
          <td><?= $organiser['o_name'] ?></td>
          <td><?= $organiser['org_id'] ?></td>
          <td><?= $organiser['email'] ?></td>
          <td><?= $organiser['address'] ?></td>
          <td><?= $organiser['contact'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>
  <p>No organisers found.</p>
<?php endif; ?><br><br>

<a href="admin_dashboard.php"><button type="button" class="back-button">Prev Page</button></a>

</body>
</html>