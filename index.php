<?php
session_start();
$t_id = isset($_SESSION['t_id']) ? $_SESSION['t_id'] : "";

// Database connection parameters
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

// Fetch the amount payable from the database based on the t_id
$query = "SELECT amount FROM payment WHERE t_id = $t_id";
$result = pg_query($conn, $query);
if (!$result) {
    echo "Error fetching payment amount.";
    exit;
}
$row = pg_fetch_assoc($result);
$pamount = $row['amount'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
            text-transform: capitalize;
            transition: all 0.2s linear;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .col .title {
            font-size: 20px;
            color: rgb(237, 55, 23);
            padding-bottom: 5px;
        }

        .col .inputBox {
            margin: 15px 0;
        }

        .col .inputBox label {
            margin-bottom: 10px;
            display: block;
        }

        .col .inputBox input,
        .col .inputBox select {
            width: 100%;
            border: 1px solid #ccc;
            padding: 10px 15px;
            font-size: 15px;
        }

        .col .inputBox input:focus,
        .col .inputBox select:focus {
            border: 1px solid #000;
        }

        .col .flex {
            display: flex;
            gap: 15px;
        }

        .col .flex .inputBox {
            flex: 1 1;
            margin-top: 5px;
        }

        .col .inputBox img {
            height: 34px;
            margin-top: 5px;
            filter: drop-shadow(0 0 1px #000);
        }
		.submit_btn {
    width: 100%;
    padding: 12px;
    font-size: 17px;
    background: rgb(44, 52, 100);
    color: #fff;
    margin-top: 20px;
    cursor: pointer;
    letter-spacing: 1px;
    border-radius: 5px;
    border: none; /* Added to remove default button border */
    outline: none; /* Added to remove default button outline */
}

.submit_btn:hover {
    background: #622567;
}

        input::-webkit-inner-spin-button,
        input::-webkit-outer-spin-button {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="box">
        <div class="col">
            <h3 class="title">Payment</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="inputBox">
                <label for="name">
                    Card Accepted:
                </label>
                <img src="https://www.trainsandtravel.com/wp-content/uploads/2017/10/109-credit-cards-accepted-logo.jpg" alt="credit/debit card image">
            </div>
            <div class="inputBox">
            <label for="name">
                    AMOUNT PAYABLE:
                </label>
                <h2><?php echo "$pamount" ; ?></h2>
            </div>
            <div class="inputBox">
                <label for="cardName">
                    Name On Card:
                </label>
                <input type="text" id="cardName"
                       placeholder="Enter card name"
                       required>
            </div>

            <div class="inputBox">
                <label for="cardNum">
                    Credit Card Number:
                </label>
                <input type="text" id="cardNum"
                       placeholder="1111-2222-3333-4444"
                       maxlength="19" required>
            </div>

            <div class="inputBox">
                <label for="">Exp Month:</label>
                <select name="" id="">
                    <option value="">Choose month</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>


            <div class="flex">
                <div class="inputBox">
                    <label for="">Exp Year:</label>
                    <select name="" id="">
                        <option value="">Choose Year</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>

                <div class="inputBox">
                    <label for="cvv">CVV</label>
                    <input type="number" id="cvv"
                           placeholder="1234" required>
                </div>
            </div>
            <button type="submit" name="payform" class="submit_btn">Submit</button>
        </div>
    </div>
</div>
<?php
// Start session
// Get the team ID from session
$t_id = isset($_SESSION['t_id']) ? $_SESSION['t_id'] : "";
echo "$t_id";

// Check if team ID is set
if (!$t_id) {
    echo "Team ID is not set.";
    exit;
}

// Database connection parameters
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payform'])) {
    // Update payment status to "PAID" for the given team ID
    $t_id = $_SESSION['t_id'];
    $query = "UPDATE payment SET payment_status = 'PAID' WHERE t_id = $t_id";
    $result = pg_query($conn, $query);
    if (!$result) {
        echo "Error updating payment status.";
        exit;
    }

    // Retrieve participant details
    $query = "SELECT p.p_name, p.email, t.prog_id, e.date, e.place
              FROM team_members tm
              JOIN participants p ON tm.p_id = p.p_id
              JOIN team t ON tm.t_id = t.t_id
              JOIN events e ON t.prog_id = e.e_id
              WHERE tm.t_id = $t_id";
    $result = pg_query($conn, $query);
    if (!$result) {
        echo "Error fetching participant details.";
        exit;
    }

    // Loop through participants and send email to each
    while ($row = pg_fetch_assoc($result)) {
        $participant_name = $row['p_name'];
        $participant_email = $row['email'];
        $prog_id = $row['prog_id'];
        $event_date = $row['date'];
        $event_place = $row['place'];

        // Email details
        $to = $participant_email;
        $subject = "Payment Confirmation for Program Registration";
        $message = "Dear $participant_name,\n\n";
        $message .= "Thank you for registering for our program. Your payment has been received and your registration is confirmed.\n\n";
        $message .= "Program ID: $prog_id\n";
        $message .= "Event Date: $event_date\n";
        $message .= "Event Place: $event_place\n\n";
        $message .= "If you have any questions, feel free to contact us.\n\n";
        $message .= "Best regards,\nThe Program Team";
        $from = 'pmkiruthi1704@gmail.com';
        $headers = 'From: ' . $from;
        // Send email
        $mail_sent = mail($to, $subject, $message, $headers);

        // Check if email is sent successfully
        if ($mail_sent) {
            echo "<script>alert('Email sent to $participant_email successfully.<br>');</script>";
        } else {
            echo "Failed to send email to $participant_email.<br>";
        }
    }
} else {
    echo "Error: Form not submitted.";
}

// Close database connection
pg_close($conn);
?>

</body>
</html>
