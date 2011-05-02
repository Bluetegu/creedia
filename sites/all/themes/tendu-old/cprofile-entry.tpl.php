<div id="cid-<?php print $data->nid ?>" class="creed-panel creed-panel-<?php print $data->nid; ?>">
  <?php if ($new): ?>
      <span class="marker">new</span>
  <?php endif; ?>
  <div class="entry-wrapper">      
      <div class="cprofile-entry-tags">
        <?php if ($religion) { ?>
          <?php foreach ($religion as $term) { ?>
	    <?php if ($i++ >= CREEDIA_MAX_SYMBOLS_IN_PROFILE) break; ?>
            <div class="terms terms-religion"><?php print theme('religion', $term, 'image'); ?></div>
          <?php }; ?>
        <?php };?>
        <?php if ($beliefset) { ?>
          <?php foreach ($beliefset as $term) { ?>
	    <?php if ($i++ >= CREEDIA_MAX_SYMBOLS_IN_PROFILE) break; ?>
            <div class="terms terms-beliefset"><?php print theme('beliefset', $term); ?></div>
          <?php }; ?>
        <?php };?>
      </div>
      <div class="cprofile-entry-main">
        <h2 class="title">
          <?php print l($data->title, 'node/'. $data->nid); ?>
        </h2>
        <div class="origin-statement-wrapper">
          <?php print theme('origin_statement', $node, TRUE); ?>
      </div>
      </div>
  </div>
  <div class="creed-footer">
    <div class="adopt">
       <?php print $adopt ?>
    </div>
    <div class="close">
       <?php print $close ?>
    </div>
  </div>
  <input type="hidden" name="<?php print $i; ?>" value="<?php print $data->nid; ?>"/>
  <?php if ($interpretation_num) : ?>
    <div class="interpretation-wrapper" style="display: none">
      <h3><?php print t('My Interpretations (!number)', array('!number' => $interpretation_num)); ?></h3>
      <?php print $interpretations; ?>
      </div>
    <?php endif; ?>
</div>
