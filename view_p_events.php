<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Participants Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    th {
      background-color: #f2f2f2;
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
      text-decoration: none;
    }
    .back-button:hover {
      background-color: #0056b3;
    }
    .events {
      display: none;
    }
  </style>
  <script>
    function toggleEvents(elementId) {
      var x = document.getElementById(elementId);
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
    function toggleWorkshops(elementId) {
      var x = document.getElementById(elementId);
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
    function toggleGuestLectures(elementId) {
      var x = document.getElementById(elementId);
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
    function toggleHackathons(elementId) {
      var x = document.getElementById(elementId);
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }
  </script>
</head>
<body>
  <h1>Participants Details</h1>
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

  $query = "SELECT p.p_id, p.p_name, p.email, p.institution_name, p.contact, p.age, p.dob, p.address,e.e_name
            FROM participants p
            JOIN team_members tm ON p.p_id = tm.p_id
            JOIN team t ON tm.t_id = t.t_id
            JOIN events e ON t.prog_id = e.e_id";
  $result = pg_query($conn, $query);

  if (!$result) {
    die("Error: " . pg_last_error($conn));
  }

  $participants = [];

  while ($row = pg_fetch_assoc($result)) {
    $participantId = $row['p_id'];
    if (!isset($participants[$participantId])) {
      $participants[$participantId] = [
        'p_id' => $row['p_id'],
        'p_name' => $row['p_name'],
        'email' => $row['email'],
        'institution_name' => $row['institution_name'],
        'contact' => $row['contact'],
        'age' => $row['age'],
        'dob' => $row['dob'],
        'address' => $row['address'],
        'events' => [],
        'workshops' => [],
        'guest_lectures' => [],
        'hackathons' => [],
      ];
    }
    $participants[$participantId]['events'][] = $row['e_name'];
  }
  $query = "SELECT p.p_id, p.p_name, p.email, p.institution_name, p.contact, p.age, p.dob, p.address, w.w_name
            FROM participants p
            JOIN team_members tm ON p.p_id = tm.p_id
            JOIN team t ON tm.t_id = t.t_id
            JOIN workshops w ON t.prog_id = w.w_id";
  $result = pg_query($conn, $query);

  if (!$result) {
    die("Error: " . pg_last_error($conn));
  }

  while ($row = pg_fetch_assoc($result)) {
    $participantId = $row['p_id'];
    $participants[$participantId]['workshops'][] = $row['w_name'];
  }
  $query = "SELECT p.p_id, p.p_name, p.email, p.institution_name, p.contact, p.age, p.dob, p.address, gl.gl_name
            FROM participants p
            JOIN team_members tm ON p.p_id = tm.p_id
            JOIN team t ON tm.t_id = t.t_id
            JOIN guest_lectures gl ON t.prog_id = gl.gl_id";
  $result = pg_query($conn, $query);

  if (!$result) {
    die("Error: " . pg_last_error($conn));
  }

  while ($row = pg_fetch_assoc($result)) {
    $participantId = $row['p_id'];
    $participants[$participantId]['guest_lectures'][] = $row['gl_name'];
  }
  $query = "SELECT p.p_id, p.p_name, p.email, p.institution_name, p.contact, p.age, p.dob, p.address, h.h_name
            FROM participants p
            JOIN team_members tm ON p.p_id = tm.p_id
            JOIN team t ON tm.t_id = t.t_id
            JOIN hackathons h ON t.prog_id = h.h_id";
  $result = pg_query($conn, $query);

  if (!$result) {
    die("Error: " . pg_last_error($conn));
  }

  while ($row = pg_fetch_assoc($result)) {
    $participantId = $row['p_id'];
    $participants[$participantId]['hackathons'][] = $row['h_name'];
  }

  pg_close($conn);
  ?>
  <?php if (count($participants) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>P_ID</th>
          <th>P_Name</th>
          <th>Email</th>
          <th>Institution Name</th>
          <th>Contact</th>
          <th>Age</th>
          <th>Date of Birth</th>
          <th>Address</th>
          <th>Events</th>
          <th>Workshops</th>
          <th>Guest Lectures</th>
          <th>Hackathons</th>
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
            <td>
              <button onclick="toggleEvents('events<?= $participant['p_id'] ?>')">Show Events</button>
              <ul class="events" id="events<?= $participant['p_id'] ?>">
                <?php foreach ($participant['events'] as $event): ?>
                  <li><?= $event ?></li>
                <?php endforeach; ?>
              </ul>
            </td>
            <td>
              <button onclick="toggleWorkshops('workshops<?= $participant['p_id'] ?>')">Show Workshops</button>
              <ul class="events" id="workshops<?= $participant['p_id'] ?>">
                <?php foreach ($participant['workshops'] as $workshop): ?>
                  <li><?= $workshop ?></li>
                <?php endforeach; ?>
              </ul>
            </td>
            <td>
              <button onclick="toggleGuestLectures('guestlectures<?= $participant['p_id'] ?>')">Show Guest Lectures</button>
              <ul class="events" id="guestlectures<?= $participant['p_id'] ?>">
                <?php foreach ($participant['guest_lectures'] as $guest_lecture): ?>
                  <li><?= $guest_lecture ?></li>
                <?php endforeach; ?>
              </ul>
            </td>
            <td>
              <button onclick="toggleHackathons('hackathons<?= $participant['p_id'] ?>')">Show Hackathons</button>
              <ul class="events" id="hackathons<?= $participant['p_id'] ?>">
                <?php foreach ($participant['hackathons'] as $hackathon): ?>
                  <li><?= $hackathon ?></li>
                <?php endforeach; ?>
              </ul>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No participants found.</p>
  <?php endif; ?>
  <br><br>
  <a href="admin_dashboard.php" class="back-button">Prev Page</a>
</body>
</html>
