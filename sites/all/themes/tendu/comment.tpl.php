<div class="comment<?php print ($comment->new) ? ' comment-new' : ''; print ($comment->status == COMMENT_NOT_PUBLISHED) ? ' comment-unpublished' : ''; ?> clear-block">
  <?php if ($comment->new) : ?>
    <span class="comment-new"><?php print $new; ?></span>
  <?php endif; ?>
  <h3><?php print $title ?></h3>
  <?php if ($picture): ?>
    <div class="comment-image">
      <?php print $picture ?>
    </div>
  <?php endif; ?>
  <div class="content">
    <?php print $content ?>
  </div>
  <div class="footer">
    <div class="date-author">
      <?php print t('!date by  ', array('!date' => date("d M Y", $comment->timestamp))); ?>
      <span><?php print $author;?></span>
    </div>
    <div class="links">
      <?php print $links ?>
    </div>
  </div>
<?php /*firep($comment, 'comment');*/ ?>
</div>
