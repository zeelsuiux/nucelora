<?php
use App\Config\App;
use App\Helpers\Esc;
?>

<div class="page" style="padding:60px 0 100px;">
  <div class="w" style="max-width:760px;">
    <nav style="font-size:13px; color:var(--muted); margin-bottom:24px;">
      <a href="<?= App::baseUrl() ?>">Home</a> &rarr; 
      <span><?= Esc::html($page['title']) ?></span>
    </nav>

    <h1 class="h1" style="font-size:38px; margin-bottom:32px; border-bottom:1px solid var(--line); padding-bottom:16px;">
      <?= Esc::html($page['title']) ?>
    </h1>

    <div class="cms-content" style="font-size:16px; line-height:1.8; color:var(--ink2);">
      <?= $page['content_html'] ?>
    </div>
  </div>
</div>
