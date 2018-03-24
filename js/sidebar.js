"use strict";

(function () {
  var menu = document.getElementById('titleMenu');
  var wrapper = document.getElementsByClassName('wrapper')[0];
  var right = document.getElementsByClassName('right')[0];

  var lastScrollPosition = 0;

  menu.addEventListener('click', function (e) {
    var currentScrollPosition = window.scrollY;
    var wasSidebarHidden = wrapper.classList.toggle('opensidebar');

    if (!wasSidebarHidden) {
      window.scrollTo(0, lastScrollPosition); 
      right.style.top = 0;
    } else {
      right.style.top = '-' + currentScrollPosition + 'px';
      lastScrollPosition = currentScrollPosition;
    }
  });
})();
