<div id="block-<?php print $block_type .'-'. $block->delta; ?>" class="block block-<?php print $block_type ?>">
<?php if ($block->subject): ?>
<h2><?php print $block->subject; ?></h2>
<?php endif;?>

  <div class="content"><?php print $block->content ?></div>
</div>
