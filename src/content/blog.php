<?php
include('./vendor/parsedown/Parsedown.php');
include('./src/utils/blog.php');

include('./src/fragments/header.php');

$Parsedown = new Parsedown();
$blog = Utils\getBlog(file_get_contents($argv[1]));
$blogContent = $Parsedown->text($blog['content']);
?>

<h1 class="blog-title"><?=$blog['title']?></h1>
<section class="blogs reading-view">
  <div class="blog-item">
    <div class="dateline">
      <span class="date-day">
        <?=$blog['date']->format("j")?>
      </span>
      <span class="date-month">
        <?=$blog['date']->format("M")?>
      </span>
      <span class="date-year">
        <?=$blog['date']->format("Y")?>
      </span>
    </div>
    <div class="blog-card">
      <div>
        <?=$blogContent?>
      </div>
    </div>
  </div>
</section>

<?php include('./src/fragments/footer.php'); ?>
