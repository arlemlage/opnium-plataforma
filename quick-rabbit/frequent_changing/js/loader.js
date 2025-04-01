$(function () {
  "use strict";
  let preloader = document.getElementById("preloader");

  if (preloader) {
    window.addEventListener("load", function () {
      let fadeOut = setInterval(function () {
        if (!preloader.style.opacity) {
          preloader.style.opacity = 1;
        }
        if (preloader.style.opacity > 0) {
          preloader.style.opacity -= 0.1;
        } else {
          clearInterval(fadeOut);
          preloader.remove();
        }
      }, 50);
    });
  }
});
