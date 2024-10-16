/* Filename: enhancement.js
   Purpose : enhancemnet for enhacnement.html 
   Target html: enhancemnet.html
   Author:Taniksha Dabral
   Date written: 19/09/2024
   revise :24/09/2024
*/

'use strict'; // Make sure strict mode's on for better error handling

// Timer function
let timeLeft = 10; // Kick off the countdown from 10 seconds
const timerElement = document.getElementById('timer'); // Grab the timer element

const countdown = setInterval(() => {
    if (timeLeft > 0) {
        timeLeft--; // Knock the time down by 1 every second
        timerElement.textContent = `Timer: ${timeLeft}`; // Update the timer display
    } else {
        clearInterval(countdown); // Stop the timer when it hits 0
        timerElement.textContent = "Time's up, mate!"; // Show time's up message
    }
}, 1000); // The countdown interval is set to 1000ms or 1 second

let currentSlide = 0;

function changeSlide(direction) {
    const slides = document.querySelector('.slides');
    const totalSlides = slides.children.length;

    currentSlide += direction;

    if (currentSlide < 0) {
        currentSlide = totalSlides - 1; // Loop back to the last slide
    } else if (currentSlide >= totalSlides) {
        currentSlide = 0; // Loop back to the first slide
    }

    const offset = -currentSlide * 100; // Move to the current slide
    slides.style.transform = `translateX(${offset}%)`;
}

// Function to add event listeners
function initEventListeners() {
    document.getElementById('darkModeButton').addEventListener('click', toggleDarkMode);
    document.querySelector('.prev').addEventListener('click', () => changeSlide(-1));
    document.querySelector('.next').addEventListener('click', () => changeSlide(1));
}

// Run the function when the DOM content is loaded
document.addEventListener('DOMContentLoaded', initEventListeners);


// Dark Mode/White Mode toggle function
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
    const navBar = document.querySelector('.NavBar');
    const footer = document.getElementById("footer");

    navBar.classList.toggle("dark-mode"); // Toggle the navbar
    footer.classList.toggle("dark-mode"); // Toggle the footer

    const button = document.getElementById("darkModeButton");
    button.classList.toggle("dark-mode"); // Toggle the button
}
