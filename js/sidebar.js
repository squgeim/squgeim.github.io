"use strict";

(function () {
  var menu = document.getElementById('titleMenu');
  var wrapper = document.getElementsByClassName('wrapper')[0];

  menu.addEventListener('click', function (e) {
    wrapper.classList.toggle('opensidebar');
  });

})();
