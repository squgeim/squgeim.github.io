<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>squgeim's blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#FFFFFF">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="theme-color" content="#ffffff">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400&family=Lato&family=Montserrat&family=Raleway:wght@600&display=swap" rel="stylesheet" type="text/css">
  <link href="./css/fontello.css" type="text/css" rel="stylesheet" />
  <link href="./css/style.css" type="text/css" rel="stylesheet" />
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129163239-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-129163239-1');
  </script>
</head>
<body>
  <section class="landing">
    <img class="main-picture" src="./images/shreya_portrait.jpeg"  alt="Shreya Dahal Portrait"/>
    <p class="hero-text">
      full-stack software engineer
      <br /> and open-source software enthusiast
    </p>
    <h1 class="name">Shreya Dahal</h1>
    <span class="handle">@squgeim</span>
  </section>
  <section id="blogsContainer" class="blogs">

<?php
$blogFile = file_get_contents('./src/content/blog.json');
$blogs = json_decode($blogFile);

foreach ($blogs as $blog) {
  $blogDate = new DateTime($blog->publishedDate);

  print("
    <div class=\"blog-item\">
      <div class=\"dateline\">
        <span class=\"date-day\">" . $blogDate->format("j") . "</span>
        <span class=\"date-month\">" . $blogDate->format("M") . "</span>
        <span class=\"date-year\">" . $blogDate->format("Y") . "</span>
      </div>
      <div class=\"blog-card\">
        <a href=\"$blog->url\">
          <h1>$blog->title</h1>
          <p>$blog->blurb</p>
        </a>
      </div>
    </div>");
}
?>

  </section>
  <section class="footer">
    <ul>
      <li><a href="mailto:shreyadahal@gmail.com"><i class="icon-mail"></i> shreyadahal@gmail.com</a></li>
      <li><a href="https://github.com/squgeim"><i class="icon-github"></i> github</a></li>
      <li><a href="https://www.linkedin.com/in/squgeim/"><i class="icon-linkedin"></i> linkedIn</a></li>
      <li><a href="https://stackoverflow.com/users/1654226/squgeim?tab=profile"><i class="icon-stackoverflow"></i> stack overflow</a></li>
    </ul>
    <p class="copyright">&copy; Shreya Dahal, MMXX. All rights reserved.</p>
  </section>
</body>
</html>