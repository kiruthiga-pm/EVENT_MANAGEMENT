<?php
// Start session
session_start();

// Example initialization of $userID
$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
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
    width: 120px; /* Adjusted width */
    height: auto; /* Maintains aspect ratio */
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
  .arrow-icon {
    color: white;
    cursor: pointer;
    margin-right: 20px; /* Adjusted margin */
  }

  .welcome {
    margin-right: 20px; /* Adjusted margin */
  }

  .welcome,
  .login-link {
    color: white;
    text-decoration: none;
  }


</style>
</head>
<body>
<header>
    <div class="logo">
    <i class="fas fa-arrow-left" onclick="history.back();" style="color: white; cursor: pointer; margin-left: 5px;margin-right:10px"></i>
        <p style="color:white">EVENT MANAGEMENT SYSTEM</p> <!-- Fixed typo in style attribute -->
    </div>
    <div class="user-section">
        <div class="user-info">
            <?php
            if(isset($_SESSION['user_id'])) {
                // User is logged in
                echo "<span>Welcome, $userID</span>";
            } else {
                // User is not logged in
                echo "<span>Welcome, Guest</span>";
            }
            ?>
        </div>
        <div class="settings">
            <?php
            if(isset($_SESSION['user_id'])) {
                // User is logged in
                echo "<a href='loginpage.html'>Logout</a>"; // Assuming logout.php handles logout logic
            } else {
                // User is not logged in
                echo "<a href='loginpage.html'>Login</a>"; // Assuming login.php is your login page
            }
            ?>
        </div>
    </div>
</header>
<div class="filter-bar">
    <div>
        <input type="text" id="searchInput" placeholder="Search events...">
        <select id="filterType">
            <option value="e_name">Name</option>
            <option value="type">Type</option>
        </select>
        <button onclick="applyFilters()">Apply</button>
    </div>
    <div>
        <select name="filter" id="filter">
            <option value="all">All</option>
            <option value="upcoming">Upcoming</option>
            <option value="past">Past</option>
        </select>
        <select name="sort" id="sort">
            <option value="date_asc">Date (Ascending)</option>
            <option value="date_desc">Date (Descending)</option>
        </select>
        <button onclick="applyFilters()">Apply</button>
    </div>
</div>

<div class="event-list">
<?php
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
    echo "<div>Error: Unable to connect to the database.</div>";
}  else {
    $sql = "SELECT e.*, o.o_name, org.org_name, array_agg(v.v_name) as volunteers
        FROM events e
        JOIN program p ON e.e_id = p.prog_id
        JOIN organiser o ON p.o_id = o.o_id
        JOIN organisation org ON o.org_id = org.org_id
        LEFT JOIN volunteers v ON v.o_id = o.o_id
        GROUP BY e.e_id, o.o_id, org.org_id";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
            $searchInput = pg_escape_string($_POST['searchInput']);
            $filterType = $_POST['filterType'];
            $sql .= " HAVING $filterType LIKE '%$searchInput%'";
        }

        if (isset($_POST['filter'])) {
            $filter = $_POST['filter'];
            if ($filter == 'upcoming') {
                $sql .= " HAVING date >= CURRENT_DATE";
            } elseif ($filter == 'past') {
                $sql .= " HAVING date < CURRENT_DATE";
            }
        }

        if (isset($_POST['sort'])) {
            $sort = $_POST['sort'];
            if ($sort == 'date_asc') {
                $sql .= " ORDER BY date ASC";
            } elseif ($sort == 'date_desc') {
                $sql .= " ORDER BY date DESC";
            }
        }
    }

    $result = pg_query($dbconn, $sql);

    if (!$result) {
        echo "<div>Error: Unable to retrieve events from the database.</div>";
    } else {
        while ($row = pg_fetch_assoc($result)) {
            $volunteers = isset($row['volunteers']) ? array_filter(explode(',', trim($row['volunteers'], '{}'))) : [];

            echo "<div class='event'>";
            echo "<div class='event-details'>";
            echo "<img src='{$row['image']}' alt='Event Image' class='event-image'>";
            echo "<div class='event-info'>";
            echo "<div class='event-name'>" . $row['e_name'] . "</div>";
            echo "<div class='event-date'>" . $row['date'] . "</div>";
            echo "<div class='event-type'>" . $row['type'] . "</div>";
            echo "</div>";
            echo "</div>";
            echo "<div class='actions'>";
            echo "<button onclick=\"openPopup('{$row['e_name']}', '{$row['date']}', '{$row['type']}', '{$row['place']}', '{$row['rounds']}', '{$row['capacity']}', '{$row['image']}')\">View More</button>";
            echo "<button onclick=\"openDetailsPopup('{$row['org_name']}', '{$row['o_name']}', '" . implode(', ', $volunteers) . "')\">View Organization & Volunteers</button>";
            echo "</div>";
            echo "</div>";
        }
    }
}

pg_close($dbconn);
?>

</div>

<div class="popup" id="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <img id="popup-image" src="" alt="Event Image" class="event-image">
        <h3 id="popup-event-name"></h3>
        <p><strong>Date:</strong> <span id="popup-date"></span></p>
        <p><strong>Type:</strong> <span id="popup-type"></span></p>
        <p><strong>Place:</strong> <span id="popup-place"></span></p>
        <p><strong>Rounds:</strong> <span id="popup-rounds"></span></p>
        <p><strong>Capacity:</strong> <span id="popup-capacity"></span></p>
    </div>
</div>

<div class="popup" id="details-popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closeDetailsPopup()">&times;</span>
        <h3>Organization & Volunteers Details</h3>
        <p><strong>Organization Name:</strong> <span id="details-org-name"></span></p>
        <p><strong>Organizer Name:</strong> <span id="details-organizer-name"></span></p>
        <p><strong>Volunteers:</strong> <span id="details-volunteers"></span></p>
    </div>
</div>

<script>
    function openPopup(name, date, type, place, rounds, capacity, image) {
        var popup = document.getElementById('popup');
        var popupEventName = document.getElementById('popup-event-name');
        var popupDate = document.getElementById('popup-date');
        var popupType = document.getElementById('popup-type');
        var popupPlace = document.getElementById('popup-place');
        var popupRounds = document.getElementById('popup-rounds');
        var popupCapacity = document.getElementById('popup-capacity');
        var popupImage = document.getElementById('popup-image');

        popupEventName.textContent = name;
        popupDate.textContent = date;
        popupType.textContent = type;
        popupPlace.textContent = place;
        popupRounds.textContent = rounds;
        popupCapacity.textContent = capacity;
        popupImage.src = image;

        popup.style.display = 'block';
    }

    function closePopup() {
        var popup = document.getElementById('popup');
        popup.style.display = 'none';
    }

    function openDetailsPopup(orgName, organizerName, volunteers) {
        var detailsPopup = document.getElementById('details-popup');
        var detailsOrgName = document.getElementById('details-org-name');
        var detailsOrganizerName = document.getElementById('details-organizer-name');
        var detailsVolunteers = document.getElementById('details-volunteers');

        detailsOrgName.textContent = orgName;
        detailsOrganizerName.textContent = organizerName;
        detailsVolunteers.textContent = volunteers;

        detailsPopup.style.display = 'block';
    }

    function closeDetailsPopup() {
        var detailsPopup = document.getElementById('details-popup');
        detailsPopup.style.display = 'none';
    }

    function applyFilters() {
        var searchInput = document.getElementById('searchInput').value;
        var filterType = document.getElementById('filterType').value;
        var filter = document.getElementById('filter').value;
        var sort = document.getElementById('sort').value;

        var form = document.createElement('form');
        form.method = 'POST';
        form.style.display = 'none';

        var searchInputElement = document.createElement('input');
        searchInputElement.name = 'searchInput';
        searchInputElement.value = searchInput;
        form.appendChild(searchInputElement);

        var filterTypeElement = document.createElement('input');
        filterTypeElement.name = 'filterType';
        filterTypeElement.value = filterType;
        form.appendChild(filterTypeElement);

        var filterElement = document.createElement('input');
        filterElement.name = 'filter';
        filterElement.value = filter;
        form.appendChild(filterElement);

        var sortElement = document.createElement('input');
        sortElement.name = 'sort';
        sortElement.value = sort;
        form.appendChild(sortElement);

        document.body.appendChild(form);
        form.submit();
    }
</script>
</body>
</html>