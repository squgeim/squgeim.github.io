"use strict";

;(function () {

  function request(method, url, cb) {
    var xhr = new XMLHttpRequest();
    xhr.addEventListener('readystatechange', function() {
      if (xhr.readyState === xhr.DONE) {
        if (xhr.status > 299) {
          cb(xhr);
        }

        cb(null, xhr);
      }
    });
    xhr.open(method, url);
    xhr.send();
  }

  function parseJSON(jsonStr) {
    try {
      return JSON.parse(jsonStr);
    } catch (err) {
      console.error(err);
      return undefined;
    }
  }

  function fetchBlogs(cb) {
    request('GET', './content/blog.json', function (error, xhr) {
      if (error) {
        cb(obj);
        return;
      }

      var content = xhr.response;
      var obj = parseJSON(content);
      cb(null, obj);
    });
  }

  window.utils = {
    fetchBlogs: fetchBlogs,
  };
})();
