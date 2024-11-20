<?php
include('dbconnection.php'); // Ensure your database connection file is included

// Fetch data from the users table
$query = "SELECT * FROM users"; // Replace 'users' with your actual table name
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Movie Management</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Table styles */
        table {
            width: 90%;
            margin: 80px 100px;
            border-collapse: collapse;
            text-align: center;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <h2 style="margin-top:70px">Admin Panel</h2>
            <nav>
                <ul>
                <li ><a href="adminhome.php"><i class="fa-solid fa-house " style="margin-right:12px"></i>Home</a></li>
                    <li><a href="adminupload.php" id="addMovieLink" style="margin-right:18px"> <i class="fa-solid fa-clapperboard"></i> Add Movies</a></li>
                    <li><a href="adminlistalluser.php" style="margin-right:18px"><i class="fa-solid fa-users"></i> List All Users</a></li>
                    <li><a href="#logout"> <i class="fa-solid fa-right-from-bracket"></i>   Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Display user table -->
        <div class="display">
            <h2 style="text-align: center;">List of Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>UID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['uid']}</td>
                                <td>{$row['fname']}</td>
                                <td>{$row['lname']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['mobile']}</td>
                                <td><button class='delete-btn' onclick='deleteUser({$row['uid']})'>X</button></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // JavaScript to handle delete action
        function deleteUser(uid) {
            if (confirm('Are you sure you want to delete this user?')) {
                // Send delete request to backend
                fetch(`deleteUser.php?uid=${uid}`, { method: 'GET' })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload(); // Reload the page after deletion
                    })
                    .catch(error => console.error('Error deleting user:', error));
            }
        }
    </script>
</body>
</html>
