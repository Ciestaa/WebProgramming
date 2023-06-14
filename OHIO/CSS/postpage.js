document.addEventListener('DOMContentLoaded', function() {
  var stars = document.querySelectorAll('.star');
  var ratingValue = document.getElementById('rating-value');
  var postID = document.getElementById('post-id').value;

  function highlightStars(rating) {
    stars.forEach(function(star, index) {
      star.classList.toggle('active', index < rating);
    });
  }

  function setRating(rating) {
    ratingValue.value = rating;
    highlightStars(rating);
  }

  stars.forEach(function(star) {
    star.addEventListener('mouseover', function() {
      var rating = parseInt(star.getAttribute('data-rating'));
      highlightStars(rating);
    });

    star.addEventListener('mouseout', function() {
      var rating = parseInt(ratingValue.value);
      highlightStars(rating);
    });

    star.addEventListener('click', function() {
      var rating = parseInt(star.getAttribute('data-rating'));
      setRating(rating);
      alert(`You rated this ${rating} stars.`);

      // Send AJAX request to update the rating in the database
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'viewpost_user.php'); // Modify the URL to the appropriate endpoint
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          console.log(xhr.responseText);
          // Handle the success response here
        } else {
          console.error('Error updating rating: ' + xhr.statusText);
          // Handle the error response here
        }
      };
      var params = 'rating=' + encodeURIComponent(ratingValue.value) + '&post_id=' + encodeURIComponent(postID);
      xhr.send(params);
    });
  });
});