<?php
include('./vendor/parsedown/Parsedown.php');
include('./src/utils/blog.php');

include('./src/fragments/header.php');

$Parsedown = new Parsedown();
$blog = Utils\getBlog(file_get_contents($argv[1]));
$blogContent = $Parsedown->text($blog['content']);
?>

<section class="blogs">
  <div class="blog-container">
    <?=$blogContent?>
  </div>
</section>

<?php include('./src/fragments/footer.php'); ?>
