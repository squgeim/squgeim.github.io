<?php
include('./src/utils/blog.php');

include('./src/fragments/header.php');

$blogs = Utils\getBlogsList();
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

  <section id="blogsContainer" class="blogs flex-col">
<?php foreach ($blogs as $blog): ?>
    <div class="blog-item">
      <div class="dateline">
        <span class="date-day"><?=$blog['date']->format("j")?></span>
        <span class="date-month"><?=$blog['date']->format("M")?></span>
        <span class="date-year"><?=$blog['date']->format("Y")?></span>
      </div>
      <div class="blog-card">
        <div>
          <a href="<?='/blogs/' . $blog['filename']?>">
            <h1><?=$blog['title']?></h1>
          </a>
          <p><?=$blog['blurb']?></p>
        </div>
      </div>
    </div>
<?php endforeach; ?>
  </section>

<?php include('./src/fragments/footer.php'); ?>
