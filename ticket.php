<?php
session_start(); // Start the session

// Database connection
include('dbconnection.php');
$sql ="Select * from users";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ticket Rate</title>
    <link rel="stylesheet" href="ticket.css" />
    <link rel="stylesheet" href="styles.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      />
  </head>
  <body class="body">
  <section id="header">
        <?php
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            echo '
            <nav>
                <div class="logo">
                    <img src="Images/logo.png" alt="" />
                </div>
                <ul>
                    <li class="active"><a href="index.php">Home</a></li>
                    <li>Movie</li>
                    <li><a href="ticket.php">Ticket Rate</a></li>
                </ul>
                <div class="login">
                    <button><a href="login.php">Login</a></button>
                </div>
            </nav>';
        } else {
            echo '
            <nav>
                <div class="logo">
                    <img src="Images/logo.png" alt="" />
                </div>
                <ul>
                    <li class="active"><a href="index.php">Home</a></li>
                    <li>My Tickets</li>
                    <li><a href="booking.php">Booking</a></li>
                    <li><a href="movie.php">Movie</a></li>
                    <li><a href="ticket.php">Ticket Rate</a></li>
                </ul>
                <div class="after">
                    <ion-icon name="person-circle-outline" class="icon"></ion-icon>
                    <a href="user.php?uid=' . $row["uid"] . '">
                        <h2 class="session-user">' . htmlspecialchars($_SESSION["email"]) . '</h2>
                    </a>
                </div>
                <div class="logout">
                    <button><a href="?logout=true">Logout</a></button>
                </div>
            </nav>';
        }
        ?>
    </section>
    <section id="ticket-container">
      <div class="ticket-div">
        <div class="details">
          <h1>Ticket Prices</h1>
        </div>
        <div class="ticket-table">
          <table>
            <tr>
              <th>Morning Show</th>
              <th>Price</th>
            </tr>
            <tr>
              <td>Weekends (Fri-Sun)</td>
              <td>Rs 200</td>
            </tr>
            <tr>
              <td>Weekdays (Mon-Tues)</td>
              <td>Rs 150</td>
            </tr>
            <tr>
              <th>Regular Show</th>
              <th>Price</th>
            </tr>
            <tr>
              <td>Weekends (Fri-Sun)</td>
              <td>Rs 400</td>
            </tr>
            <tr>
              <td>Weekdays (Mon-Tues)</td>
              <td>Rs 300</td>
            </tr>
            <tr>
              <th class="wed">
                <pre>
WEDNESDAY/THURSDAY 
*(Offer not applicable for new release movies)
                </pre>
              </th>
              <th>Price</th>
            </tr>
            <tr>
              <td>Regular Show</td>
              <td>Rs. 175</td>
            </tr>
            <tr>
              <td>3D Show</td>
              <td>Rs. 225</td>
            </tr>
          </table>
        </div>
      </div>
    </section>
    </script>
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  </body>
</html>
