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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ranjana Cineplex</title>
    <link rel="stylesheet" href="styles.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
</head>
<body>
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
                    <li><a href="ticket.html">Ticket Rate</a></li>
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
                    <li><a href="ticket.html">Booking</a></li>
                    <li><a href="ticket.html">Movie</a></li>
                    <li><a href="ticket.html">Ticket Rate</a></li>
                </ul>
                <div class="after">
                <ion-icon name="person-circle-outline" class="icon"></ion-icon>
                <h2 class="session-user">' . htmlspecialchars($_SESSION["email"]) . '</h2>
                <div>
                <div class="logout">
                    <button><a href="?logout=true">Logout</a></button>
                </div>
            </nav>';
        }
        ?>
    </section>

    <section id="slider">
        <div class="slideshow-container">
            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
                <img src="Images/banner1.png" style="width: 100%" />
            </div>

            <div class="mySlides fade">
                <img src="Images/banner2.png" style="width: 100%" />
            </div>

            <div class="mySlides fade">
                <img src="Images/dead.png" style="width: 100%" />
            </div>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br />

        <!-- The dots/circles -->
        <div class="dotts" style="text-align: center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </section>

    <section id="hero">
        <div class="hero-heading">
            <h1>NOW SHOWING</h1>
            <div class="dates">
                <p class="today">TODAY</p>
                <span>TOMM</span>
                <span>14 AUG</span>
                <span>15 AUG</span>
                <span>16 AUG</span>
                <span>17 AUG</span>
                <span>18 AUG</span>
            </div>
        </div>
        <section id="movie"><div id="show-movie"></div></section>
        <footer>
            <div class="col1">
                <div class="col1-img">
                    <img src="Images/logo.png" alt="" />
                </div>
                <div class="col1-des">
                    <li>
                        Ranjana Cineplex is a multiplex that is fully equipped with
                        cutting-edge cinema technology and offers the finest movie
                        experience.
                    </li>
                </div>
            </div>
            <div class="col2">
                <p>Quicklinks</p>
                <ul>
                    <li>About us</li>
                    <li>Booking</li>
                    <li>Contact</li>
                    <li>Career</li>
                    <li>Advertise With Us</li>
                </ul>
            </div>
            <div class="col3">
                <div class="payment1">
                    <h2>Preferred Payment Partner</h2>
                    <img src="Images/payment/khalti.png" alt="" />
                </div>
                <div class="payment2">
                  <p>PAYMENT PARTNER</p>
                    <img src="Images/payment/esewa.png" class="esewa" alt="" />
                    <img src="Images/payment/fonepay.png" class="phonepay" alt="" />
                </div>
            </div>
            <div class="col4">
                <div class="col4-upper">
                    <p>Contact</p>
                    <ul>
                        <li>5th Floor, Ranjana Trade Center Newroad, Kathmandu</li>
                        <li>info@ranjanacineplex.com</li>
                        <li>01-5919395 , 01-5919495</li>
                        <li>+977 9864160666</li>
                    </ul>
                </div>
                <div class="col4-lower">
                    <div class="message">
                        <h3>For Suggestions & Support</h3>
                        <div class="env">
                        <ion-icon name="mail-outline" class="mail"></ion-icon>
                        <p>wecare@ranjanacineplex.com</p>
                        </div>
                    </div>
   
                    <div class="connect">
                        <h3>Connect With Us</h3>
                        <div class="social">
                            <div class="fb"><i class="fa-brands fa-facebook" ></i><p>Ranjana Cineplex</p></div>
                            <div class="insta"><i class="fa-brands fa-instagram"></i><p>ranjana_cineplex</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </section>

    <div id="trailerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="showvideo"></div>
        </div>
    </div>

    <script>
      let allData = [];
      async function getData() {
        let response = await fetch("movie.json");
        console.log(response);
        let data = await response.json();
        console.log(data);
        allData = data;
        display(data);
      }
      function display(data) {
        let content = "";
        let showmovie = document.getElementById("show-movie");

        data.forEach((element, index) => {
          content += `
            <div class="movies">
                <img src="${element.image}">
                <p class="title">${element.title}</p>
                <p class="duration">${element.duration}</p>
                <p class="showtimes">
                    <ul>${showTime(element.available_time)}</ul>
                </p>
                <div class="layer">
                  <button class="btn" onclick="trailer(event,${index})">Trailer</button>
                  <button class="btn" onclick="detail(event, ${index})">Buy Now </button>
                </div>
            </div>`;
        });

        showmovie.innerHTML = content;
      }
      function detail(event, index) {
        event.preventDefault();
        let dataindex = allData[index];
        console.log(dataindex);
        localStorage.setItem("moviedetail", JSON.stringify(dataindex));
        window.location.href = "details.html";
      }
      function showTime(times) {
        return times.map((time) => `<li>${time}</li>`).join("");
      }

      // Trailer
      function trailer(event, index) {
        event.preventDefault(); // Prevent the default action

        let videoIndex = allData[index];
        console.log(videoIndex);
        console.log(videoIndex.vid);

        if (videoIndex && videoIndex.vid) {
          let modal = document.getElementById("trailerModal");
          let showvideo = document.getElementById("showvideo");

          showvideo.innerHTML = `
            <iframe
              id="videoframe"
              width="560" height="315"
              src="${videoIndex.vid}"
              title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`;

          modal.style.display = "block";

          let closeBtn = document.querySelector(".close");
          closeBtn.onclick = function () {
            modal.style.display = "none";
            showvideo.innerHTML = "";
          };

          window.onclick = function (event) {
            if (event.target == modal) {
              modal.style.display = "none";
              showvideo.innerHTML = "";
            }
          };
        } else {
          console.error("Video URL not found for this movie.");
        }
      }

      getData();
      </script>
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="index.js"></script>
  </body>
</html>