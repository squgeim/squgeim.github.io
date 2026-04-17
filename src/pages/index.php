<?php
include('./src/utils/blog.php');

include('./src/fragments/header.php');

$blogs = Utils\getBlogsList();
?>

  <section class="landing">
    <img class="main-picture" src="./images/shreya_portrait.jpeg" alt="Shreya Dahal Portrait"/>
    <h1 class="hero-name">Shreya Dahal</h1>
    <p class="hero-tagline">
      Full-stack software engineer and open-source software enthusiast
    </p>
    <span class="hero-handle">@squgeim</span>
  </section>

  <div class="blogs-section">
    <h2 class="section-heading">Writing</h2>
    <section id="blogsContainer" class="blogs flex-col">
<?php foreach ($blogs as $blog): ?>
      <div class="blog-item">
        <div class="blog-card<?=$blog['isExternal'] ? ' is-external-link' : ''?> cursor-pointer" data-href="<?=$blog['href']?>" data-is-external="<?=$blog['isExternal']?>">
          <div class="blog-card-inner">
            <div class="blog-card-meta">
              <span class="blog-card-date"><?=$blog['date']->format("M Y")?></span>
            </div>
            <h1><a href="<?=$blog['href']?>"><?=$blog['title']?></a></h1>
            <?php if (!empty($blog['blurb'])): ?>
            <p><?=$blog['blurb']?></p>
            <?php endif; ?>
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
<?php endforeach; ?>
    </section>
  </div>

<script>
  document.querySelectorAll('.blog-card').forEach(elem => {
    const href = elem.dataset.href;
    elem.addEventListener('click', e => {
      if (!href) return;
      document.location.href = href;
    });
  });
</script>

<?php include('./src/fragments/footer.php'); ?>
