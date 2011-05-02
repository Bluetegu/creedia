<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block_type ?>">
<?php if ($block->subject): ?>
<div class="collapse-handle"></div><h2><?php print $block->subject; ?></h2>
<?php endif;?>

  <div class="content"><?php print $block->content ?></div>
</div>
