<div id="node-<?php print $node->nid; ?>"
	class="node-simplenews node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
	<?php /*firep(get_defined_vars(), 'defined variables tpl ');*/  ?>
	<?php if ($page == 0): ?>
	<?php /* ------------------    page == 0    ------------------ */ ?>
	<div class="node-item">
		<div class="simplenews-main">
		<?php echo $picture; ?>
			<h2 class="title">
				<a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?>
				</a>
			</h2>
			<div class="body">
			<?php print $node->content['body']['#value']; ?>
			<?php if ($node->readmore): ?>
				<div class="morelink">
				<?php print l('More', 'node/'. $nid, array('title' => t('Read the rest of this posting'))); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="simplenews-footer">
			<div class="childnum">
			<?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
			</div>
			<div class="date-author">
			<?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
				<span><?php print theme('username',$node);?>
				</span>
			</div>
		</div>
	</div>
	<?php else: ?>
	<?php /* ------------------    page == 1    ------------------ */ ?>
	<div class="node-full">
		<div class="simplenews-main">
		<?php echo $picture; ?>
			<h2 class="title">
				<a href="<?php print $node_url ?>" class="simplenews-title"
					title="<?php print $title ?>"><?php print $title ?>
				</a>
			</h2>
			<div class="body">
			<?php print $node->content['body']['#value']; ?>
			</div>
		</div>
		<div class="simplenews-footer">
			<div class="childnum">
				<a href="#comments"><span> <?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
				</span>
				</a>
			</div>
			<div class="date-author">
			<?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
				<span><?php print theme('username',$node);?>
				</span>
			</div>
		</div>
		<div class="simplenews-footer-actions">
		<?php if ($links): ?>
			<div class="links">
				<?php print $links; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
</div>

