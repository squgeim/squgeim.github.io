<?php
include('./src/utils/blog.php');
include('./src/fragments/header.php');
?>

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
  $filesInDir = scandir('./src/content');

  foreach ($filesInDir as $filename) {
    if (substr($filename, -3) != '.md') {
      continue;
    }

    $blog = Utils\getBlog(file_get_contents('./src/content/' . $filename));

    $url = substr($filename, 0, strrpos($filename, '.', -1)) . '.html';

    printf('
      <div class="blog-item">
        <div class="dateline">
          <span class="date-day">%s</span>
          <span class="date-month">%s</span>
          <span class="date-year">%s</span>
        </div>
        <div class="blog-card">
          <div>
            <a href="%s">
              <h1>%s</h1>
              <p>%s</p>
            </a>
          </div>
        </div>
      </div>',
      $blog['date']->format("j"),
      $blog['date']->format("M"),
      $blog['date']->format("Y"),
      '/blogs/' . $url,
      $blog['title'],
      $blog['blurb']
    );
  }
?>
  </section>

<?php include('./src/fragments/footer.php'); ?>
