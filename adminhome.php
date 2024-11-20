<?php
include('dbconnection.php'); // Ensure your database connection is included

// Fetch the total number of users
$query = "SELECT COUNT(*) as total_users FROM users";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Get the total users and calculate the capacity left
$total_users = $data['total_users'];
$total_capacity = 20; // Maximum capacity
$capacity_left = $total_capacity - $total_users;

// Ensure the remaining capacity is not negative
$capacity_left = $capacity_left < 0 ? 0 : $capacity_left;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Movie Management</title>
    <link rel="stylesheet" href="admin.css">
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <h2 style="margin-top:70px width:100%">Admin Panel</h2>
            <nav>
                <ul>
                    <li ><a href="adminhome.php"><i class="fa-solid fa-house " style="margin-right:12px"></i>Home</a></li>
                    <li><a href="adminupload.php" id="addMovieLink" style="margin-right:18px"> <i class="fa-solid fa-clapperboard"></i> Add Movies</a></li>
                    <li><a href="adminlistalluser.php" style="margin-right:18px"><i class="fa-solid fa-users"></i> List All Users</a></li>
                    <li><a href="#logout"> <i class="fa-solid fa-right-from-bracket"></i>   Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Chart Section -->
        <div style="text-align: center; margin: 20px; width:900px">
            <h2>User Capacity Chart</h2>
            <canvas id="myChart" style="width:100%; max-width:900px">
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script>
            // Pass PHP variables to JavaScript
            const totalUsers = <?php echo $total_users; ?>;
            const capacityLeft = <?php echo $capacity_left; ?>;

            const xValues = ["Total Users", "Capacity Left"];
            const yValues = [totalUsers, capacityLeft];
            const barColors = ["#b91d47", "#00aba9"];

            // Create the doughnut chart
            new Chart("myChart", {
                type: "doughnut",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: "Ranjana User's Chart"
                    }
                }
            });
        </script>
    </div>
</body>
</html>
