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
<title>Workshop List</title>
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

  .workshop {
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

  .workshop-image {
    width: 120px; /* Adjusted width */
    height: auto; /* Maintains aspect ratio */
    margin-right: 20px;
  }

  .workshop-details {
    display: flex;
    align-items: center;
  }

  .workshop-info {
    flex: 1;
  }

  .workshop-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .workshop-date {
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
        <input type="text" id="searchInput" placeholder="Search Workshops...">
        <select id="filterType">
            <option value="w_name">Name</option>
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
} else {
    // Default SQL query to retrieve all events
    $sql = "SELECT w.*, o.o_name, org.org_name, array_agg(v.v_name) as volunteers
        FROM workshops w
        JOIN program p ON w.w_id = p.prog_id
        JOIN organiser o ON p.o_id = o.o_id
        JOIN organisation org ON o.org_id = org.org_id
        LEFT JOIN volunteers v ON v.o_id = o.o_id
        GROUP BY w.w_id, o.o_id, org.org_id";


  // Execute the SQL query
    // Check if search input is provided
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
        $searchInput = pg_escape_string($_POST['searchInput']);
        $filterType = $_POST['filterType'];
        $sql .= " HAVING $filterType LIKE '%$searchInput%'";
    }

    // Filter events based on criteria if provided in the POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter']) ) {
        $filter = $_POST['filter']; // Assuming 'filter' is the name of the filter criterion

        // Implement filtering based on the chosen criterion
        switch ($filter) {
            case 'upcoming': // Example: Show only upcoming events
                $sql .= " HAVING date >= CURRENT_DATE";
                break;
            case 'past': // Example: Show only past events
                $sql .= " HAVING date < CURRENT_DATE";
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
    $result = pg_query($dbconn, $sql);

    // Check if the query was successful
    if (!$result) {
        echo "<div>Error: Unable to retrieve workshops from the database.</div>";
    } else {
        // Display the retrieved events
        while ($row = pg_fetch_assoc($result)) {
            $volunteers = isset($row['volunteers']) ? array_filter(explode(',', trim($row['volunteers'], '{}'))) : [];
            echo "<div class='workshop'>";
            echo "<div class='workshop-details'>";
            echo "<img src='{$row['image']}' alt='workshop Image' class='workshop-image'>";
            echo "<div class='workshop-info'>";
            echo "<div class='workshop-name'>" . $row['w_name'] . "</div>";
            echo "<div class='workshop-date'>" . $row['date'] . "</div>";
            echo "<div class='workshop-type'>" . $row['type'] . "</div>"; // Added event type
            echo "</div>";
            echo "</div>";
            echo "<div class='actions'>";
            echo "<button onclick=\"openPopup('{$row['w_name']}', '{$row['date']}', '{$row['type']}', '{$row['place']}', '{$row['conducted_by']}','{$row['capacity']}', '{$row['start_time']}', '{$row['end_time']}','{$row['image']}')\">View More</button>"; // Changed to button for consistency
            echo "<button onclick=\"openDetailsPopup('{$row['org_name']}', '{$row['o_name']}', '" . implode(', ', $volunteers) . "')\">View Organization & Volunteers</button>";
            echo "</div>";
            echo "</div>";
        }
    }
}

// Close database connection
pg_close($dbconn);
?>

</div>

<!-- Popup box for event details -->
<div class="popup" id="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <img id="popup-image" src="" alt="workshop Image" class="workshop-image">
        <h3 id="popup-workshops-name"></h3>
        <p><strong>Date:</strong> <span id="popup-date"></span></p>
        <p><strong>Type:</strong> <span id="popup-type"></span></p>
        <p><strong>Place:</strong> <span id="popup-place"></span></p>
        <p><strong>conducted by:</strong> <span id="popup-conductedby"></span></p>
        <p><strong>Capacity:</strong> <span id="popup-capacity"></span></p>
        <p><strong>start time:</strong> <span id="popup-starttime"></span></p>
        <p><strong>end time:</strong> <span id="popup-endtime"></span></p>
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
    function openPopup(name, date, type, place,conductedby,capacity,starttime,endtime, image) {
        var popup = document.getElementById('popup');
        var popupEventName = document.getElementById('popup-workshops-name');
        var popupDate = document.getElementById('popup-date');
        var popupType = document.getElementById('popup-type');
        var popupPlace = document.getElementById('popup-place');
        var popupconductedby = document.getElementById('popup-conductedby');
        var popupCapacity = document.getElementById('popup-capacity');
        var popupImage = document.getElementById('popup-image');
        var popupstarttime = document.getElementById('popup-starttime');
        var popupendtime = document.getElementById('popup-endtime');

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
        var form = document.createElement('form');
        form.method = 'post';
        form.action = ''; // Add your PHP script URL here

        var searchInput = document.getElementById('searchInput').value;
        var filterType = document.getElementById('filterType').value;
        var filter = document.getElementById('filter').value;
        var sort = document.getElementById('sort').value;

        var input1 = document.createElement('input');
        input1.type = 'hidden';
        input1.name = 'searchInput';
        input1.value = searchInput;
        form.appendChild(input1);

        var input2 = document.createElement('input');
        input2.type = 'hidden';
        input2.name = 'filterType';
        input2.value = filterType;
        form.appendChild(input2);

        var input3 = document.createElement('input');
        input3.type = 'hidden';
        input3.name = 'filter';
        input3.value = filter;
        form.appendChild(input3);

        var input4 = document.createElement('input');
        input4.type = 'hidden';
        input4.name = 'sort';
        input4.value = sort;
        form.appendChild(input4);

        document.body.appendChild(form);
        form.submit();
    }
</script>

</body>
</html>