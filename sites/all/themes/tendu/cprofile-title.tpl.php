<div class="cprofile-title-bar">
  <h2 class="cprofile-title">
    <?php print $title; ?>
  </h2>
  <div class="movements pngfix">
    <?php if ($religions) { ?>
      <?php foreach($religions as $rid => $religion) { ?>
	<?php print theme('religion', $religion, 'religion'); ?>
        <?php if ($movements[$rid]) { ?>
          <?php foreach($movements[$rid] as $movement) { ?>
            <span class="movement">
              <?php print theme('movement',$movement, $religion, 'link'); ?>
            </span>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    <?php } ?>
  </div>
</div>

