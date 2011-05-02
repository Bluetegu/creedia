<div id="block-<?php print $block_type .'-'. $block->delta; ?>" class="block block-<?php print $block_type ?>">
    <div class="middle"><div class="top"><div class="bottom"><div class="text">    
        <div class="middle-border">
            <?php if ($block->subject): ?>
              <h2><?php print $block->subject ?></h2>
            <?php endif;?>
            <div class="navi"></div>
                <a class="prev"><?php print $scroll_up; ?></a>
            <div class="content scrollable">
              <?php print $block->content ?>
            </div>
            <a class="next"><?php print $scroll_down; ?></a>
        </div>
    </div></div></div></div>
</div>
