<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>participant</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    header {
      background-color: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    .container {
      display: flex;
      justify-content: space-between;
      padding: 20px;
      margin-bottom: 20px;
    }

    .block {
      width: 40%; /* Reduce block width */
      margin: 0 auto; /* Center the block horizontally */
      background-color: #f0f0f0;
      padding: 20px;
      margin-bottom: 20px;
      transition: transform 0.3s, box-shadow 0.3s;
      box-sizing: border-box; /* Include padding in width calculation */
    }

    .block:hover {
      transform: translateY(-5px);
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    }

    .block-content {
      text-align: center;
    }

    .block img {
      width: 100%; /* Make the image fill its container */
      height: 200px; /* Set a fixed height */
      object-fit: cover; /* Maintain aspect ratio and cover the container */
      margin-bottom: 10px;
    }

    .block p {
      margin-bottom: 10px;
    }

    .block button {
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .block button:hover {
      background-color: #555;
    }

    footer {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 20px;
    }

    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      
      .block {
        width: 100%;
        margin-bottom: 20px;
      }
    }
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

header {
  background-color: #333;
  color: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
}

.logo img {
  height: 40px; /* Adjust height as needed */
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
          <P stle="color:white">EVENTS MANAGEMENT SYSTEM</P>
        </div>
        <div class="user-section">
          <div class="user-info">
            <span>organisation</span>
          </div>
          <div class="settings">
            <i class="fas fa-cog"></i>
            <a href="#">Logout</a>
          </div>
        </div>
      </header>
      <script>
        function event_display(){  
            window.location.href = 'organisation_event.php';
        }  
        function organiser_display(){  
            window.location.href = 'org_organiser.php';
        }  
        function volunteer_display(){  
            window.location.href = 'org_vol.php';
        }  
        </script>

  <div class="container">
    <div class="block" style="margin-right: 10px;">
      <div class="block-content">
        <img src="https://www.interfolio.com/wp-content/uploads/Students-raising-hands_community-college.jpg" alt="Image 1">
        <p>YOUR PROGRAMS</p>
        <button onclick="event_display()">View All</button>
      </div>
    </div>
    <div class="block">
      <div class="block-content">
        <img src="https://www.shutterstock.com/image-vector/vector-illustration-simple-flat-style-260nw-1705391407.jpg" alt="Image 2">
        <p>ORGANISERS</p>
        <button onclick="organiser_display()">View All</button>
      </div>
    </div>
    <div class="block" style="margin-right: 10px;">
      <div class="block-content">
        <img src="https://www.interfolio.com/wp-content/uploads/Students-raising-hands_community-college.jpg" alt="Image 1">
        <p>VOLUNTEERS</p>
        <button onclick="volunteer_display()">View All</button>
      </div>
    </div>
  </div>

  <footer>
    <p>All rights reserved &copy; 2024</p>
  </footer>

</body>
</html>
