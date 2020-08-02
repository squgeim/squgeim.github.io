import {render, html} from 'https://unpkg.com/uhtml?module';

function getMonthString(month) {
  try {
    return [
      "jan", "feb", "mar", "apr", "may", "jun",
      "jul", "aug", "sep", "oct", "nov", "dec",
    ][month];
  } catch (err) {
    if (err instanceof RangeError) {
      return "";
    }
  }
}

function BlogCard(blog) {
  const title = blog.title;
  const date = new Date(blog.publishedDate);
  const url = blog.url;
  const blurb = blog.blurb;
  const type = blog.type;

  return html`
    <div class="blog-item">
      <div class="dateline">
        <span class="date-day">${date.getDate()}</span>
        <span class="date-month">${getMonthString(date.getMonth())}</span>
        <span class="date-year">${date.getFullYear()}</span>
      </div>
      <div class="blog-card">
        <a href="${url}">
          <h1>${title}</h1>
          <p>${blurb}</p>
        </a>
      </div>
    </div>
  `;
}

const blogsContainer = document.querySelector('#blogsContainer');

fetch("./content/blog.json")
  .then(response => response.json())
  .then(blogs => {
    render(
      blogsContainer,
      html`${blogs.map(blog => BlogCard(blog))}`
    );
  })
  .catch(err => {
    console.error(err);

    render(blogsContainer, html`
      <p>Sorry! Something unexpected happened. Please try refreshing the page.</p>
    `)
  });
