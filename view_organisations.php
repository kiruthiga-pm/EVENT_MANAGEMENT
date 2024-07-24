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

// Fetch organisations data
$query = "SELECT o.org_id,o.org_name,ol.address,ol.contact FROM organisation o,org_locations ol where o.org_id=ol.org_id";
$result = pg_query($conn, $query);

if (!$result) {
  die("Error: " . pg_last_error($conn));
}

// Store organisations in an array
$organisations = [];

while ($row = pg_fetch_assoc($result)) {
  $organisations[] = $row;
}

// Close database connection
pg_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organisations Details</title>
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

<h1>Organisations Details</h1><br>

<?php if (count($organisations) > 0): ?>

  <table border="1">
    <thead>
      <tr>
        <th>Organisation ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Contact</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($organisations as $organisation): ?>
        <tr>
          <td><?= $organisation['org_id'] ?></td>
          <td><?= $organisation['org_name'] ?></td>
          <td><?= $organisation['address'] ?></td>
          <td><?= $organisation['contact'] ?></td>
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>
  <p>No organisations found.</p>
<?php endif; ?><br><br>

<a href="admin_dashboard.php"><button type="button" class="back-button">Prev Page</button></a>

</body>
</html>