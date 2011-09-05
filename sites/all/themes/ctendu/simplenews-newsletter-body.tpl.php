<?php
// $Id: simplenews-newsletter-body.tpl.php,v 1.1.2.4 2009/01/02 11:59:33 sutharsan Exp $

/**
 * @file
 * Default theme implementation to format the simplenews newsletter body.
 *
 * Copy this file in your theme directory to create a custom themed body.
 * Rename it to simplenews-newsletter-body--<tid>.tpl.php to override it for a 
 * newsletter using the newsletter term's id.
 *
 * Available variables:
 * - node: Newsletter node object
 * - $body: Newsletter body (formatted as plain text or HTML)
 * - $title: Node title
 * - $language: Language object
 *
 * @see template_preprocess_simplenews_newsletter_body()
 */
?>
<?php // background Table ?> 
<table width="100%" cellspacing="0" class="backgroundTable" style="background-color: #F7F7F7;">
<tr>
	<td valign="top" align="center">
    <?php // Content Table ?>
  	<table id="contentTable" cellspacing="0" cellpadding="0" width="600" style="border: 0px none #000000;margin-top: 10px;">
  	<tr>
		<td class="mailBanner" align="center" style="background-color: #F7F7F7;border-top: 0px none #000000;border-bottom: 0px none #FFFFFF;text-align: center;padding: 0px;">
  			<div>
  		      <?php print theme('imagecache', 'mailbanner', path_to_theme() .'/images/email-banner.jpeg', 'Creedia'); ?>
			</div>
  		</td>
  	</tr>
	<tr>
  		<td class="mailBody" align="center" style="background-color: #F7F7F7;border-top: 0px none #000000;border-bottom: 0px none #FFFFFF;text-align: left;padding: 0px; margin-top: 10px;">
			<h2><?php print $title; ?></h2>
  			<div>
  		      <?php print $body; ?>
  			</div>
  		</td>
	</tr>
	<tr>
		<td class="mailfooter" align="center" style="background-color: #F7F7F7;border-top: 0px none #000000;border-bottom: 0px none #FFFFFF;text-align: center;padding: 0px; margin-top: 10px;">
  			<div>
  				<p>
  				<?php print variable_get('site_mission', t('!site is an online community of individuals seeking to connect on values and beliefs.', array('!site' => l('Creedia', '', array('absolute' => TRUE))) ));?>
				</p>
				<p>
				<?php print l('Members', '/members', array('attributes' => array('style' => 'padding-right:10px;'), 'absolute' => TRUE));?>
			    <?php print l('Creeds', '/creeds', array('attributes' => array('style' => 'padding-right:10px;'), 'absolute' => TRUE));?>	
                <?php print l('Blogs', '/blogs', array('attributes' => array('style' => 'padding-right:10px;'), 'absolute' => TRUE));?>
                <?php print l('Discussions', '/opinions', array('attributes' => array('style' => 'padding-right:10px;'), 'absolute' => TRUE));?>
                <?php print l('Join', '/user/register', array('attributes' => array('style' => 'padding-right:10px;'), 'absolute' => TRUE));?>
				</p>
  			</div>
  		</td>
	</tr>
	</table>
	</td>
</tr>
</table>


