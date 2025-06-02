/*!
* Start Bootstrap - Shop Homepage v5.0.6 (https://startbootstrap.com/template/shop-homepage)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

function updateCarousel() {
  carouselItems.forEach((item, index) => {
    item.classList.remove('active');
    if (index === currentSlide) {
      item.classList.add('active');
    }
  });
}

function nextSlideAuto() {
  currentSlide++;
  if (currentSlide >= carouselItems.length) {
    currentSlide = 0;
  }
  updateCarousel();
}

intervalId = setInterval(nextSlideAuto, 7000);

if (prevSlide) {
  prevSlide.addEventListener('click', () => {
    clearInterval(intervalId);
    currentSlide--;
    if (currentSlide < 0) {
      currentSlide = carouselItems.length - 1;
    }
    updateCarousel();
    intervalId = setInterval(nextSlideAuto, 7000);
  });
}

if (nextSlide) {
  nextSlide.addEventListener('click', () => {
    clearInterval(intervalId);
    currentSlide++;
    if (currentSlide >= carouselItems.length) {
      currentSlide = 0;
    }
    updateCarousel();
    intervalId = setInterval(nextSlideAuto, 7000);
  });
}