const link = document.querySelector('.calendar-section a');

// Start animation on page load
window.addEventListener('load', () => {
  link.classList.add('animate-hover');
});

// Stop animation when clicked
link.addEventListener('click', () => {
  link.classList.remove('animate-hover');
  link.classList.add('hover-effect'); // keep final hover state if you want
});