<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Movie Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Admin Movie Management</h1>
    <button id="loadMovies">Load Movies</button>
    <div id="movieList"></div>

    <h2>Add New Movie</h2>
    <form id="movieForm" enctype="multipart/form-data">
        <input type="text" id="title" placeholder="Title" required><br>
        <input type="text" id="duration" placeholder="Duration" required><br>
        <input type="text" id="available_time" placeholder="Available Time (comma-separated)" required><br>
        <input type="text" id="genere" placeholder="Genre" required><br>
        <textarea id="description" placeholder="Description" required></textarea><br>
        <input type="text" id="director" placeholder="Director" required><br>
        <input type="text" id="cast" placeholder="Cast" required><br>
        <input type="date" id="releaseon" placeholder="Release Date" required><br>
        
        <!-- Image File Upload -->
        <input type="file" id="image" accept="image/*" required><br>
        
        <!-- Video File Upload -->
        <input type="file" id="vid" accept="video/*" required><br>
        
        <button type="submit">Add Movie</button>
    </form>

    <script src="script.js"></script>
</body>
</html>



<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    button {
        margin: 10px;
        padding: 10px;
        background-color: #5cb85c;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #4cae4c;
    }

    form {
        margin: 20px auto;
        width: 300px;
    }

    form input, form textarea {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
    }

    form button {
        background-color: #0275d8;
    }

    #movieList {
        margin: 20px;
        padding: 10px;
        background-color: white;
        border-radius: 5px;
    }

    #movieList img {
        margin-top: 10px;
        border-radius: 8px;
    }

    #movieList div {
        margin: 10px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    #movieList div button {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    #movieList div button:hover {
        background-color: darkred;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Load movies from the backend API
    document.getElementById('loadMovies').addEventListener('click', () => {
        fetch('http://localhost/ranjana/RestAPI.php')
            .then(response => response.json())
            .then(data => {
                const movieList = document.getElementById('movieList');
                movieList.innerHTML = ''; // Clear previous list
                data.forEach(movie => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <h3>${movie.title}</h3>
                        <p>${movie.description}</p>
                        <img src="${movie.image}" alt="${movie.title}" style="max-width: 100%; height: auto;">
                        <button onclick="deleteMovie(${movie.movie_id})">Delete</button>
                    `;
                    movieList.appendChild(div);
                });
            })
            .catch(error => {
                console.error('Error loading movies:', error);
            });
    });

    // Function to delete a movie
    window.deleteMovie = function (id) {
        fetch(`http://localhost/ranjana/RestAPI.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload the page after deletion
        })
        .catch(error => {
            console.error('Error deleting movie:', error);
        });
    }

    // Handling the form submission to add a movie
    document.getElementById('movieForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData();
        const title = document.getElementById('title').value;
        const duration = document.getElementById('duration').value;
        const availableTime = document.getElementById('available_time').value.split(',');
        const genere = document.getElementById('genere').value;
        const description = document.getElementById('description').value;
        const director = document.getElementById('director').value;
        const cast = document.getElementById('cast').value;
        const releaseon = document.getElementById('releaseon').value;
        const image = document.getElementById('image').files[0];
        const vid = document.getElementById('vid').files[0];

        // Validation for required fields
        if (!title || !duration || !availableTime || !genere || !description || !director || !cast || !releaseon || !image || !vid) {
            alert("All fields are required!");
            return;
        }

        // Append the form data
        formData.append('title', title);
        formData.append('duration', duration);
        formData.append('available_time', JSON.stringify(availableTime)); // Ensure available_time is an array
        formData.append('genere', genere);
        formData.append('description', description);
        formData.append('director', director);
        formData.append('cast', cast);
        formData.append('releaseon', releaseon);
        formData.append('image', image);
        formData.append('vid', vid);

        // Send form data to the backend
        fetch('http://localhost/ranjana/RestAPI.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload the page after successful submission
        })
        .catch(error => {
            console.error('Error adding movie:', error);
        });
    });
});

</script>
