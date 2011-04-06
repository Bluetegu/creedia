<div class="field field-type-image field-creed-image"><?php print theme('image', CREEDIA_CREEDIMAGE_DIRECTORY .'/'. $node->nid .'-00.png');?></div>
<div class="field field-type-text field-field-origin-statement">
  <div class="field-items">
    <?php foreach ((array)$node->field_origin_statement as $item) { ?>
      <div class="field-item"><?php print $item['view'] ?></div>

    <?php } ?>
  </div>
</div>
<?php print $node->content['body']['#value'] ?>
<?php print $node->links['node_read_more']['href'] ?>
