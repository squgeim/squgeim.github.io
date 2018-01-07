"use strict";

;(function () {

  var blogsUl = document.querySelector('#blogsContainer');

  if (!blogsUl) {
    return;
  }

  function createPublishedDateDiv(publishedDate) {
    if (isNaN(Date.parse(publishedDate))) {
      throw new Error('Invalid Date');
    }

    var dateObj = new Date(publishedDate);

    var date = dateObj.getDate();
    var month = [
      'jan', 'feb', 'mar',
      'apr', 'may', 'jun',
      'jul', 'aug', 'sep',
      'oct', 'nov', 'dec',
    ][dateObj.getMonth()];
    var year = dateObj.getFullYear();

    var div = document.createElement('div');
    div.className = 'published-date';

    var dateSpan = document.createElement('span');
    dateSpan.className = 'date';
    dateSpan.textContent = date;

    var monthSpan = document.createElement('span');
    monthSpan.className = 'month';
    monthSpan.textContent = month;

    var yearSpan = document.createElement('span');
    yearSpan.className = 'year';
    yearSpan.textContent = year;

    div.appendChild(dateSpan);
    div.appendChild(monthSpan);
    div.appendChild(yearSpan);

    return div;
  }

  function createBlogDiv(blog) {
    var div = document.createElement('div');
    div.className = 'blog';

    var publishedDate = createPublishedDateDiv(blog.publishedDate);

    var contentDiv = document.createElement('div');
    contentDiv.className='blog-content';

    var title = (function () {
      var h1 = document.createElement('h1');
      var titleLink = document.createElement('a');
      titleLink.href = blog.url;
      titleLink.target = '_blank';
      titleLink.textContent = blog.title;
      h1.appendChild(titleLink);

      return h1;
    })();

    var blurb = (function () {
      const blurbDiv = document.createElement('div');

      var p = document.createElement('p');
      p.textContent = blog.blurb;

      var readMore = document.createElement('a');
      readMore.href = blog.url;
      readMore.target = '_blank';
      readMore.textContent = 'Continue Reading';

      blurbDiv.appendChild(p);
      blurbDiv.appendChild(readMore);

      return blurbDiv;
    })();

    contentDiv.appendChild(title);
    contentDiv.appendChild(blurb);

    div.appendChild(publishedDate);
    div.appendChild(contentDiv);

    return div;
  }

  window.utils.fetchBlogs(function (error, blogs) {
    if (error) {
      console.error(error);
      return;
    }

    var sortedBlogs = blogs.sort(function (a, b) {
      return a.publishedDate < b.publishedDate;
    });

    var blogLis = sortedBlogs.map(function (blog) {
      var li = document.createElement('li');
      li.appendChild(createBlogDiv(blog));

      return li;
    });

    var frag = document.createDocumentFragment();
    blogLis.forEach(function (li) {
      frag.appendChild(li);
    });

    blogsUl.appendChild(frag);
  });  

})();
