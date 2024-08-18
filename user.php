<?php
session_start(); // Start the session

// Database connection
include('dbconnection.php');

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<?php
include('dbconnection.php');
$ffname = $llname = $eemail = $mmobile=$ppassword = "";  // Initialize variables (yo chai rakhnai parxa yo bhayana bhanne hamro refresh bhaya paxi input field ko value ma j pai tei garbage value aauxa tesialey
// i.e  variables $ffname, $llname, etc., are not defined when the form is reloaded after the POST request is processed. This happens because those variables are only set during the GET request when the user data is fetched from the database.)

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $uid = $_GET['uid'];  // Get the uid from the URL
    $success=false;
 
    // Fetch the specific user by uid
    $sql = "SELECT * FROM users WHERE uid = $uid";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $ffname = $row['fname'];
        $llname = $row['lname'];
        $eemail = $row['email'];
        $mmobile = $row['mobile'];
        $pass=$row['password'];
    } else {
        echo "User not found";
    }

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];  // Get the uid from the hidden input field

    if (isset($_POST['profiles'])) {
        $uname = $_POST['uname'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $resphone = $_POST['resphone'];
        $phone = $_POST['phone'];

        // Update the user information
        $sql = "UPDATE users SET fname='$fname', lname='$lname', email='$email', mobile='$phone' WHERE uid=$uid";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Failed to update user.";
        } else {
            // Fetch the updated data from the database again after update
            $sql = "SELECT * FROM users WHERE uid = $uid";
            $result = mysqli_query($conn, $sql);
            if($result){
                $success=true;
            }

            if ($row = mysqli_fetch_assoc($result)) {
                $ffname = $row['fname'];
                $llname = $row['lname'];
                $eemail = $row['email'];
                $mmobile = $row['mobile'];
            }
          
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="user.css">
<link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
<body class="body">
   
    <section id="header">
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
             <?php  echo '<a href="user.php"> <h2 class="session-user">' . htmlspecialchars($_SESSION["email"]) . '</h2></a>'; ?>
                <div>
                <div class="logout">
                    <button><a href="?logout=true">Logout</a></button>
                </div>
            </nav>';
    </section>

    <?php 
if($success){
    echo'   <div class="form-popup" id="myForm">
      <form class="form-container">
        <h2>Profile Update</h2>
        <p>Sucessful</p>
        <p class="btn cancel" onclick="closeForm()">
          <span class="close"><i class="fas fa-check"></i> Close</span>
        </p>
      </form>
    </div>';
}
                ?>
    <section id="container-body">
    <div class="tab-titles">
                        <p class="tab-links " onclick="opentab('password')">Change Password</p>
                        <p class="tab-links active-link" onclick="opentab('profile')">Edit Profile</p>
                     
                    </div>
                    <div class="tab-contents " id="password">

                        <form action="" class="password" method="post">
                            <div class="curr">
                                <p class="ptext">Current Password</p>
                                <input type="password"  name="currpassword"   value="<?php echo $pass; ?>">
                            </div>
                            <div class="newp">
                                <p class="ptext">New Password</p>
                                <input type="password" name="newpassword">
                            </div>
                            <div class="newcp">
                                <p class="ptext">Confirm Password</p>
                                <input type="password" name="newcpassword">
                            </div>
                         

                            <button>Save</button>
                        </form>
                    </div>
                    <div class="tab-contents active-tab" id="profile">
    <form action="user.php" method="post" class="user" >
        <div class="username">
            <p class="ptext">User Name</p>
            <input type="text" name="uname"  value="<?php echo $ffname. " ". $llname; ?>">
        </div>
        <section class="form-cont">
            <div class="col1">
                <div class="fname">
                    <p class="ptext">First Name</p>
                    <input type="text" name="fname" value="<?php echo $ffname; ?>">
                </div>
                <div class="gender">
                    <p class="ptext">Gender</p>
                    <div class="select-gen">

                        <input type="radio" name="gender" value="male"> Male
                        <input type="radio" name="gender" value="female"> Female
                    </div>
                </div>
                <div class="location">
                    <p class="ptext">Location</p>
                    <input type="text" name="location">
                </div>
                <div class="resphone">
                    <p class="ptext">Res. Phone:</p>
                    <input type="text" name="resphone">
                </div>
                <div class="about-you">
                    <p class="ptext">About You</p>
                    <input type="text" class="about" name="aboutyou">
                </div>
                <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                <button name="profiles" type="submit">Save</button>
               
            </div>
            <div class="col22">
                <div class="lname">
                    <p class="ptext">Last Name</p>
                    <input type="text" name="lname"  value="<?php echo $llname; ?>">
                </div>
                <div class="birthdate">
                    <p class="ptext">BirthDate</p>
                    <input type="text" name="bdate" >
                </div>
                <div class="email">
                    <p class="ptext">Email</p>
                    <input type="email" name="email"  value="<?php echo $eemail; ?>">
                </div>
                <div class="mobile">
                    <p class="ptext">Mobile</p>
                    <input type="text" name="phone"  value="<?php echo $mmobile; ?>">
                </div>
            </div>
        </section>
    </form>
</div>

                    
    </section>


    <script>
      function openForm() {
        document.getElementById("myForm").style.display = "block";
      }

      function closeForm() {
        document.getElementById("myForm").style.display = "none";
      }
    </script>


    <script>
        let tablinks = document.getElementsByClassName('tab-links');
        let tabcontents = document.getElementsByClassName('tab-contents');

        function opentab(tabname){
for(tablink of tablinks){
    tablink.classList.remove("active-link");
}
            for (tabcontent of tabcontents) {
                tabcontent.classList.remove("active-tab");
            }

            event.currentTarget.classList.add("active-link");
            document.getElementById(tabname).classList.add("active-tab")
        }

    </script>

    
</body>
</html>