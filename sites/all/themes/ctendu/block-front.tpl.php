<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block_type ?>">
<?php if ($block->subject): ?>
<div class="block-subject"><h2><?php print $block->subject; ?></h2>
<?php if ($featured): ?>
<span class="featured pngfix"><?php print theme('imagecache', 'featured', path_to_theme() . '/images/featured-transparent.png'); ?></span>
<?php endif;?>
</div>
<?php endif;?>
  <div class="content"><?php print $block->content ?></div>
</div>
