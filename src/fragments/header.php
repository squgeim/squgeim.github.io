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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@300;400&display=swap" rel="stylesheet" type="text/css">
  <link href="/css/fontello.css" type="text/css" rel="stylesheet" />
  <link href="/css/style.css" type="text/css" rel="stylesheet" />
  <?php if (isset($extra_head_links)) echo $extra_head_links . "\n"; ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129163239-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-129163239-1');
  </script>
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
          // Registration was successful
          console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
          // registration failed :(
          console.log('ServiceWorker registration failed: ', err);
        });
      });
    }
  </script>
</head>

<body>
<nav class="site-nav">
  <a class="nav-name" href="/">squgeim</a>
  <div class="nav-links">
    <a href="mailto:shreyadahal@gmail.com" title="Email"><i class="icon-mail"></i></a>
    <a href="https://github.com/squgeim" title="GitHub" target="_blank" rel="noopener"><i class="icon-github"></i></a>
    <a href="https://www.linkedin.com/in/squgeim/" title="LinkedIn" target="_blank" rel="noopener"><i class="icon-linkedin"></i></a>
    <a href="https://stackoverflow.com/users/1654226/squgeim?tab=profile" title="Stack Overflow" target="_blank" rel="noopener"><i class="icon-stackoverflow"></i></a>
  </div>
</nav>
