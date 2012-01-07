<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<div class="node-block">
  <div class="creed-leftbar node-block-leftbar">
    <div class="creed-leftbar-top">
      <div class="terms-religion"><?php print $religion[rand(0,count($religion)-1)]; ?></div>
    </div>
    <div class="creed-leftbar-middle">
      <?php if ($beliefset[0]) { ?>
      <?php $i = 0;?>
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
  </div>
</div>
