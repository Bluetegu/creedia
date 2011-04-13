<div id="node-<?php print $node->nid; ?>" class="node-image-cck node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
  <?php /*firep($node, 'image-cck tpl');*/ ?>
  <?php if ($page == 0): ?>
  <?php /* ------------------    page == 0    ------------------ */ ?>
<div class="node-item">
<div class="middle"><div class="top"><div class="bottom">   
<div class="image-cck-leftbar">
<div class="image-cck-leftbar-top">
  <?php if ($religions) { ?>
  <?php foreach ($religions as $religion) { ?>
<div class="religion">
  <?php print theme('religion', $religion, 'image'); ?>
</div>
<?php };?>
<?php };?>
</div>
<div class="image-cck-leftbar-middle">
  <?php if ($beliefset) { ?>
  <?php foreach ($beliefset as $term) { ?>
<div class="beliefset"><?php print theme('beliefset', $term); ?></div>
<?php }; ?>
<?php };?>
</div>
<div class="image-cck-leftbar-bottom">
<div class="featured"><?php print $featured ?></div>
</div>
</div>
<div class="image-cck-main">
<div class="image">
  <?php echo $picture;  ?>
</div>
<h2 class="title">
<a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a>
</h2>	
<div class="body">
  <?php print $node->content['body']['#value']; ?>
  <?php if ($node->readmore): ?>
<div class="morelink">
  <?php print l('More', 'node/'. $nid, array('title' => t('Read the rest of this posting'))); ?>
</div>
<?php endif; ?>
</div>

<div class="image-cck-main-footer">
  <?php if ($freetag) { ?>
  <ul class="freetags">
    <?php foreach ($freetag as $term) { ?>
    <li class="freetag"><?php print theme('freetag', $term); ?></li>
    <?php }; ?>
  </ul>
  <?php };?>
</div>
</div>


</div></div></div> 

<div class="image-cck-footer">
<div class="vote">
  <?php print $node->content['fivestar_widget']['#value'] ?>
</div>
<div class="vote-text">
  <?php print theme('fivestar_average', $node->nid); ?>
</div>
<div class="childnum">
  <?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
</div>
<div class="date-author">
  <?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
  <span><?php print theme('username',$node);?></span>
</div>
</div>
</div>
<?php else: ?>
<?php /* ------------------    page == 1    ------------------ */ ?>
<div class="node-full">

  <div class="image-cck-main">
    <?php if ($featured): ?>
       <div class="featured"><?php print $featured ?></div>
    <?php endif; ?>
    <?php if ($default_image): ?>
      <div class="default-image"><?php print $default_image ?></div>
    <?php endif; ?>
    <h2 class="title">
    <a href="<?php print $node_url ?>" class="image-title" title="<?php print $title ?>"><?php print $title ?></a>
    </h2>
    <div class="image image-url" name="<?php print $pic_url; ?>">
      <?php echo $picture;  ?>
    </div>
    <div class="body">
      <?php print $node->content['body']['#value']; ?>
    </div>

<div class="image-cck-main-footer">
  <?php if ($religions) { ?>
  <ul class="religions">
    <?php foreach ($religions as $religion) { ?>
    <li class="religion"><?php print theme('religion', $religion, 'image'); ?></li>
    <?php };?>
  </ul>
  <?php };?>
  <?php if ($beliefset) { ?>
  <ul class="beliefsets">
    <?php foreach ($beliefset as $term) { ?>
    <li class="beliefset"><?php print theme('beliefset', $term); ?></li>
    <?php }; ?>
  </ul>
  <?php };?>
  <?php if ($freetag) { ?>
  <ul class="freetags">
    <?php foreach ($freetag as $term) { ?>
    <li class="freetag"><?php print theme('freetag', $term); ?></li>
    <?php }; ?>
  </ul>
  <?php };?>
</div>

</div>

<div class="image-cck-footer">
<div class="vote-text">
  <?php print theme('fivestar_average', $node->nid); ?>
</div>
<div class="childnum">
  <a href="#comments"><span>
  <?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
  </span></a>
</div>
<div class="date-author">
  <?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
  <span><?php print theme('username',$node);?></span>
</div>
</div>
<div class="image-cck-footer-actions">
<div class="vote">
  <span><?php print t('Rate: '); ?></span>
  <?php print $node->content['fivestar_widget']['#value'] ?>
</div>
<?php if ($links): ?>
<div class="links"><?php print $links; ?></div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
</div>

