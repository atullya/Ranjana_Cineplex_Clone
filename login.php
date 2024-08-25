<?php
session_start();

include('dbconnection.php');

$showalert = false;
$showerror = false;
$activeTab = 'skills'; // Default to SIGN IN tab

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function allSet($fields) {
        foreach ($fields as $field) {
            if (!isset($_POST[$field])) {
                return false;
            }
        }
        return true;
    }

    if (isset($_POST['signup']) && allSet(['fname', 'lname', 'email', 'number', 'password', 'cpassword'])) {
        // Sign-Up Logic
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        if ($password == $cpassword) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`fname`, `lname`, `email`, `mobile`, `password`) 
                    VALUES ('$fname', '$lname', '$email', '$number', '$hashed_password')";

            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showalert = true;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            $showerror = "Passwords do not match. Try Again!";
            $activeTab = 'experience'; // Switch to SIGN UP tab if there's an error
        }
    } elseif (isset($_POST['signin']) && allSet(['email', 'password'])) {
        // Sign-In Logic
        $email = $_POST['email'];
        $password = $_POST["password"];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $num = mysqli_num_rows($result);
            if ($num == 1) {
                $row = mysqli_fetch_assoc($result);
                
                if (password_verify($password, $row['password'])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    header("Location: index.php");
                    exit();
                } else {
                    $showerror = "Invalid Credentials!";
                    $activeTab = 'skills'; // Stay on SIGN IN tab if there's an error
                }
            } else {
                $showerror = "Invalid Credentials!";
                $activeTab = 'skills'; // Stay on SIGN IN tab if there's an error
            }
        } else {
            die("Error in SQL query: " . mysqli_error($conn));
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranjana Cineplex</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login.css">
</head>
<body class="body">
    <?php 
    if ($showerror) { 
        echo '<div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
            <strong>Warning!</strong> ' . $showerror . '
            </div>';
    }
    if ($showalert) {
        echo '<div class="success">
            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
            <strong>Congrats!!</strong> Successfully Created an account!!
            </div>';
    }
    ?>

    <section id="header">
        <nav>
            <div class="logo">
                <img src="Images/logo.png" alt="" />
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li>Movie</li>
                <li><a href="ticket.php">Ticket Rate</a></li>
            </ul>
            <div class="login">
                <button><a href="login.html">Login</a></button>
            </div>
        </nav>
    </section>

    <section id="signn">
        <div class="sign-container">
            <div class="title">
                <div class="tab-titles1">
                    <p class="tab-links <?php echo $activeTab == 'skills' ? 'active-link' : ''; ?>" onclick="opentab('skills')">SIGN IN</p>
                    <p class="tab-links <?php echo $activeTab == 'experience' ? 'active-link' : ''; ?>" onclick="opentab('experience')">SIGN UP</p>
                </div>
            </div>

            <div class="tab-contents <?php echo $activeTab == 'skills' ? 'active-tab' : ''; ?>" id="skills">
                <section id="sign">
                    <div class="container">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="input">
                                <input type="email" placeholder="Email" name="email" required />
                                <input type="password" placeholder="Password" name="password" required />
                            </div>

                            <div class="but">
                                <button type="submit" name="signin">SIGN IN</button>
                                <p>Forgot Password?</p>
                            </div>
                        </form>
                    </div>
                </section>
            </div>

            <div class="tab-contents <?php echo $activeTab == 'experience' ? 'active-tab' : ''; ?>" id="experience">
                <div class="sign-up">
                    <div class="signbody">
                        <h3 class="h3">Complete The Form Sign Up</h3>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="text" placeholder="First Name*" name="fname" required />
                            <input type="text" placeholder="Last Name*" name="lname" required />
                            <input type="email" placeholder="Email*" name="email" required />
                            <input type="number" placeholder="Mobile*" name="number" required />
                            <input type="password" placeholder="Password*" name="password" required />
                            <input type="password" placeholder="Confirm Password*" name="cpassword" required />
                            <button type="submit" name="signup">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        let tablinks = document.getElementsByClassName("tab-links");
        let tabcontents = document.getElementsByClassName("tab-contents");

        function opentab(tabname) {
            for (let tablink of tablinks) {
                tablink.classList.remove("active-link");
            }
            for (let tabcontent of tabcontents) {
                tabcontent.classList.remove("active-tab");
            }

            document.getElementById(tabname).classList.add("active-tab");
            document.querySelector(`[onclick="opentab('${tabname}')"]`).classList.add("active-link");
        }
    </script>
</body>
</html>
