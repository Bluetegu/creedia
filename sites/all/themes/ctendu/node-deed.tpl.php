<div id="node-<?php print $node->nid; ?>"
	class="node-deed node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
	<?php /*firep(get_defined_vars(), 'defined variables tpl ');*/ ?>
	<?php if ($page == 0): ?>
	<?php /* ------------------    page == 0    ------------------ */ ?>
	<div class="node-item">
		<div class="deed-main">
			<h2 class="deed-when">
			<?php print $field_when[0]['view']; ?>
			</h2>
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
			<div class="deed-main-footer">
			<?php if ($field_creed_reference && $field_creed_reference[0]['nid']) { ?>
			<?php foreach ($field_creed_reference as $ref) { ?>
				<div class="creed-ref">
				<?php print $ref['view']; ?>
				</div>
				<?php }; ?>
				<div>&nbsp</div>
				<?php };?>
				<?php if ($featured) { ?>
				<div class="featured">
				<?php print $featured ?>
				</div>
				<?php };?>
				<?php if ($countries) { ?>
				<?php foreach ($countries as $term) { ?>
				<div class="country">
				<?php print theme('term', $term); ?>
				</div>
				<?php }; ?>
				<?php };?>
				<?php if ($religions) { ?>
				<?php foreach ($religions as $religion) { ?>
				<div class="religion">
				<?php print theme('religion', $religion, 'image'); ?>
				</div>
				<?php };?>
				<?php };?>
				<?php if ($beliefset) { ?>
				<?php foreach ($beliefset as $term) { ?>
				<div class="beliefset">
				<?php print theme('beliefset', $term); ?>
				</div>
				<?php }; ?>
				<?php };?>
				<?php if ($freetag) { ?>
				<?php foreach ($freetag as $term) { ?>
				<div class="freetag">
				<?php print theme('freetag', $term); ?>
				</div>
				<?php }; ?>
				<?php };?>
			</div>
		</div>
		<div class="deed-footer">
			<div class="childnum">
			<?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
			</div>
			<div class="date-author">
			<?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
				<span><?php print theme('username',$node);?> </span>
			</div>
		</div>
	</div>
	<?php else: ?>
	<?php /* ------------------    page == 1    ------------------ */ ?>
	<div class="node-full">
		<div class="deed-main">
			<h2 class="deed-when">
			<?php print $field_when[0]['view']; ?>
			</h2>
			<h2 class="title">
				<a href="<?php print $node_url ?>" class="deed-title"
					title="<?php print $title ?>"><?php print $title ?> </a>
			</h2>
			<div class="body">
			<?php print $node->content['body']['#value']; ?>
			</div>
			<div class="deed-main-footer">
			<?php if ($field_creed_reference && $field_creed_reference[0]['nid']) { ?>
			<?php foreach ($field_creed_reference as $ref) { ?>
				<div class="creed-ref">
				<?php print $ref['view']; ?>
				</div>
				<?php }; ?>
				<div>&nbsp</div>
				<?php };?>
				<?php if ($featured) { ?>
				<div class="featured">
				<?php print $featured ?>
				</div>
				<?php };?>
				<?php if ($countries) { ?>
				<?php foreach ($countries as $term) { ?>
				<div class="country">
				<?php print theme('term', $term); ?>
				</div>
				<?php }; ?>
				<?php };?>
				<?php if ($religions) { ?>
				<?php foreach ($religions as $religion) { ?>
				<div class="religion">
				<?php print theme('religion', $religion, 'image'); ?>
				</div>
				<?php };?>
				<?php };?>
				<?php if ($beliefset) { ?>
				<?php foreach ($beliefset as $term) { ?>
				<div class="beliefset">
				<?php print theme('beliefset', $term); ?>
				</div>
				<?php }; ?>
				<?php };?>
				<?php if ($freetag) { ?>
				<?php foreach ($freetag as $term) { ?>
				<div class="freetag">
				<?php print theme('freetag', $term); ?>
				</div>
				<?php }; ?>
				<?php };?>
			</div>
		</div>
		<div class="deed-footer">
			<div class="childnum">
				<a href="#comments"><span> <?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
				</span> </a>
			</div>
			<div class="date-author">
			<?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
				<span><?php print theme('username',$node);?> </span>
			</div>
		</div>
		<div class="deed-footer-actions">
		<?php if ($links): ?>
			<div class="links">
			<?php print $links; ?>
			</div>
			<?php endif; ?>
			<div class="fb-widget">
			<?php print theme('ctwitter_fb_like', $node); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
