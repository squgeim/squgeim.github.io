<?php
include('./src/utils/blog.php');

include('./src/fragments/header.php');

$blog = Utils\getBlog(file_get_contents($argv[1]));
?>

<a class="back-button" href="/" id="backBtn"></a>

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
        <?=$blog['content']?>
      <?php if (count($blog['tags']) > 0 || $blog['isExternal']): ?>
        <ul class="tags">
          <?php if ($blog['isExternal']): ?>
            <li class="tag-external"><?=$blog['externalSite']?><i class="icon-link-ext"></i></li>
          <?php endif; ?>
          <?php foreach($blog['tags'] as $tag): ?>
            <li><?=$tag?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  document.querySelector('#backBtn').addEventListener('click', e => {
    if (document.referrer.includes(location.host)) {
      e.preventDefault();

      return history.back();
    }
  });
</script>

<?php include('./src/fragments/footer.php'); ?>
