<div id="cid-<?php print $data->nid ?>" class="creed-panel creed-panel-<?php print $data->nid; ?>">
  <?php if ($new): ?>
      <span class="marker">new</span>
  <?php endif; ?>
  <div class="entry-wrapper">      
      <div class="cprofile-entry-tags">
        <?php if ($religion) { ?>
          <?php foreach ($religion as $term) { ?>
            <?php if (in_array($term->tid, $en_religion)): ?>
              <div class="terms terms-religion terms-enabled" id="term-<?php print $data->nid . '-'. $term->tid; ?>">
		<?php print theme('religion', $term, 'image'); ?>
	      </div>
            <?php else: ?>
              <div class="terms terms-religion terms-disabled" id="term-<?php print $data->nid . '-'. $term->tid; ?>">
		<?php print theme('religion', $term, 'image'); ?>
	      </div>
            <?php endif; ?>
          <?php }; ?>
        <?php };?>
        <?php if ($beliefset) { ?>
          <?php foreach ($beliefset as $term) { ?>
            <div class="terms terms-beliefset"><?php print theme('beliefset', $term); ?></div>
          <?php }; ?>
        <?php };?>
        <?php if ($form_terms): ?>
          <div class="ajax-terms" style="display:none">
            <?php print $form_terms ?>
          </div>
	<?php endif; ?>
      </div>
      <div class="cprofile-entry-main">
        <h2 class="title">
          <?php print l($data->title, 'node/'. $data->nid); ?>
        </h2>
        <div class="origin-statement-wrapper">
          <?php print $statement; ?>
        </div>
        <?php if ($form_os): ?>
          <div class="ajax-os" style="display:none">
            <?php print $form_os ?>
          </div>
	<?php endif; ?>
      </div>
  </div>
  <div class="creed-footer">
    <div class="adopt">
       <?php print $adopt ?>
    </div>
    <div class="footer-close">
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
