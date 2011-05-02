<div class="node-block">
  <div class="creed-leftbar node-block-leftbar">
    <div class="creed-leftbar-top">
      <div class="terms-religion"><?php print $religion[rand(0,count($religion)-1)]; ?></div>
    </div>
    <div class="creed-leftbar-middle">
      <?php if ($beliefset[0]) { ?>
      <?php foreach ($beliefset as $term) { ?>
        <?php if ($i++ == CREEDIA_MAX_SYMBOLS_IN_BLOCK) break; ?>
        <div class="terms-beliefset"><?php print $term;?></div>
      <?php }; ?>
    <?php };?>
  </div>
  </div>
  <div class="creed-main node-block-main">
    <div class="title">
      <?php print $title;?>
    </div>
    <div class="origin_statement_container">
      <?php print $statement;?>
    </div>
  </div>
</div>




