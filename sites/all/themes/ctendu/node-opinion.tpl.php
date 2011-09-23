<div id="node-<?php print $node->nid; ?>"
	class="node-opinion node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
	<?php /*firep($node, 'opinion tpl');*/ ?>
	<?php if ($page == 0): ?>
	<?php /* ------------------    page == 0    ------------------ */ ?>
	<div class="node-item">
		<div class="middle">
			<div class="top">
				<div class="bottom">
					<div class="opinion-leftbar">
						<div class="opinion-leftbar-top">
						<?php if ($religions) { ?>
						<?php foreach ($religions as $religion) { ?>
							<div class="religion">
							<?php print theme('religion', $religion, 'image'); ?>
							</div>
							<?php };?>
							<?php };?>
						</div>
						<div class="opinion-leftbar-middle">
						<?php if ($beliefset) { ?>
						<?php foreach ($beliefset as $term) { ?>
							<div class="beliefset">
							<?php print theme('beliefset', $term); ?>
							</div>
							<?php }; ?>
							<?php };?>
						</div>
						<div class="opinion-leftbar-bottom">
							<div class="featured">
							<?php print $featured ?>
							</div>
						</div>
					</div>

					<div class="opinion-main">
						<div class="image">
						<?php echo theme("opinion_image", $node, $page); ?>
						</div>
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

						<div class="opinion-main-footer">
						<?php if ($freetag) { ?>
						<?php foreach ($freetag as $term) { ?>
							<div class="freetag">
							<?php print theme('freetag', $term); ?>
							</div>
							<?php }; ?>
							<?php };?>
							<?php if ($field_creed_reference && $field_creed_reference[0]['nid']) { ?>
							<?php foreach ($field_creed_reference as $ref) { ?>
							<div class="creed-ref">
							<?php print $ref['view']; ?>
							</div>
							<?php }; ?>
							<?php };?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="opinion-footer">
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
				<span><?php print theme('username',$node);?>
				</span>
			</div>
		</div>
	</div>
	<?php else: ?>
	<?php /* ------------------    page == 1    ------------------ */ ?>
	<div class="node-full">
		<div class="middle">
			<div class="top">
				<div class="bottom">
					<div class="opinion-leftbar">
						<div class="opinion-leftbar-top">
						<?php if ($religions) { ?>
						<?php foreach ($religions as $religion) { ?>
							<div class="religion">
							<?php print theme('religion', $religion, 'image'); ?>
							</div>
							<?php };?>
							<?php };?>
						</div>
						<div class="opinion-leftbar-middle">
						<?php if ($beliefset) { ?>
						<?php foreach ($beliefset as $term) { ?>
							<div class="beliefset">
							<?php print theme('beliefset', $term); ?>
							</div>
							<?php }; ?>
							<?php };?>
						</div>
						<div class="opinion-leftbar-bottom">
							<div class="featured">
							<?php print $featured ?>
							</div>
						</div>
					</div>
					<div class="opinion-main">
						<div class="image">
						<?php echo theme("opinion_image", $node, $page); ?>
						</div>
						<h2 class="title">
							<a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?>
							</a>
						</h2>

						<div class="body">
						<?php print $node->content['body']['#value']; ?>
						</div>

						<div class="opinion-main-footer">
						<?php if ($freetag) { ?>
						<?php foreach ($freetag as $term) { ?>
							<div class="freetag">
							<?php print theme('freetag', $term); ?>
							</div>
							<?php }; ?>
							<?php };?>
							<?php if ($field_creed_reference && $field_creed_reference[0]['nid']) { ?>
							<?php foreach ($field_creed_reference as $ref) { ?>
							<div class="creed-ref">
							<?php print $ref['view']; ?>
							</div>
							<?php }; ?>
							<?php };?>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="opinion-footer">
			<div class="vote-text">
			<?php print theme('fivestar_average', $node->nid); ?>
			</div>
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
		<div class="opinion-footer-actions">
			<div class="vote">
				<span><?php print t('Rate: '); ?>
				</span>
				<?php print $node->content['fivestar_widget']['#value'] ?>
			</div>
			<?php if ($links): ?>
			<div class="links">
				<?php print $links; ?>
			</div>
			<?php endif; ?>
			<div class="fb-widget-like">
			<?php print theme ('ctwitter_fb_like_js', $node); ?>
			</div>
			<div class="fb-widget">
			<?php print theme ('ctwitter_fb_comments', $node); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
