<?php if($node->field_opinion_image[0]['view']): ?>
<div class="field field-type-image field-field-opinion-image">
  <div class="field-items">
      <div class="field-item"><?php print $node->field_opinion_image[0]['view'] ?></div>
  </div>
</div>
<?php endif; ?>
<?php if($node->field_opinion_em_picture[0]['view']): ?>
<div class="field field-type-image-ncck field-field-opinion-em-picture">
  <div class="field-items">
      <div class="field-item"><?php print $node->field_opinion_em_picture[0]['view'] ?></div>
  </div>
</div>
<?php endif; ?>
<?php if($node->field_opinion_em_video[0]['view']): ?>
<div class="field field-type-video-cck field-field-opinion-em-video">
  <div class="field-items">
      <div class="field-item"><?php print $node->field_opinion_em_video[0]['view'] ?></div>
  </div>
</div>
<?php endif; ?>
<?php if($node->field_opinion_em_audio[0]['view']): ?>
<div class="field field-type-emaudio field-field-opinion-em-audio">
  <div class="field-items">
      <div class="field-item"><?php print $node->field_opinion_em_audio[0]['view'] ?></div>
  </div>
</div>
<?php endif; ?>
<?php print $node->content['body']['#value'] ?>
<?php print $node->content['relativity_parents']['#value']; ?>
<?php print $node->links['node_read_more']['href'] ?>
