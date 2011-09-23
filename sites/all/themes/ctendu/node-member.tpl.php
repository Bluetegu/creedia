<div id="node-<?php print $node->nid; ?>"
	class="node-member node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
	<?php /*firep(get_defined_vars(), 'defined variables member tpl '); */ ?>
	<?php if ($page == 0): ?>
	<?php /* ------------------    page == 0    ------------------ */ ?>
	<div class="node-item">
		<div class="middle">
			<div class="top">
				<div class="bottom">
					<div class="member-leftbar">
						<div class="member-leftbar-top">
						<?php if ($religions) { ?>
						<?php foreach ($religions as $religion) { ?>
							<div class="religion">
							<?php print theme('religion', $religion, 'image'); ?>
							</div>
							<?php };?>
							<?php };?>
						</div>
						<div class="member-leftbar-bottom">
							<div class="featured">
							<?php print $featured ?>
							</div>
						</div>
					</div>
					<div class="member-main">
						<div class="member-main-top">
							<div class="image">
							<?php echo $picture; ?>
							</div>
							<h2 class="title">
							<?php print theme('truncated_user', $field_full_name[0]['value'], $title, $uid, 60); ?>
							</h2>
							<blockquote class="oneliner">
							<?php print $oneliner; ?>
							</blockquote>
						</div>
						<div class="body">
						<?php print $node->content['body']['#value']; ?>
						<?php if ($node->readmore): ?>
							<div class="morelink">
							<?php print l('More', 'user/'. $node->uid .'/about', array('title' => t('Read the rest of the biography'))); ?>
							</div>
							<?php endif; ?>
						</div>
						<div class="member-main-footer">
							<div class="movements">
							<?php if ($religions) { ?>
							<?php foreach($religions as $rid => $religion) { ?>
							<?php if ($movements[$rid]) { ?>
							<?php foreach($movements[$rid] as $movement) { ?>
								<div class="movement">
								<?php print theme('movement', $religions[$rid], $movement, 'breadcrumb'); ?>
								</div>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="member-footer">
			<div class="childnum">
			<?php print t('Comments: !num', array('!num' => $node->comment_count ? $node->comment_count : '0')); ?>
			</div>
			<?php if (isset($common) && $common !== NULL): ?>
			<div class="common" title="<?php print t('Common ways'); ?>">
			<?php print t('Common: !num', array('!num' => $common ? $common : '0')); ?>
			</div>
			<?php endif; ?>
			<div class="joined">
			<?php print t('Joined: !date', array('!date' => date("d M Y", $node->created))); ?>
			</div>
		</div>
	</div>
	<?php else : ?>
	<?php /* ------------------    page == 1    ------------------ */ ?>
	<?php if ($teaser == 0){ ?>
	<?php /* -----------------    teaser == 0  ----------------- */ ?>
	<div class="node-full node-full-no-teaser">
		<div class="member-main-full">
			<div class="member-image">
			<?php echo $picture; ?>
			</div>
			<div class="member-main">
				<div class="about">
					<table>
						<tr class="fullname">
							<td class="label"><?php print $fullname_label; ?>
							</td>
							<td><?php print $fullname ? $fullname : print $empty; ?>
							</td>
						</tr>
						<tr class="username">
							<td class="label"><?php print $username_label; ?>
							</td>
							<td><?php print $name; ?>
							</td>
						</tr>
						<tr class="joined">
							<td class="label"><?php print t('Joined '); ?>
							</td>
							<td><?php print date("d M Y", $node->created); ?>
							</td>
						</tr>
						<?php if (!empty($religions)) { ?>
						<?php foreach($religions as $rid => $religion) { ?>
						<tr class="religion">
							<td class="label"><?php print $religion_label; ?>
							</td>
							<td><?php print theme('religion', $religion, 'link'); ?>
							</td>
						</tr>
						<?php if (!empty($movements[$rid])):  ?>
						<tr class="movements">
							<td class="label"><?php print $movement_label; ?>
							</td>
							<td><?php $c = ''; ?> <?php foreach($movements[$rid] as $movement) { ?>
								<span class="movement"> <?php print $c . theme('movement', $movement, $religions[$rid], 'link'); ?>
								<?php $c = ', '; ?> </span> <?php } ?></td>
						</tr>
						<?php endif; ?>
						<?php } ?>
						<?php } else { ?>
						<tr class="religion">
							<td class="label"><?php print $religion_label; ?>
							</td>
							<td><?php print $empty ?>
							</td>
						</tr>
						<?php } ?>
						<tr class="gender">
							<td class="label"><?php print $gender_label; ?>
							</td>
							<td><?php print $gender ? theme('gender', $gender, 'both') : $empty; ?>
							</td>
						</tr>
						<tr class="country">
							<td class="label"><?php print $country_label; ?>
							</td>
							<td><?php if (!empty($countries)) { ?> <?php foreach($countries as $country) { ?>
							<?php print theme('country', $country, 'both'); ?> <?php } ?> <?php } else { ?>
							<?php print $empty; ?> <?php } ?>
							</td>
						</tr>
						<tr class="oneliner">
							<td class="label"><?php print $oneliner_label; ?>
							</td>
							<td><?php print $oneliner ? $oneliner : $empty; ?>
							</td>
						</tr>
						<?php if ($dob): ?>
						<tr class="dob">
							<td class="label"><?php print $dob_label; ?>
							</td>
							<td><?php print $dob; ?>
							</td>
						</tr>
						<?php endif; ?>
						<?php if ($homepages): ?>
						<?php foreach($homepages as $homepage) { ?>
						<tr class="homepage">
							<td class="label"><?php print $homepage_label; ?>
							</td>
							<td><?php print $homepage; ?>
							</td>
						</tr>
						<?php } ?>
						<?php endif; ?>
						<?php if ($communitypages): ?>
						<?php foreach($communitypages as $communitypage) { ?>
						<tr class="communitypage">
							<td class="label"><?php print $communitypage_label; ?>
							</td>
							<td><?php print $communitypage; ?>
							</td>
						</tr>
						<?php } ?>
						<?php endif; ?>
						<?php if ($twittername): ?>
						<tr class="twittername">
							<td class="label"><?php print $twittername_label; ?>
							</td>
							<td><?php print $twittername; ?>
							</td>
						</tr>
						<?php endif; ?>
					</table>
				</div>
			</div>
		</div>
		<div class="member-body">
			<div class="body">
				<span class="label"><?php print $body_label; ?>
				</span>
				<?php print $body ? $body : $empty; ?>
			</div>
		</div>
		<div class="member-footer">
			<div class="modified">
			<?php print t('Last Modified: !date', array('!date' => date("d M Y", $node->changed))); ?>
			</div>
		</div>
		<div class="member-footer-actions">
		<?php if ($links): ?>
			<div class="links">
			<?php print $links; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php } else { ?>
	<?php /* -----------------    teaser == 1  ----------------- */ ?>
	<div class="node-full node-full-teaser">
		<div class="member-image">
		<?php echo $picture; ?>
		</div>
		<div class="member-main">
			<div class="about">
				<table>
					<tr class="username">
						<td class="label"><?php print $username_label; ?>
						</td>
						<td><?php print $name; ?>
						</td>
					</tr>
					<tr class="religions">
						<td class="label"><?php print $religion_label; ?>
						</td>
						<td><?php if (empty($religions)) {print $empty; ?> <?php } else { ?>
						<?php $c = ''; ?> <?php foreach($religions as $religion) { ?> <span
							class="religion"> <?php print $c . theme('religion', $religion, 'link'); ?>
							<?php $c = ', '; ?> </span> <?php } ?> <?php } ?>
						</td>
					</tr>
					<?php if (!empty($movements)): ?>
					<tr class="movements">
						<td class="label"><?php print $movement_label; ?>
						</td>
						<td><?php $c = ''; ?> <?php foreach($movements as $rid => $religion) { ?>
						<?php foreach($religion as $movement) { ?> <span class="movement">
						<?php print $c . theme('movement', $movement, $religions[$rid], 'link'); ?>
						<?php $c = ', '; ?> </span> <?php } ?> <?php } ?></td>
					</tr>
					<?php endif; ?>
					<tr class="gender">
						<td class="label"><?php print $gender_label; ?>
						</td>
						<td><?php print $gender ? theme('gender', $gender, 'both') : $empty; ?>
						</td>
					</tr>
					<tr class="country">
						<td class="label"><?php print $country_label; ?>
						</td>
						<td><?php if (!empty($countries)) { ?> <?php foreach($countries as $country) { ?>
						<?php print theme('country', $country, 'both'); ?> <?php } ?> <?php } else { ?>
						<?php print $empty; ?> <?php } ?>
						</td>
					</tr>
					<tr class="oneliner">
						<td class="label"><?php print $oneliner_label; ?>
						</td>
						<td><?php print $oneliner ? $oneliner : $empty; ?>
						</td>
					</tr>
				</table>
				<div class="morelink">
				<?php print l('More', 'user/'. $node->uid .'/about' , array('title' => t('Read more about !user', array('!usr' => $name)))); ?>
				</div>
			</div>

			<div class="body">
				<span class="label"><?php print $body_label; ?>
				</span>
				<?php print $body ? $body : '<p>'. $empty . '</p>'; ?>
				<?php if ($node->readmore): ?>
				<div class="morelink">
				<?php print l('More', 'user/'. $node->uid .'/about', array('title' => t('Read the rest of the biography'))); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php }; ?>
	<?php endif; ?>
</div>
