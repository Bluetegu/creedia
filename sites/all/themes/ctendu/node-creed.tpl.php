<div id="node-<?php print $node->nid; ?>"
	class="node-creed node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
	<?php /*firep(get_defined_vars(), 'defined variables tpl ');*/  ?>
	<?php if ($page == 0): ?>
	<?php /* ------------------    page == 0    ------------------ */ ?>
	<div class="node-item">
		<div class="middle">
			<div class="top">
				<div class="bottom">
					<div class="creed-leftbar">
						<div class="creed-leftbar-top">
						<?php if ($religions) { ?>
						<?php foreach ($religions as $religion) { ?>
							<div class="religion">
							<?php print theme('religion', $religion, 'image'); ?>
							</div>
							<?php };?>
							<?php };?>
						</div>
						<div class="creed-leftbar-middle">
						<?php if ($beliefset) { ?>
						<?php $max = $featured ? CREEDIA_MAX_SYMBOLS_IN_BLOCK : CREEDIA_MAX_SYMBOLS_IN_TEASER; ?>
						<?php foreach ($beliefset as $term) { ?>
						<?php if ($i++ == $max) break; ?>
							<div class="beliefset">
							<?php print theme('beliefset', $term); ?>
							</div>
							<?php }; ?>
							<?php };?>
						</div>
						<div class="creed-leftbar-bottom">
							<div class="featured">
							<?php print $featured ?>
							</div>
						</div>
					</div>
					<div class="creed-main">
						<h2 class="title">
							<a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?>
							</a>
						</h2>
						<?php if ($teaser) : ?>
						<div class="origin-statement-wrapper">
						<?php echo theme('origin_statement', $node, TRUE); ?>
						</div>
						<?php else : ?>
						<div class="origin-statement-wrapper">
						<?php echo theme('origin_statement', $node, FALSE); ?>
						</div>
						<div class="body">
						<?php print $node->content['body']['#value']; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="creed-footer">
			<div class="adopt">
			<?php print $adopt ?>
			</div>
			<div class="adopt-text">
			<?php print $adopt_text; ?>
			</div>
			<div class="date-author">
			<?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
				<span><?php print theme('username',$node);?> </span>
			</div>
			<?php print theme('ctwitter_fb_like', $node, TRUE); ?>
			<?php print theme ('google_plusone_button', array('node' => $node, 'css' => 'margin:1px 0px 0px 220px', 'syntax' => 'g:plusone',
        'annotation' => 'bubble', 'size' => 'small')); ?>
		</div>
	</div>
	<?php else: ?>
	<?php /* ------------------    page == 1    ------------------ */ ?>
	<div class="node-full">
		<div class="middle">
			<div class="top">
				<div class="bottom">
					<div class="creed-leftbar">
						<div class="creed-leftbar-top">
						<?php if ($religions) { ?>
						<?php foreach ($religions as $religion) { ?>
							<div class="religion">
							<?php print theme('religion', $religion, 'image'); ?>
							</div>
							<?php };?>
							<?php };?>
						</div>
						<div class="creed-leftbar-middle">
						<?php if ($beliefset) { ?>
						<?php foreach ($beliefset as $term) { ?>
							<div class="beliefset">
							<?php print theme('beliefset', $term); ?>
							</div>
							<?php }; ?>
							<?php };?>
						</div>
						<div class="creed-leftbar-bottom">
							<div class="featured">
							<?php print $featured ?>
							</div>
						</div>
					</div>
					<div class="creed-main">
						<h2 class="title">
							<a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?>
							</a>
						</h2>
						<div class="origin-statement-wrapper">
						<?php echo theme('origin_statement', $node, FALSE); ?>
						</div>
						<div class="body">
						<?php if($node->content['body']['#value']): ?>
							<h4>
								<label><?php print t('Exposition:')?> </label>
							</h4>
							<?php print $node->content['body']['#value'] ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="creed-footer">
			<div class="adopt-text">
			<?php print $adopt_text; ?>
			</div>
			<div class="childnum">
				<a href="#comments"><span> <?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
				</span> </a>
			</div>
			<div class="date-author">
			<?php print t('!date by  ', array('!date' => date("d M Y", $node->changed))); ?>
				<span><?php print theme('username',$node);?> </span>
			</div>
		</div>
		<div class="creed-footer-actions">
			<div class="adopt">
				<label><?php print t('Adopt: '); ?> </label>
				<?php print $adopt ?>
			</div>
			<?php if ($links): ?>
			<div class="links">
			<?php print $links; ?>
			</div>
			<?php endif; ?>
			<div id="social-widgets">
				<div class="google-plusone">
				<?php print theme ('google_plusone_button', array('node' => $node, 'css' => 'float:right', 'syntax' => 'g:plusone',
        'annotation' => 'inline', 'size' => 'medium', 'width' => '180')); ?>
				</div>
				<div class="fb-widget-like">
				<?php print theme ('ctwitter_fb_like_js', $node); ?>
				</div>
			</div>
			<div class="fb-widget-comment">
			<?php print theme ('ctwitter_fb_comments', $node); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
