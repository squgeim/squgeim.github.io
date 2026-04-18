<?php
include('./src/utils/blog.php');

$extra_head_links = '<link href="/css/prism.css" type="text/css" rel="stylesheet" />';
include('./src/fragments/header.php');

$blog = Utils\getBlog(file_get_contents($argv[1]));
?>

<h1 class="blog-title"><?=$blog['title']?></h1>

<div class="reading-view">
  <section class="blogs">
    <div class="blog-item">
      <div class="blog-card">
        <div class="blog-card-meta">
          <span class="blog-card-date"><?=$blog['date']->format("j M Y")?></span>
        </div>
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
</div>

<script src="/js/prism.js" defer></script>
<?php include('./src/fragments/footer.php'); ?>
