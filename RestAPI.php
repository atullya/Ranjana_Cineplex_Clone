<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization");

// Database configuration
$host = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "ranjana";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Get the HTTP request method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Handle the incoming request
switch ($method) {
    case 'GET': // Fetch movies
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM movies WHERE movie_id = $id");

            // Check if movie exists
            if ($result->num_rows > 0) {
                echo json_encode($result->fetch_assoc());
            } else {
                echo json_encode(["status" => "error", "message" => "Movie not found"]);
            }
        } else {
            $result = $conn->query("SELECT * FROM movies");
            $movies = [];
            while ($row = $result->fetch_assoc()) {
                $row['available_time'] = json_decode($row['available_time']); // Decode available times
                $movies[] = $row;
            }
            echo json_encode($movies);
        }
        break;

    case 'POST': // Add a new movie with images and videos
        if (!empty($_POST) && isset($_FILES['image'], $_FILES['vid'])) {
            // Validate uploaded files
            $allowedImageTypes = ['image/jpeg', 'image/png'];
            $allowedVideoTypes = ['video/mp4', 'video/avi'];

            $image = $_FILES['image'];
            $video = $_FILES['vid'];

            if (!in_array($image['type'], $allowedImageTypes) || !in_array($video['type'], $allowedVideoTypes)) {
                echo json_encode(["status" => "error", "message" => "Invalid file type"]);
                exit();
            }

            // Move uploaded files to a specific directory
            $imagePath = 'uploads/' . basename($image['name']);
            $videoPath = 'uploads/' . basename($video['name']);

            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                echo json_encode(["status" => "error", "message" => "Failed to upload image"]);
                exit();
            }

            if (!move_uploaded_file($video['tmp_name'], $videoPath)) {
                echo json_encode(["status" => "error", "message" => "Failed to upload video"]);
                exit();
            }

            // Insert movie into the database
            $stmt = $conn->prepare("INSERT INTO movies (title, duration, available_time, genre, description, director, cast, release_on, image, vid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "ssssssssss",
                $_POST['title'],
                $_POST['duration'],
                json_encode(explode(',', $_POST['available_time'])), // Convert available times to JSON array
                $_POST['genere'],
                $_POST['description'],
                $_POST['director'],
                $_POST['cast'],
                $_POST['releaseon'],
                $imagePath,
                $videoPath
            );

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Movie added successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add movie"]);
            }

            $stmt->close();
        }else {
            echo json_encode(["status" => "error", "message" => "Missing files or invalid input"]);
        }
        break;

    case 'PUT': // Update an existing movie
        if (isset($_GET['id']) && !empty($_POST)) {
            $id = intval($_GET['id']);
            $imagePath = isset($_FILES['image']) ? 'uploads/' . basename($_FILES['image']['name']) : null;
            $videoPath = isset($_FILES['vid']) ? 'uploads/' . basename($_FILES['vid']['name']) : null;

            // Validate uploaded files
            if (isset($_FILES['image']) && !in_array($_FILES['image']['type'], ['image/jpeg', 'image/png'])) {
                echo json_encode(["status" => "error", "message" => "Invalid image file type"]);
                exit();
            }
            if (isset($_FILES['vid']) && !in_array($_FILES['vid']['type'], ['video/mp4', 'video/avi'])) {
                echo json_encode(["status" => "error", "message" => "Invalid video file type"]);
                exit();
            }

            // Move uploaded files if necessary
            if (isset($_FILES['image']) && !move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                echo json_encode(["status" => "error", "message" => "Failed to upload image"]);
                exit();
            }

            if (isset($_FILES['vid']) && !move_uploaded_file($_FILES['vid']['tmp_name'], $videoPath)) {
                echo json_encode(["status" => "error", "message" => "Failed to upload video"]);
                exit();
            }

            // Update movie in the database
            $stmt = $conn->prepare("UPDATE movies SET title=?, duration=?, available_time=?, genre=?, description=?, director=?, cast=?, release_on=?, image=?, vid=? WHERE movie_id=?");
            $stmt->bind_param(
                "ssssssssssi",
                $_POST['title'],
                $_POST['duration'],
                json_encode(explode(',', $_POST['available_time'])),
                $_POST['genere'],
                $_POST['description'],
                $_POST['director'],
                $_POST['cast'],
                $_POST['releaseon'],
                $imagePath ?? $_POST['image_old'],  // Use old image if not updating
                $videoPath ?? $_POST['vid_old'],    // Use old video if not updating
                $id
            );
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Movie updated successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update movie"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid input or missing ID"]);
        }
        break;

    case 'DELETE': // Delete a movie
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            // Optional: delete image and video files from the server as well
            $result = $conn->query("SELECT image, vid FROM movies WHERE movie_id = $id");
            if ($result->num_rows > 0) {
                $movie = $result->fetch_assoc();
                unlink($movie['image']); // Delete the image file
                unlink($movie['vid']);   // Delete the video file
            }

            // Delete the movie from the database
            if ($conn->query("DELETE FROM movies WHERE movie_id = $id")) {
                echo json_encode(["status" => "success", "message" => "Movie deleted successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete movie"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid ID"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Unsupported HTTP method"]);
        break;
}

// Close the database connection
$conn->close();
?>
