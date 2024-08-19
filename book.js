let allData = [];
async function getData() {
  let response = await fetch("movie.json");
  let data = await response.json();
  allData = data; // Update the global variable
  display(data);
}

function display(data) {
  let movie = document.getElementById("movie");
  let content = `<select id="movieSelect">`;

  data.forEach((element) => {
    content += `<option data-imgid="${element.image}" data-title="${
      element.title
    }" data-times="${element.available_time.join(",")}" value="${
      element.title
    }">${element.title}</option>`;
  });

  content += `</select>`;
  movie.innerHTML = content;

  // Display the image and time for the first movie option by default
  let selectElement = document.getElementById("movieSelect");
  showimg(selectElement);
  showtime(selectElement);

  // Add event listener to dropdown
  selectElement.addEventListener("change", function () {
    showimg(this);
    showtime(this);
  });
}

function showimg(selectElement) {
  let selectedOption = selectElement.options[selectElement.selectedIndex];
  let imageSrc = selectedOption.getAttribute("data-imgid");

  let showimg = document.getElementById("showimg");
  showimg.innerHTML = `<img src="${imageSrc}" alt="Selected Movie Image">`;

  let title = selectedOption.getAttribute("data-title");
  let movid = document.getElementById("movid");
  movid.innerHTML = `${title}`;
}

//only to show time not to foucs on this
function showtime(selectElement) {
  let selectedOption = selectElement.options[selectElement.selectedIndex];
  let times = selectedOption.getAttribute("data-times").split(",");

  let timediv = document.getElementById("timediv");
  let timed = times.map((time) => `<li>${time}</li>`).join("");

  timediv.innerHTML = `<p>${timed}</p>`;
}
function getDate() {
  let whatdate = document.getElementById("whatdate");
  let dateElement = document.getElementById("date");

  // Arrays to display day of the week and month names
  const daysOfWeek = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  // Event listener for change in selection
  whatdate.addEventListener("change", function () {
    let selectedValue = whatdate.value;

    // Get the current date
    let currentDate = new Date();

    if (selectedValue === "Today") {
      // Today's date
      let day = currentDate.getDate();
      let month = currentDate.getMonth();
      let year = currentDate.getFullYear();
      let dayOfWeek = currentDate.getDay();

      let formattedDate = `${daysOfWeek[dayOfWeek]}, ${day} ${months[month]} ${year}`;
      dateElement.innerHTML = formattedDate;
    } else if (selectedValue === "Tomorrow") {
      // Tomorrow's date
      currentDate.setDate(currentDate.getDate() + 1);
      let day = currentDate.getDate();
      let month = currentDate.getMonth();
      let year = currentDate.getFullYear();
      let dayOfWeek = currentDate.getDay();

      let formattedDate = `${daysOfWeek[dayOfWeek]}, ${day} ${months[month]} ${year}`;
      dateElement.innerHTML = formattedDate;
    }
  });

  // Trigger the change event manually to show today's date on load
  whatdate.dispatchEvent(new Event("change"));
}

// Call the function to set up the event listener
getDate();

getData();
