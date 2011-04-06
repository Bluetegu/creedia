<div class="field field-type-image field-field-image">
  <div class="field-items">
      <div class="field-item"><?php print $node->field_image[0]['view'] ?></div>
  </div>
</div>
<?php print $node->content['body']['#value'] ?>
<?php print $node->links['node_read_more']['href'] ?>
