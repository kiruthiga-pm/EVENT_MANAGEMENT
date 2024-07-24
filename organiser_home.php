<?php
// Start session
session_start();

// Example initialization of $userID
$o_id = isset($_SESSION['o_id']) ? $_SESSION['o_id'] : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event List</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Added Font Awesome for the cog icon -->
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
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
    /* Added for better alignment */
    display: flex;
    align-items: center;
  }

  .logo img {
    height: 40px; /* Adjust height as needed */
    margin-right: 10px; /* Added margin for spacing */
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

  .event-list {
    padding: 20px;
  }

  .filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-top: 20px; /* Moved the margin to top */
  }

  .filter-bar input[type="text"] {
    padding: 8px;
    width: 300px;
  }

  .filter-bar select {
    padding: 8px;
  }

  .filter-bar button {
    padding: 8px 16px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .filter-bar button:hover {
    background-color: #555;
  }

  .event {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
    margin-bottom: 20px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex; /* Added */
    justify-content: space-between; /* Added */
    align-items: center; /* Added */
  }

  .event-image {
    width: 150px; /* Adjusted width */
    height: 100px; /* Maintains aspect ratio */
    margin-right: 20px;
  }

  .event-details {
    display: flex;
    align-items: center;
  }

  .event-info {
    flex: 1;
  }

  .event-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .event-date {
    color: #666;
    margin-bottom: 10px; /* Adjust the value as needed */
  }

  .actions {
    margin-top: 10px;
    display: flex; /* Added */
    align-items: center; /* Added */
  }

  .view-more-btn, .register-btn {
    padding: 8px 16px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
    margin-left: 10px; /* Added margin between buttons */
  }

  .view-more-btn:hover, .register-btn:hover {
    background-color: #555;
  }

  /* Popup styling */
  .popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
    overflow: auto;
  }

  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Grey with opacity */
    backdrop-filter: blur(5px); /* Apply blur effect */
    z-index: 998; /* Ensure the overlay is below the popup */
  }

  .popup-content {
    background-color: black; /* Change to black */
    color: white; /* Change text color to white for better contrast */
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 5px;
    position: relative;
    z-index: 999; /* Ensure the content is above the overlay */
  }

  .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
    color: white; /* Change close button color to white */
  }

</style>
</head>
<body>
<header>
    <div class="logo">
        <p style="color:white">EVENT MANAGEMENT SYSTEM</p> <!-- Fixed typo in style attribute -->
    </div>
    <div class="user-section">
        <div class="user-info">
            <?php
            if(isset($_SESSION['o_id'])) {
                // User is logged in
                echo "<span>Welcome, $o_id</span>";
            } else {
                // User is not logged in
                echo "<span>Welcome, Guest</span>";
            }
            ?>
        </div>
        <div class="settings">
            <?php
            if(isset($_SESSION['o_id'])) {
                // User is logged in
                echo "<a href='loginpage.php'>Logout</a>"; // Assuming logout.php handles logout logic
            } else {
                // User is not logged in
                echo "<a href='loginpage.php'>Login</a>"; // Assuming login.php is your login page
            }
            ?>
        </div>
    </div>
</header>
<a href="organiser_volunteer.php">view your volunteers </a>
<div class="filter-bar">
    <div>
        <form method="post" action="">
            <input type="text" name="searchInput" id="searchInput" placeholder="Search events...">
            <select name="filterType" id="filterType">
                <option value="name">Name</option>
                <option value="type">Type</option>
            </select>
            <button type="submit">Apply</button>
        </form>
    </div>
    <div>
        <form method="post" action="">
            <select name="filter" id="filter">
                <option value="all">All</option>
                <option value="upcoming">Upcoming</option>
                <option value="past">Past</option>
            </select>
            <select name="sort" id="sort">
                <option value="date_asc">Date (Ascending)</option>
                <option value="date_desc">Date (Descending)</option>
            </select>
            <button type="submit">Apply</button>
        </form>
    </div>
</div>
        
    </div>
    </header>
    <br><br>
<div class="container">
        <div class="events" id="eventsContainer">
            <h2>Existing Events</h2>
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
            $sql = "SELECT * FROM events 
            WHERE e_id IN (
                SELECT prog_id 
                FROM program 
                WHERE table_name = 'events' 
                AND o_id='$o_id'
            )";
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerform'])) {
              // Assuming 'e_id' and 'p_id' are provided in the form data
              $e_id = $_POST['e_id'];
              $t_id = $_POST['t_id'];
              $prize= $_POST['prize'];
              $date= $_POST['date'];
              if (strtotime($date) > time()) {
                  echo "<script>alert('Error: Event has not occured.')</script>";
              } else {
                  $query = "SELECT * FROM winners WHERE t_id=$t_id AND e_id=$e_id";
                  $result = pg_query($conn, $query);
                  if (pg_num_rows($result) > 0) {
                      echo "<script>alert('Error: winners is already updated for this event.')</script>";
                  } else {
                    $query1 = "SELECT * FROM team WHERE t_id=$t_id AND prog_id=$e_id";
                    $result2 = pg_query($conn, $query1);
                    if($result2){
                      $sql1 = "INSERT INTO winners (e_id, t_id, prize) VALUES ('$e_id', '$t_id', '$prize')";
                      $result1 = pg_query($conn, $sql1);
                      if ($result1) {
                          echo "<script>alert('winners added successfully!')</script>";
                      } else {
                          echo "<script>alert('Error: Unable to add winners for the event.')</script>";
                      }
                    }
                  }
              }
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
              $searchInput = pg_escape_string($_POST['searchInput']);
              $filterType = $_POST['filterType'];
              if($filterType=='name'){
                $filterType = "e_name";
              }
              $sql .= " AND $filterType LIKE '%$searchInput%'";
          }
      
          // Filter events based on criteria if provided in the POST request
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter']) ) {
              $filter = $_POST['filter']; // Assuming 'filter' is the name of the filter criterion
      
              // Implement filtering based on the chosen criterion
              switch ($filter) {
                  case 'upcoming': // Example: Show only upcoming events
                      $sql .= " AND date >= CURRENT_DATE";
                      break;
                  case 'past': // Example: Show only past events
                      $sql .= " AND date < CURRENT_DATE";
                      break;
                  // Add more cases for additional filtering criteria
                  default:
                      // Default case: no additional filtering
                      break;
              }
          }
      
          // Sorting based on the chosen criterion
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sort'])) {
              $sort = $_POST['sort']; // Assuming 'sort' is the name of the sort criterion
      
              // Implement sorting based on the chosen criterion
              switch ($sort) {
                  case 'date_asc': // Example: Sort by date in ascending order
                      $sql .= " ORDER BY date ASC";
                      break;
                  case 'date_desc': // Example: Sort by date in descending order
                      $sql .= " ORDER BY date DESC";
                      break;
                  // Add more cases for additional sorting criteria
                  default:
                      // Default case: no additional sorting
                      break;
              }
          }
          // Execute the SQL query
          $result = pg_query($conn, $sql);
          if (!$result) {
            echo "Failed to retrieve events from the database.";
            exit;
          }
            // Display retrieved event details
            while ($row = pg_fetch_assoc($result)) {
                echo "<div class='event'>";
                echo "<img src='" . $row['image'] . "' alt='Event Image' class='event-image'>";
                echo "<h3>" . $row['e_name'] . "</h3>";
                echo "<p>Description: " . $row['description'] . "</p>";
                echo "<p>Date: " . $row['date'] . "</p>";
                echo "<button onclick=\"openPopupe('{$row['e_name']}', '{$row['date']}', '{$row['type']}', '{$row['place']}', '{$row['rounds']}', '{$row['capacity']}', '{$row['image']}')\">View More</button>"; // Changed to button for consistency
                echo "<button onclick=\"openPopup1('{$row['e_id']}','{$row['date']}')\">ADD WINNER</button>"; 
                echo "</div>";
                echo "</div>";
            }

            // Close database connection
            pg_close($conn);
            ?>
            <!-- Popup box for event details -->
<div class="popup" id="popupe">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopupe()">&times;</span>
        <img id="epopup-image" src="" alt="Event Image" class="event-image">
        <h3 id="epopup-event-name"></h3>
        <p><strong>Date:</strong> <span id="epopup-date"></span></p>
        <p><strong>Type:</strong> <span id="epopup-type"></span></p>
        <p><strong>Place:</strong> <span id="epopup-place"></span></p>
        <p><strong>Rounds:</strong> <span id="epopup-rounds"></span></p>
        <p><strong>Capacity:</strong> <span id="epopup-capacity"></span></p>
    </div>
</div>
<!--popup box for winner details-->
<div class="popup" id="popup1">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup1()">&times;</span>
        <h3 id="popup-winner-name">Enter Winner Details</h3>
        <form method='post' action=''>
            <input type='hidden' id='winner-event-id' name='e_id'>
            <input type='hidden' id='date' name='date'>
            <input type='text' name='t_id' placeholder='Winner Team ID'>
            <input type='text' name='prize' placeholder='Prize'>
            <button type='submit' name='registerform'>Register Winner</button>
        </form>
</div>
</div>
<script>
    function openPopupe(name, date, type, place, rounds, capacity, image) {
        var popup = document.getElementById('popupe');
        var popupEventName = document.getElementById('epopup-event-name');
        var popupDate = document.getElementById('epopup-date');
        var popupType = document.getElementById('epopup-type');
        var popupPlace = document.getElementById('epopup-place');
        var popupRounds = document.getElementById('epopup-rounds');
        var popupCapacity = document.getElementById('epopup-capacity');
        var popupImage = document.getElementById('epopup-image');

        popupEventName.textContent = name;
        popupDate.textContent = date;
        popupType.textContent = type;
        popupPlace.textContent = place;
        popupRounds.textContent = rounds;
        popupCapacity.textContent = capacity;
        popupImage.src = image;

        popup.style.display = 'block';
    }

    function closePopupe() {
        var popup = document.getElementById('popupe');
        popup.style.display = 'none';
    }

    function openPopup1(e_id,date) {
        var popup = document.getElementById('popup1');
        var winnerEventId = document.getElementById('winner-event-id');
        winnerEventId.value = e_id;
        var dateid = document.getElementById('date');
        dateid.value = date;
        popup.style.display = 'block';
    }

    function closePopup1() {
        var popup = document.getElementById('popup1');
        popup.style.display = 'none';
    }
    </script>
<div class="events" id="eventsContainer">
            <h2>Existing workshops</h2>
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
            $sql = "SELECT * FROM workshops 
            WHERE w_id IN (
                SELECT prog_id 
                FROM program 
                WHERE table_name = 'workshops' 
                AND o_id='$o_id'
            )";
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
              $searchInput = pg_escape_string($_POST['searchInput']);
              $filterType = $_POST['filterType'];
              if($filterType=='name'){
                $filterType = "w_name";
              }
              $sql .= " AND $filterType LIKE '%$searchInput%'";
          }
      
          // Filter events based on criteria if provided in the POST request
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter']) ) {
              $filter = $_POST['filter']; // Assuming 'filter' is the name of the filter criterion
      
              // Implement filtering based on the chosen criterion
              switch ($filter) {
                  case 'upcoming': // Example: Show only upcoming events
                      $sql .= " AND date >= CURRENT_DATE";
                      break;
                  case 'past': // Example: Show only past events
                      $sql .= " AND date < CURRENT_DATE";
                      break;
                  // Add more cases for additional filtering criteria
                  default:
                      // Default case: no additional filtering
                      break;
              }
          }
      
          // Sorting based on the chosen criterion
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sort'])) {
              $sort = $_POST['sort']; // Assuming 'sort' is the name of the sort criterion
      
              // Implement sorting based on the chosen criterion
              switch ($sort) {
                  case 'date_asc': // Example: Sort by date in ascending order
                      $sql .= " ORDER BY date ASC";
                      break;
                  case 'date_desc': // Example: Sort by date in descending order
                      $sql .= " ORDER BY date DESC";
                      break;
                  // Add more cases for additional sorting criteria
                  default:
                      // Default case: no additional sorting
                      break;
              }
          }
          // Execute the SQL query
          $result = pg_query($conn, $sql);
          if (!$result) {
            echo "Failed to retrieve events from the database.";
            exit;
          }
            // Display retrieved event details
            while ($row = pg_fetch_assoc($result)) {
                echo "<div class='event'>";
                echo "<img src='" . $row['image'] . "' alt='workshop image' class='event-image'>";
                echo "<h3>" . $row['w_name'] . "</h3>";
                echo "<p>Place: " . $row['place'] . "</p>";
                echo "<p>Date: " . $row['date'] . "</p>";
                echo "<button onclick=\"openPopupw('{$row['w_name']}', '{$row['date']}', '{$row['type']}', '{$row['place']}', '{$row['conducted_by']}','{$row['capacity']}', '{$row['start_time']}', '{$row['end_time']}','{$row['image']}')\">View More</button>"; // Changed to button for consistency
                echo "</div>";
            }

            // Close database connection
            pg_close($conn);
            ?>
            <div class="popup" id="popupw">
            <div class="popup-content">
        <span class="close-btn" onclick="closePopupw()">&times;</span>
        <img id="wpopup-image" src="" alt="workshop Image" class='event-image'>
        <h3 id="wpopup-workshops-name"></h3>
        <p><strong>Date:</strong> <span id="wpopup-date"></span></p>
        <p><strong>Type:</strong> <span id="wpopup-type"></span></p>
        <p><strong>Place:</strong> <span id="wpopup-place"></span></p>
        <p><strong>conducted by:</strong> <span id="wpopup-conductedby"></span></p>
        <p><strong>Capacity:</strong> <span id="wpopup-capacity"></span></p>
        <p><strong>start time:</strong> <span id="wpopup-starttime"></span></p>
        <p><strong>end time:</strong> <span id="wpopup-endtime"></span></p>
    </div>
</div>

<script>
    function openPopupw(name, date, type, place,conductedby, capacity,starttime,endtime, image) {
        var popup = document.getElementById('popupw');
        var popupEventName = document.getElementById('wpopup-workshops-name');
        var popupDate = document.getElementById('wpopup-date');
        var popupType = document.getElementById('wpopup-type');
        var popupPlace = document.getElementById('wpopup-place');
        var popupconductedby = document.getElementById('wpopup-conductedby');
        var popupCapacity = document.getElementById('wpopup-capacity');
        var popupImage = document.getElementById('wpopup-image');
        var popupstarttime = document.getElementById('wpopup-starttime');
        var popupendtime = document.getElementById('wpopup-endtime');

        popupEventName.textContent = name;
        popupDate.textContent = date;
        popupType.textContent = type;
        popupPlace.textContent = place;
        popupCapacity.textContent = capacity;
        popupImage.src = image;
        popupconductedby.textContent = conductedby;
        popupstarttime.textContent = starttime;
        popupendtime.textContent = endtime;

        popup.style.display = 'block';
    }

    function closePopupw() {
        var popup = document.getElementById('popupw');
        popup.style.display = 'none';
    }
    </script>
        </div>
        </div>
        <div class="events" id="eventsContainer">
        <h2>Existing hackathons</h2>
<?php
$dbhost = 'localhost';
$dbname = 'postgres';
$dbuser = 'postgres';
$dbpass = 'PMkiruthi';

$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
    echo "Failed to connect to PostgreSQL database.";
    exit;
}

$o_id = $_SESSION['o_id']; // Assuming you have the organiser ID stored in a session variable
$sql = "SELECT * FROM hackathons 
        WHERE h_id IN (
            SELECT prog_id 
            FROM program 
            WHERE table_name = 'hackathons' 
            AND o_id='$o_id'
        )";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerformh'])) {
    $h_id = $_POST['h_id'];
    $t_id = $_POST['t_id'];
    $prize = $_POST['prize'];
    $date = $_POST['date'];

    if (strtotime($date) > time()) {
        echo "<script>alert('Error: Event has not occurred.')</script>";
    } else {
        $query = "SELECT * FROM winners WHERE t_id=$1 AND h_id=$2";
        $result = pg_query_params($conn, $query, array($t_id, $h_id));
        if ($result && pg_num_rows($result) > 0) {
            echo "<script>alert('Error: winners is already updated for this event.')</script>";
        } else {
            $query1 = "SELECT * FROM team WHERE t_id=$1 AND prog_id=$2";
            $result2 = pg_query_params($conn, $query1, array($t_id, $h_id));
            if ($result2 && pg_num_rows($result2) > 0) {
                $sql1 = "INSERT INTO winners (h_id, t_id, prize) VALUES ($1, $2, $3)";
                $result1 = pg_query_params($conn, $sql1, array($h_id, $t_id, $prize));
                if ($result1) {
                    echo "<script>alert('Winners added successfully!')</script>";
                } else {
                    echo "<script>alert('Error: Unable to add winners for the event.')</script>";
                }
            } else {
                echo "<script>alert('Error: Team not found or not part of the hackathon.')</script>";
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
    $searchInput = pg_escape_string($_POST['searchInput']);
    $filterType = $_POST['filterType'] == 'name' ? 'h_name' : $_POST['filterType'];
    $sql .= " AND $filterType LIKE '%$searchInput%'";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter == 'upcoming') {
        $sql .= " AND date >= CURRENT_DATE";
    } elseif ($filter == 'past') {
        $sql .= " AND date < CURRENT_DATE";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sort'])) {
    $sort = $_POST['sort'];
    if ($sort == 'date_asc') {
        $sql .= " ORDER BY date ASC";
    } elseif ($sort == 'date_desc') {
        $sql .= " ORDER BY date DESC";
    }
}

$result = pg_query($conn, $sql);
if (!$result) {
    echo "Failed to retrieve hackathons from the database.";
    exit;
}

echo "<div class='events' id='eventsContainer'>";
while ($row = pg_fetch_assoc($result)) {
    echo "<div class='event'>";
    echo "<img src='" . $row['image'] . "' alt='Event Image' class='event-image'>";
    echo "<h3>" . $row['h_name'] . "</h3>";
    echo "<p>Place: " . $row['place'] . "</p>";
    echo "<p>Date: " . $row['date'] . "</p>";
    echo "<div class='actions'>";
    echo "<button onclick=\"openPopuph('{$row['h_name']}', '{$row['date']}', '{$row['type']}', '{$row['place']}', '{$row['capacity']}', '{$row['start_time']}', '{$row['end_time']}', '{$row['image']}')\">View More</button>";
    echo "<button onclick=\"openPopup2('{$row['h_id']}', '{$row['date']}')\">ADD WINNER</button>";
    echo "</div>";
    echo "</div>";
}
echo "</div>";
?>

<div class="popup" id="popuph">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopuph()">&times;</span>
        <img id="hpopup-image" src="" alt="hackathon Image" class='event-image'>
        <h3 id="hpopup-hackathon-name"></h3>
        <p><strong>Date:</strong> <span id="hpopup-date"></span></p>
        <p><strong>Type:</strong> <span id="hpopup-type"></span></p>
        <p><strong>Place:</strong> <span id="hpopup-place"></span></p>
        <p><strong>Capacity:</strong> <span id="hpopup-capacity"></span></p>
        <p><strong>Start Time:</strong> <span id="hpopup-starttime"></span></p>
        <p><strong>End Time:</strong> <span id="hpopup-endtime"></span></p>
    </div>
</div>

<div class="popup" id="popup2">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup2()">&times;</span>
        <h3 id="popup-winner-name">Enter Winner Details</h3>
        <form method='post' action=''>
            <input type='hidden' id='hwinner-event-id' name='h_id'>
            <input type='hidden' id='date' name='date'>
            <input type='text' name='t_id' placeholder='Winner Team ID'>
            <input type='text' name='prize' placeholder='Prize'>
            <button type='submit' name='registerformh'>Register Winner</button>
        </form>
    </div>
</div>

<script>
function openPopuph(name, date, type, place, capacity, starttime, endtime, image) {
    var popup = document.getElementById('popuph');
    var popupEventName = document.getElementById('hpopup-hackathon-name');
    var popupDate = document.getElementById('hpopup-date');
    var popupType = document.getElementById('hpopup-type');
    var popupPlace = document.getElementById('hpopup-place');
    var popupCapacity = document.getElementById('hpopup-capacity');
    var popupImage = document.getElementById('hpopup-image');
    var popupstarttime = document.getElementById('hpopup-starttime');
    var popupendtime = document.getElementById('hpopup-endtime');

    popupEventName.textContent = name;
    popupDate.textContent = date;
    popupType.textContent = type;
    popupPlace.textContent = place;
    popupCapacity.textContent = capacity;
    popupImage.src = image;
    popupstarttime.textContent = starttime;
    popupendtime.textContent = endtime;

    popup.style.display = 'block';
}

function closePopuph() {
    var popup = document.getElementById('popuph');
    popup.style.display = 'none';
}

function openPopup2(h_id, date) {
    var popup = document.getElementById('popup2');
    var hwinnerEventId = document.getElementById('hwinner-event-id');
    hwinnerEventId.value = h_id;
    var dateid = document.getElementById('date');
    dateid.value = date;
    popup.style.display = 'block';
}

function closePopup2() {
    var popup = document.getElementById('popup2');
    popup.style.display = 'none';
}
</script>

<div class="events" id="eventsContainer">
            <h2>Existing guest lectures</h2>
            <?php
$dbhost = 'localhost';
$dbname = 'postgres';
$dbuser = 'postgres';
$dbpass = 'PMkiruthi';

$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
    echo "Failed to connect to PostgreSQL database.";
    exit;
}

$sql = "";

$sql = "SELECT * FROM guest_lectures
        WHERE gl_id IN (
            SELECT prog_id 
            FROM program 
            WHERE table_name = 'guest_lectures' 
            AND o_id='$o_id'
        )";
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
            $searchInput = pg_escape_string($_POST['searchInput']);
            $filterType = $_POST['filterType'];
            if($filterType=='name'){
              $filterType = "gl_name";
            }
            $sql .= " AND $filterType LIKE '%$searchInput%'";
        }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter'])) {
    $filter = $_POST['filter'];

    switch ($filter) {
        case 'upcoming':
            $sql .= " AND date >= CURRENT_DATE";
            break;
        case 'past':
            $sql .= " AND date < CURRENT_DATE";
            break;
        default:
            break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sort'])) {
    $sort = $_POST['sort'];

    switch ($sort) {
        case 'date_asc':
            $sql .= " ORDER BY date ASC";
            break;
        case 'date_desc':
            $sql .= " ORDER BY date DESC";
            break;
        default:
            break;
    }
}

$result = pg_query($conn, $sql);
if (!$result) {
    echo "Failed to retrieve hackathons from the database.";
    exit;
}

echo "<div class='events' id='eventsContainer'>";

while ($row = pg_fetch_assoc($result)) {
    echo "<div class='event'>";
    echo "<img src='" . $row['image'] . "' alt='guest_lecture image' class='event-image'>";
    echo "<h3>" . $row['gl_name'] . "</h3>";
    echo "<p>Place: " . $row['place'] . "</p>";
    echo "<p>Date: " . $row['date'] . "</p>";
    echo "<button onclick=\"openPopupg('{$row['gl_name']}', '{$row['date']}', '{$row['type']}', '{$row['place']}', '{$row['speaker']}','{$row['capacity']}', '{$row['start_time']}', '{$row['end_time']}','{$row['image']}')\">View More</button>"; // Changed to button for consistency
    echo "</div>";
}
echo "</div>";
?>
<div class="popup" id="popupg">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopupg()">&times;</span>
        <img id="gpopup-image" src="" alt="guestlecture Image" class='event-image'>
        <h3 id="gpopup-guestlecture-name"></h3>
        <p><strong>Date:</strong> <span id="gpopup-date"></span></p>
        <p><strong>Type:</strong> <span id="gpopup-type"></span></p>
        <p><strong>Place:</strong> <span id="gpopup-place"></span></p>
        <p><strong>Speaker:</strong> <span id="gpopup-speaker"></span></p>
        <p><strong>Capacity:</strong> <span id="gpopup-capacity"></span></p>
        <p><strong>start time:</strong> <span id="gpopup-starttime"></span></p>
        <p><strong>end time:</strong> <span id="gpopup-endtime"></span></p>
    </div>
</div>
<script>
    function openPopupg(name, date, type, place,speaker, capacity,starttime,endtime, image) {
        var popup = document.getElementById('popupg');
        var popupEventName = document.getElementById('gpopup-guestlecture-name');
        var popupDate = document.getElementById('gpopup-date');
        var popupType = document.getElementById('gpopup-type');
        var popupPlace = document.getElementById('gpopup-place');
        var popupspeaker = document.getElementById('gpopup-speaker');
        var popupCapacity = document.getElementById('gpopup-capacity');
        var popupImage = document.getElementById('gpopup-image');
        var popupstarttime = document.getElementById('gpopup-starttime');
        var popupendtime = document.getElementById('gpopup-endtime');

        popupEventName.textContent = name;
        popupDate.textContent = date;
        popupType.textContent = type;
        popupPlace.textContent = place;
        popupCapacity.textContent = capacity;
        popupImage.src = image;
        popupspeaker.textContent = speaker;
        popupstarttime.textContent = starttime;
        popupendtime.textContent = endtime;

        popup.style.display = 'block';
    }

    function closePopupg() {
        var popup = document.getElementById('popupg');
        popup.style.display = 'none';
    }
</script>

</div>
</div>
</div>
 
</body>
</html>
