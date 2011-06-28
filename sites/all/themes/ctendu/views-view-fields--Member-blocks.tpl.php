<div class="node-block">
  <div class="member-leftbar node-block-leftbar">
    <div class="image">
      <?php echo $picture ?>
    </div>
  </div>
  <div class="member-main node-block-main">
    <div class="title">
      <?php print $name ?>
    </div>
     <div class="oneliner">
       <?php print $one_liner; ?>
    </div>
    <div class="body">
      <?php print $body ?>
    </div>
    <?php if ($common) : ?>
    <div class="common">
      <?php print format_plural($common, '1 common way', '@count common ways'); ?>
    </div>
    <?php endif; ?>
  </div>
</div>




