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
?>z`

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking</title>
    <link rel="stylesheet" href="styles.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
<link rel="stylesheet" href="booking.css">
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
                    <li ><a href="index.php">Home</a></li>
                    <li>My Tickets</li>
                    <li class="active"><a href="booking.php">Booking</a></li>
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

 <section class="book-container">
     <div class="main-container">
         <div class="col1">
            <h3 class="para">Select Your Show</h3>
<div class="mov-det">
<div class="img-idv">

    <div id="showimg"></div>
</div>
<div class="movie-div">
    <h3>Select Movie</h3>
    <div class="mm">
<p>Change Movie</p>
        <div id="movie"></div>
    </div>
    <div class="screen">
        <p>Screen</p>
        <select name="" id="">
            <option value="">Ranjana Cineplex > Audi 1</option>
        </select>
    </div>
    <div class="day">
        <p>Day</p>
        <select name="" id="whatdate">
        <option value="Today">Today</option>
        <option value="Tomorrow">Tomorrow</option>
            </select>
    </div>
    <div class="showtime">
        <p>Show Time</p>
        <div id="timediv"></div>
    </div>

</div>
</div>

        </div>
        <div class="coll2">
            <h3>Your Summary Pannel</h3>
            <div class="dett">
            <div class="movv">  <p>Movie <p id="movid"></p></p></div>
          
          <p><pre>Screen     Ranjana Cineplex > Audi - 1 </pre>  </p>
          <div class="movv">

              <p>Date <p id="date"></p></p>
          </div>
          <p>Time</p>
            </div>
            
        </div>
    </div>
 </section>
       

    <script src="book.js">
   
      </script>
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
  </body>
</html>