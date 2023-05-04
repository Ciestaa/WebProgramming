document.addEventListener('DOMContentLoaded', function() {
  // Get all the stars
  const stars = document.querySelectorAll('.rating .star');

  // Add event listeners for hover and click
  stars.forEach((star) => {
    star.addEventListener('mouseover', () => {
      // Highlight the stars up to this one
      const rating = star.getAttribute('data-rating');
      for (let i = 0; i < rating; i++) {
        stars[i].classList.add('active');
      }
    });

    star.addEventListener('mouseout', () => {
      // Remove the highlighting
      stars.forEach((s) => {
        s.classList.remove('active');
      });
    });

    star.addEventListener('click', () => {
      // Set the rating to this star's value
      const rating = star.getAttribute('data-rating');
      alert(`You rated this ${rating} stars.`);
    });
  });
});

// Get the like button element
const likeBtn = document.querySelector('.btn-like');

// Add a click event listener to the like button
likeBtn.addEventListener('click', function() {
  // Toggle the 'liked' class to change the heart icon color
  this.classList.toggle('liked');
});

