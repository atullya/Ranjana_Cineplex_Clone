<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranjana Cineplex</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section id="header">
        <nav>
            <div class="logo">
                <img src="Images/logo.png" alt="">
            </div>
            <ul>
                <li>Home</li>
                <li>Movie</li>
                <li>Ticket Rate</li>
            </ul>
            <div class="login">
                <button>Login</button>
            </div>
        </nav>
    </section>
    <section id="slider">
    <div class="slideshow-container">

<!-- Full-width images with number and caption text -->
<div class="mySlides fade">
 
  <img src="Images/banner1.png" style="width:100%">
 
</div>

<div class="mySlides fade">

  <img src="Images/banner2.png" style="width:100%">
 
</div>

<div class="mySlides fade">

  <img src="Images/dead.png" style="width:100%">

</div>

<!-- Next and previous buttons -->
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div  class="dotts" style="text-align:center">
<span class="dot" onclick="currentSlide(1)"></span>
<span class="dot" onclick="currentSlide(2)"></span>
<span class="dot" onclick="currentSlide(3)"></span>
</div>
    </section>

    <section id="hero">
        <div class="hero-heading">
            <h1>NOW SHOWING</h1>
            <div class="dates">
                <span>TODAY</span>
                <span>TOMM</span>
                <span>14 AUG</span>
                <span>15 AUG</span>
                <span>16 AUG</span>
                <span>17 AUG</span>
                <span>18 AUG</span>
            </div>
        </div>
    </section>
    <script src="index.js"></script>
</body>
</html>
