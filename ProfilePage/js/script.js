var swiper = new Swiper(".slide-container", {
  slidesPerView: 4,
  spaceBetween: 20,
  sliderPerGroup: 4,
  loop: true,
  centerSlide: "true",
  fade: "true",
  grabCursor: "true",
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    520: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 3,
    },
    1000: {
      slidesPerView: 4,
    },
  },
});

function openPopup() {
  document.getElementById('upload-popup').style.display = 'block';
}

function closePopup() {
  document.getElementById('upload-popup').style.display = 'none';
}

function handleProfilePicUpload() {
  const file = document.getElementById('upload-profile-pic').files[0];

  if (file) {
      // Perform the necessary actions to upload the picture here
      // You can display a success message or update the profile picture on the page
      console.log('File uploaded:', file.name);
  } else {
      console.log('No file selected.');
  }

  closePopup();
}
