<?php
/**
 * Tendu Drupal 5.x Theme For Developers CSS
 * Updated: $Date: 2008/05/28 11:51:29 $ 
 * Author: Tom Bigelajzen - http://tombigel.com
 * 
 * This theme is cross-browser and RTL ready.
 * It is extremely minimal and meant to be a wireframe for 
 * theme developers to build bi-directional themes.
 * 
 * Requires the Internationalization Package for full features.
 * http://drupal.org/project/i18n
 */

/**
 * CSS Files 
 * Notes: 
 * The line that calls style.css is not necessary (it will be called anyway), 
 * but I leave it here anyway as an example.
 */ 
drupal_add_css(path_to_theme() .'/style.css', 'theme');

/**
 * Add RTL CSS Support (i18n Package) 
 * Notes:
 * These CSS files will be called only for languages set to RTL
 * in Administration -> Localization section.
 */
if (module_invoke('i18n', 'language_rtl')) { 
  drupal_add_css(path_to_theme() .'/style-rtl.css', 'theme');
}

/* Add creedia javascript file */
drupal_add_js(path_to_theme(). '/creedia.js');

/* Add firebug lite */
/*drupal_add_js('http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js');*/

//drupal_add_js(drupal_get_path('module', 'ctaxo') .'/jquery-autocomplete/jquery.autocomplete.js');
//drupal_add_css(drupal_get_path('module', 'ctaxo') .'/jquery-autocomplete/jquery.autocomplete.css');

//firep(drupal_get_path('module', 'creedia_tax'), 'initial js path settings');

/**
 * Declare the available regions implemented by this theme.
 *
 * @return
 *   An array of regions.
 */

function tendu_regions() {
  return array(
    'sidebar_left' => t('left sidebar'),
    'sidebar_right' => t('right sidebar'),
    'content' => t('content'),
    'content_top' => t('content top'),
    'content_bottom' => t('content bottom'),
    'header' => t('header'),
    'footer' => t('footer'),
    'closure_region' => t('closure'),
    'main_nav' => t('main navagation'),
  );
}

/**
 * Style Language links (i18n Package)
 * 
 * @return
 *   HTML of the links
 */
function tendu_i18n_link($text, $target, $lang, $separator='&nbsp;'){
  $output = '<span class="i18n-link">';
  $attributes = ($lang == i18n_get_lang()) ? array('class' => 'active') : NULL;
  //$output .= l(theme('i18n_language_icon', $lang), $target, $attributes, NULL, NULL, FALSE, TRUE);//Flags
  $output .= $separator;
  // $output .= l($text, $target, $attributes, NULL, NULL, FALSE, TRUE);
  $output .= l(t($text), $target, $attributes, NULL, NULL, FALSE, TRUE);//Text
  $output .= '</span>';
  return $output;
}

function theme_term($term, $format = 'image', $path = 'members/featured', $parent = NULL) {
  switch ($format) {
  case 'link':
    $output = l($term->name, $path . $term->tid, array('title' => $term->description));
    break;
  case 'image':
    $image = taxonomy_image_display($term->tid);
    //    $output = l($image, $path . $term->tid, array('title' => $term->name), NULL, NULL, FALSE, TRUE);
    if ($image) {
      $output = $image;
    }
    else {
      $output = theme_term($term, 'link', $path, NULL);
    }
    break;
  case 'profile':
  case 'religion':
    $image = taxonomy_image_display($term->tid, NULL, $format);
    $output = $image;
    break;
  case 'taxobar':
    if ($parent) {
      $image = taxonomy_image_display($parent->tid);
      $output .= $image ? $image : $term->name;
      $output .= l($term->name, $path . $term->tid, array('title' => $term->description));
    }
    else {
      $image = taxonomy_image_display($term->tid);
      $output .= $image ? $image : $term->name;
      $output .= l($term->name, $path . $term->tid, array('title' => $term->description, 'style' => 'display:none'));
    }
    break;
  case 'both':
    if ($parent) {
      $image = taxonomy_image_display($parent->tid);
    }
    else {
      $image = taxonomy_image_display($term->tid);
    }
    $output .= $image . l($term->name, $path . $term->tid, array('title' => $term->description));
    break;
  case 'breadcrumb':
    $rel = l($parent->name, $path . $parent->tid, array('title' => $parent->description));
    $mov = l($term->name, $path . $term->tid, array('title' => $term->description));
    $output = theme('breadcrumb', array($mov, $rel));
    break;
  case 'tagadelic':
    $output = l($term->name, $path . $term->tid, array('title' => $term->description,
						       'class' => "tagadelic level$term->weight"));
    break;
  default:
    $output = $term->name;
    break;
  }
  return $output;
}


function theme_religion($term, $format, $path = 'members/featured/') {
  return theme('term', $term, $format, $path);
}  

function theme_movement($term, $parent, $format, $path = 'members/featured/'){
  return theme('term', $term, $format, $path, $parent);
}

function theme_beliefset($term, $format='image', $path = 'members/featured/'){
  return theme('term', $term, $format, $path);
}

function theme_freetag($term, $format='link', $path = 'opinions/featured/') {
  return theme('term', $term, $format, $path);
}

function theme_country($term, $format='link', $path = 'members/featured/') {
  return theme('term', $term, $format, $path);
}

function theme_gender($term, $format='link', $path = 'members/featured/') {
  return theme('term', $term, $format, $path);
}


/**
 * Logintoboggan: Add link to my profile
 */
function phptemplate_lt_loggedinblock() {
  global $user;
  $output = l(t('Log out'), 'logout', array('title' => t('logout')));
  $output .= l(t('My account'), 'user/'.$user->uid, 
	       array('title' => t('!name account',array('!name' => $user->name))));
  return $output;
}

/**
 * Logintoboggan: Remove the register to a separate block in front page
 */
function phptemplate_lt_login_link() {
  // Only display register text if registration is allowed.
  if (variable_get('user_register', 1) && !drupal_is_front_page()) {
    return t('Login/Register');
  }
  else {
    return t('Login');
  }
}


/**
 * Remove unwanted tabs inserted by other modules / core
 * Per http://drupal.org/node/68729remove
 */
function tendu_removetabs($label, &$vars) {

  $tabs = explode("\n", $vars['tabs']);
  $vars['tabs'] = '';

  foreach ($tabs as $tab) {
    if (strpos($tab, '>'. $label .'<') === FALSE) {
      $vars['tabs'] .= $tab ."\n";
    }
  }
}

/**
 * Override or insert PHPTemplate variables into the page templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 */
function _phptemplate_variables($hook, $vars=array() ) {
  global $user;
  //drupal_set_message("phptemplate_variables hook '$hook' ..");
  switch ($hook) {
    case 'page':
      /* Add classes to the "body" tag, for easier layout styling
      * Idea taken from ZEN theme (but my changes make it incompatible with it)
      */
      if(module_exists('javascript_aggregator') && $vars['scripts']) {
	$vars['scripts'] = javascript_aggregator_cache($vars['scripts']);
      }

      $body_classes = array();
      $body_classes[] = ($vars['is_front']) ? 'front' : 'not-front';
      $body_classes[] = ($user->uid) ? 'logged-in' : 'not-logged-in';
      if ($vars['sidebar_left'] && $vars['sidebar_right']) {
        $body_classes[] = 'two-sidebars';
      }
      elseif (!$vars['sidebar_left'] && !$vars['sidebar_right']){
        $body_classes[] = 'no-sidebars';
      }
      else{
        $body_classes[] = 'one-sidebar';
      }
      if ($vars['sidebar_left']) {
        $body_classes[] = 'with-sidebar-left';
      }
      if ($vars['sidebar_right']) {
        $body_classes[] = 'with-sidebar-right';
      }
      //      if (in_array(arg(0), array('creeds','opinions','members', 'gallery'))) {
      if (arg(0) != 'user' && arg(0) != "admin") {
        $body_classes[] = 'tabs-sort-style';
      }
      else if (arg(0) == 'user') {
        $body_classes[] = 'tabs-user-style';
      }
      $vars['body_classes'] = implode(' ', $body_classes); // Concatenate with spaces	

      // add pager results 
      if (in_array(arg(0), array('creeds','opinions','members', 'blogs'))) {
	$vars['tabs'] = theme('pager_results', CREEDIA_NODES_PER_PAGE) . '<span id="tabs-title">'. t('Sort by:') .'</span>'. $vars['tabs'];
      }
      else if (in_array(arg(0), array('gallery','gallery3'))) {
	$vars['tabs'] = theme('pager_results', CREEDIA_IMAGES_PER_GALLERY) . $vars['tabs'];
      }
      else if (in_array(arg(0), array('taxonomy', 'blog'))) {
	$vars['tabs'] = theme('pager_results', CREEDIA_NODES_PER_PAGE) . $vars['tabs'];
      }
      else if (in_array(arg(0), array('deeds'))) {
	$vars['tabs'] = '<span id="tabs-title">'. t('Sort by:') .'</span>'. $vars['tabs'];
      }

      // rewrite title
      $breadcrumb = '';
      $background = FALSE;
      $use_title = TRUE;
      $class = arg(0);
      if (drupal_is_front_page()) {
	$title = $vars['site_slogan'];
      }
      else if (arg(0) == 'node'){
	$class = 'Creedia';
	$title = menu_get_active_title();
	if (is_numeric(arg(1))) {
	  $node = node_load(arg(1));
	  if ($node) {
	    $title = truncate_utf8d($node->title, 45, TRUE, TRUE);
	    $class = $node->type .'s'; 
	    switch ($node->type) {
	    case 'page':
	      $class = 'Creedia';
	      $background = TRUE;
	      break;
	    case 'image_cck':
	      $class = 'Gallery';
	      break;
	    case 'simplenews':
	      $class = 'Newsletter';
	      break;
	      //	  case 'member':
	      //	    $title = member_title($node);
	      //	    break;
	    case 'blog': case 'dblog':
	      $class = 'Blog';
	      break;
	    }
	  }
	}
	else if (arg(1) == 'add' && arg(2) == 'interpretation') {
	  $title = t(ucfirst(arg(2)));
	}
      }
      else if (arg(0) == 'user') {
	$background = TRUE;
	if (is_numeric(arg(1))) {
	  $uid = arg(1);
	  $class = 'Members';
	  $node = cprofile_get_member($uid);
	  if ($node) {
	    $title = member_title($node);
	  }
	}
	else {
	  $class = 'Creedia';
	  $title = ucfirst(arg(1));
	}
      }
      else if (arg(0) == 'comment') {
	$class = t('Comments');
	$title = arg(1) ? ucfirst(arg(1)) : '';
      }
      else if (in_array(arg(0), array('creeds', 'opinions', 'members', 'gallery', 'taxonomy', 'blogs', 'deeds'))){
	if (arg(0) == 'opinions') {
	  $class = 'Discussions';
	}
	$use_title = FALSE;
      }
      else if (arg(0) == 'blog') {
	$class = 'Creedia';
	$title = t('Company Blog');
      }
      else if (arg(0) == 'admin') {
	$breadcrumb = $vars['breadcrumb'];
	$title = menu_get_active_title();
      }
      else {
	$background = TRUE;
	$class = 'Creedia';
	$title = menu_get_active_title();
      }
      if (!$title) {
	$title = menu_get_active_title();
	$use_title = FALSE;
      }
      $vars['head_title'] = $title ? t('Creedia | !title', array('!title' => $title)) :
	t('Creedia | !title', array('!title' => $vars['site_slogan']));
      $vars['title'] = $use_title ? $title : '';
      $vars['class'] = ucfirst($class);
      $vars['content_background'] = $background;
      $vars['breadcrumb'] = $breadcrumb;

      // remove unwanted tabs
      tendu_removetabs('Personal files', $vars);
      tendu_removetabs('Dev load', $vars);
      break;

  case 'node':
    $node = $vars['node'];
    
    // Split the taxonomy up into one variable per vocabulary
    $terms = ctaxo_node_taxonomy($node);
    $vars['religions'] = $terms['religion'];
    $vars['movements'] = $terms['movement'];
    $vars['beliefset'] = $terms['beliefset'];
    $vars['freetag'] = $terms['freetag'];
    $vars['countries'] = $terms['country'];

    // Featured
    $flags = flag_get_counts('node', $node->nid);
    //    if ($flags['featured_'. $node->type]) {
    if ($flags['featured']) {
      $ftitle = t('Featured !type',array('!type' => $node->type));
      // theme_imagecache($namespace, $path, $alt = '', $title = '', $attributes = null)
      $featured = theme('imagecache', 'featured', path_to_theme() . '/featured.png', '', $ftitle);
			
    }
    $vars['featured'] = $featured;

    switch ($node->type) {
    case 'interpretation':
      $vars['show_vote'] = TRUE;
      if (arg(0) == 'node' && is_numeric(arg(1)) && arg(1) != $node->nid) {
	// In full node view both voting and adopting widgets are available. The adopt widget is
	// available when the interpretation are listed under their creed. In all other lists
	// the fivestar voting should be shown. Therefore we set 'show vote' to false only
	// if we are within a node and its not that specific interpretation (i.e. we want
	// preview to show vote and not adopt as well.
	$vars['show_vote'] = FALSE;
      }
      $counts = flag_get_counts('node', $node->nid);
      $vars['adopt'] = flag_create_link('adopt', $node->nid); 
      if (!$vars['adopt']) { 
	// for anonymous users
	$vars['adopt'] = theme('image', path_to_theme() .'/images/flag-adopt-on.png');
      }
      $vars['adopt_text'] = t('Adopted: !count', array( '!count' => $counts['adopt'] ? $counts['adopt'] : 0 )); 
      break;
    case 'image_cck':
      $vars['picture'] = $node->field_image[0]['view'];
      $vars['pic_url'] = $node->field_image[0]['filepath'];
      $flags = flag_get_counts('node', $node->nid);
      if ($flags['default_image']) {
	$vars['default_image'] = theme('image', 
				       path_to_theme() .'/images/link-flag-default_image.png', 
				       '', 
				       t('Used as default image in posts.'));
      }
      break;
    case 'creed':
      // Interpretation num
      $intnum = db_result(db_query('SELECT COUNT(*) FROM {content_field_creed_reference1} WHERE field_creed_reference1_nid = %d', $node->nid));
      $vars['intnum'] = $intnum;
      $counts = flag_get_counts('node', $node->nid);
      $vars['adopt'] = flag_create_link('adopt', $node->nid); 
      if (!$vars['adopt']) { 
	// for anonymous users
	$vars['adopt'] = theme('image', path_to_theme() .'/images/flag-adopt-on.png');
      }
      $vars['adopt_text'] = t('Adopted: !count', array( '!count' => $counts['adopt'] ? $counts['adopt'] : 0 )); 
      break;
    case 'member':
      $account = user_load(array('uid' => $node->uid));
      if ($vars['page']) {
	$vars['picture'] = theme('user_picture', $account, 'profile');
      }
      else {
	$vars['picture'] = theme('user_picture', $account, 'comment');
      }

      $vars['empty'] = t('Not entered.');
      $vars['religion_label'] = t('Religion ');
      $vars['movement_label'] = t('Movement ');
      //      $vars['country'] = $country;
      $vars['country_label'] = t('Country ');
      //      $vars['gender'] = $gender;
      $vars['gender'] = $terms['gender'];
      $vars['gender_label'] = t('Gender ');
      $vars['oneliner'] = $node->field_one_liner[0]['view'];
      $vars['oneliner_label'] = t('One Liner ');
      $vars['fullname'] = $node->field_full_name[0]['view'];
      $vars['fullname_label'] = t('Name ');
      if ($node->field_home_page) {
	foreach ($node->field_home_page as $page){
	  if ($page['view']) {
	    $vars['homepages'][] = $page['view'];
	  }
	}
	$vars['homepage_label'] = t('Home Page ');
      }
      if ($node->field_community_page) {
	foreach ($node->field_community_page as $page){
	  if ($page['view']) {
	    $vars['communitypages'][] = $page['view'];
	  }
	}
	$vars['communitypage_label'] = t('Community Page ');
      }
      $vars['username_label'] = t('Username ');
      $vars['body_label'] = t('Spiritual Biography ');
      $vars['body'] = $node->content['body']['#value']; 
      $vars['dob'] = $field_birth_date[0]['view'];
      $vars['dob_label'] = t('Date of Birth ');
      if ($twittername = $node->field_twitter[0]['view']) {
	//	$twitter_url = theme('image', path_to_theme() .'/images/twitter.png');
	$twitter_url .= l($twittername, 'http://twitter.com/'. $twittername);
	$vars['twittername'] = $twitter_url;
      }
      $vars['twittername_label'] = t('Twitter ');

      if ($user->uid) {
	$vars['common'] = cdist_dist($node->uid);
      }
      break;
    }
    break;
  case 'flag':
    // theme the flag links per images
    phptemplate_preprocess_flag($vars);
    break;
  case 'comment':
    break;
  case 'block':
    break;
  }
  return $vars;
}

function member_title($node) {
  $name = $node->field_full_name[0]['value'];
  return $name ? $name : $node->title;
}

/**
 * Take control of flag theming
 */
function phptemplate_flag($flag, $action, $content_id, $after_flagging = FALSE) {
  return flag_phptemplate_adapter($flag, $action, $content_id, $after_flagging);
}

/**
 * Replace links with images (flag module) per http://drupal.org/node/305061
 */
function phptemplate_preprocess_flag(&$vars) {
  $image_file = path_to_theme() . '/images/flag-' . $vars['flag_name_css'] . '-' . ($vars['action'] == 'flag' ? 'off' : 'on') . '.png';
  // Uncomment the following line when debugging.
  //   drupal_set_message("Flag is looking for '$image_file'...");
  //     dvr($vars);
  if (file_exists($image_file)) {
    // note that flags that appear in links are themed using link alter and not
    // using this function, as it doesn't allow for text and image together.
    $vars['link_text'] = '<img src="' . base_path() . $image_file . '" />';
  }
}


/**
 * Add handling  of new 'pre' attribute
 * e.g. creedia.module adds pre attribute using hook_link_alter
 */
function phptemplate_links($links, $attributes = array('class' => 'links')) {
  $output = '';

  if (count($links) > 0) {
    $output = '<ul'. drupal_attributes($attributes) .'>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = $key;

      // Automatically add a class to each link and also to each LI
      if (isset($link['attributes']) && isset($link['attributes']['class'])) {
        $link['attributes']['class'] .= ' ' . $key;
      }
      else {
        $link['attributes']['class'] = $key;
      }

      // Add first and last classes to the list of links to help out themers.
      $extra_class = '';
      if ($i == 1) {
        $extra_class .= 'first ';
      }
      if ($i == $num_links) {
        $extra_class .= 'last ';
      }
      $output .= '<li '. drupal_attributes(array('class' => $extra_class . $class)) .'>';
      
      // add pre if available
      if (isset($link['pre'])) {
	$output .= $link['pre'];
      }

      // Is the title HTML?
      $html = isset($link['html']) && $link['html'];

      // Initialize fragment and query variables.
      $link['query'] = isset($link['query']) ? $link['query'] : NULL;
      $link['fragment'] = isset($link['fragment']) ? $link['fragment'] : NULL;

      if (isset($link['href'])) {
        $output .= l($link['title'], $link['href'], $link['attributes'], $link['query'], $link['fragment'], FALSE, $html);
      }
      else if ($link['title']) {
        //Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (!$html) {
          $link['title'] = check_plain($link['title']);
        }
        $output .= '<span'. drupal_attributes($link['attributes']) .'>'. $link['title'] .'</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}


/*
 * Overriding local tasks to preserve the arguments in the URL
 *
 * Without this patch, the other 'sortby' tabs URLs will not
 * include the selected taxonomy terms, and hence the user will be forced to
 * add the taxonomy terms again to the bar each time he/she 
 * selects another tab.
 *
 * The primary menu that points to creeds, memebers and opinions
 * should not include the terms. Therefore here is assumes that
 * the menu is configured with path opinion/go (i.e. with additional
 * go). When such a links is themed, the 'go' is removed and terms
 * are not added to the link.
 *
 * Arguments are then added to the menu item that holds the 
 * 'sortby' tabs, such that they that will sort according to 
 * the already selected terms.
 *
 */

/*
 * This function was replaced by jquery handling, i.e. the sort link
 * click event is used to add the taxobar terms to the url. 
 * Poor users with js disabled do not have the benefit and sort links
 * will discard the terms.
 */

// function phptemplate_menu_item_link($item, $link_item) {

//   for ($i = 0; arg($i); $i++) {
//     $args[] = arg($i);
//   }
//   $path = $item['path'];
//   $pathargs = explode('/', $path);

//   if (in_array($pathargs[0], array('creeds', 'members', 'opinions'))) {
//     if (isset($pathargs[1]) && $pathargs[1] == 'go') {
//       $path = $pathargs[0];  // remove the 'go'
//     }
//     else {
//       if (isset($args[2])) {
// 	// add the arguments
// 	$i = 2;
// 	while (isset($args[$i])) {
// 	  $path .= '/'. $args[$i];
// 	  $i++;
// 	}
//       }
//     }
//   }
//   return l($item['title'], $path, !empty($item['description']) ? 
// 	   array('title' => $item['description']) : array(), isset($item['query']) ? $item['query'] : NULL);
// }


/**
 * 
 */

/*
 * Theme origin statements
 * 
 * @param $node
 *   The creed node holding the statements
 * @param $one
 *   If TRUE, only the $num statement is rendered.
 * @param $trim
 *   If non-zero indicate the number of characters to trim the statements
 * @param $num
 *   If $one is true, $num indicates the statement number to print. 
 * @param $hidden
 *   If $hidden is true, all statements apart from $num will be hidden (make sense only if $one = false)
 */
function phptemplate_origin_statement($node, $one = FALSE, $trim = 0, $num = 0, $hidden = false) {
//   ob_start();
//   debug_print_backtrace();
//   $trace = ob_get_contents();
//   $trace = substr($trace, 0, 10000);
//   ob_end_clean();
//   firep($trace, 'trace in theme origin statement');

  $output = '';
  $statements = $node->field_origin_statement;
  $langs = $node->field_origin_statement_lang;

  for ($i = 0; $i < count($statements); $i++ ) {
    if ($num != $i && $one) continue;
    $output .= '<div class="origin-statement"';
    $lang = $langs[$i]['value'];
    if ($lang) {
      $dir = i18n_language_rtl($lang) ? 'rtl' : 'ltr';
      $output .= ' lang="'. $lang .'" dir="'. $dir .'"';
    }
    if ($hidden && $num != $i) {
      $output .= 'style=display:none ';
    }
    $output .= '><h3>';
    if ($trim) {
      $output .= check_plain(truncate_utf8d($statements[$i]['value'], $trim, TRUE, TRUE ));
    }
    else {
      $output .= check_plain($statements[$i]['value']);
    }
    $output .= '</h3></div>';
  }
  return $output;
}


/**
 * Theme opinion or interpretation image.
 * Pick either the embedded (referenced) image, video, audio
 * or uploaded image.
 *
 */
function phptemplate_opinion_image($node, $page = TRUE) {

  $output = '';
//  firep($node, 'node in theme opinion image');
//   $trace = debug_backtrace();
//   foreach ($trace as $i => $traceline) {
//     $functrace .= $traceline['function'] .'\n';
//   }
//   firep($functrace, 'func-trace user picture);
  
// //   ob_start();
//   debug_print_backtrace();
//   $trace = ob_get_contents();
//   //  $trace = substr($trace, 0, 10000);
//   ob_end_clean();
//   firep($trace, 'trace in theme opinion image');

  // Prepare the right image size in advance
  $image = $node->field_opinion_image[0]['view'];
  $audio = $node->field_opinion_audio[0]['filepath'];
  $em_picture = $node->field_opinion_em_picture[0]['view'];
  $em_video = $node->field_opinion_em_video[0]['view'];
  $em_audio = $node->field_opinion_em_audio[0]['view'];

  if ($image) {
    $output .= $image;
  }
  else if ($audio) {
    if ($page) {
      $output .= swf('../'. $audio, FALSE, FALSE, FALSE, array('player' => 'onepixelout'));
    }
    else {
      $output .= swf('../'. $audio, array('width' => '60', 'height' => '62'));
    }
  }
  else if ($em_picture) {
    // default picture is saved in em_picture.
    $output .= $em_picture;
  }
  else if ($em_audio) {
    $output .= $em_audio;
  }
  else if ($em_video) {
    // for some unknown reason, em_video inserts a 'view viedo' link even if no em video is selected
    // so I'm setting it to be the last one, such that it won't override real images.
    $output .= $em_video;
  }

  return $output;
}

/**
 * Truncated title link
 */
function phptemplate_truncated_title($title, $nid, $len) {
  return l( truncate_utf8($title, $len, TRUE, TRUE), 'node/'.$nid, array('title' => $title ) );
}

/**
 * Truncated user link
 */
function phptemplate_truncated_user($fullname, $username, $uid, $len) {
  if ($fullname) {
    //    $name = $fullname . ' ('. $username .')';
    $name = $fullname;
    if (drupal_strlen($name) > $len || !$username) {
      $name = $fullname;
    }
  }
  else {
    $name = $username;
  }
  return l( truncate_utf8d($name, $len, TRUE, TRUE), 'user/'.$uid, array('title' => $name ) );
}


/**
 *
 * Utilized imagecache module to scale down large uploaded profile pictures
 * @param $size
 *   Image size to scale to. Default is 'comment' which covers both member
 *   listing picture size as well as pictures in comments. This is the most
 *   used size and the most intensive to override.
 *
 * Thanks to Nate Haug and Lullabot
 *
 * Note: $account is either a user or a node object. 
 *
 * THE IMAGECACHE_PROFILES MODULE TAKES CARE OF THIS
 */
function tendu_user_picture($account, $size = 'comment') {

  if (variable_get('user_pictures', 0)) {
    // Display the user's photo if available
    if ($account->picture && file_exists($account->picture)) {
       $picture = theme('imagecache', $size, $account->picture);
    }
    else if (variable_get('user_picture_default', '')) {
      $picture = theme('imagecache', $size, variable_get('user_picture_default', ''));
    }
    return '<div class="picture">'.$picture.'</div>';
  }
}


/*
 * Theme out the usercomment form
 */
function phptemplate_usercomment($content) {
  $output = '<div id="usercomments">';
  $output .= theme('comment_wrapper', $content);
  $output .= "</div>";
  return $output;
}

/*
 * Theme out the empty usercomment form
 */
function phptemplate_usercomment_empty() {
  $output = '<div id="usercomments-empty">';
  $output .= "</div>";
  return $output;
}


/**
 * enable hook_link_alter for comments by overriding comments theming functions
 * see http://drupal.org/node/169890
 */ 
function phptemplate_comment_flat_expanded($comment) {
  $links = module_invoke_all('link', 'comment', $comment, 0);
  foreach (module_implements('link_alter') as $module) {
    $function = $module .'_link_alter';
    $function($node, $links);
  }
  return theme('comment_view', $comment, $links);
}

/**
 * Allow themable wrapping of all comments.
 */
function phptemplate_comment_wrapper($content) {
  // Member comments handling is different from other node comments in several ways.
  // First they are presented on the the user/guestbook page, and therefore the 
  // node information can not be directly retrieved from the URL. Second, we show
  // both the unapproved user comments and the user comments on the same page. As
  // a result this function is called twice on the same page and therefore we 
  // can not use the id=comments. In addition the theming in the user page is 
  // different then the one for the user pages. Last issue is the number of comments
  // which doesn't differ between approved and non-approved comments and therefore
  // shows the combined number for both wrappers.
  // As a result, instead of extending this function further, we do not return a wrapper
  // for members comments rather add whatever wrapping required by the calling function.
  if (arg(0) == 'user') {
    // member's comment, return no wrapper.
    return $content;
  }
  else {
    $nid = arg(1);
    if ($nid) {
      $node = node_load($nid);
    }
  }
  $collapsed = FALSE;
  $num = 0;
  if (!$node) {
    return '<div id="comments">'. $content .'</div>'; // this shouldn't happen
  }
  $num = $node->comment_count;
  if ($node->type == 'creed') {
    $collapsed = TRUE;
  }
  $element['#collapsible'] = TRUE;
  $element['#collapsed'] = $collapsed;
  if ($num) {
    $element['#title'] = t('Comments (!num)', array('!num'=>$num));
  }
  else {
    $element['#title'] = t('No Comments so far');
  }
  $element['#value'] = $content;
  $element['#attributes'] = array('id' => 'comments-fieldset');
  
  $output = '<div id="comments">';
  $output .= theme('fieldset', $element);
  $output .= '</div>';

  return $output;
  //  return '<div id="comments">'. $content .'</div>';
}


/**
 * Theme wrapping of all interpretations.
 */
function phptemplate_interpretation_wrapper($content, $num) {

  $element['#collapsible'] = TRUE;
  if ($num) {
    $element['#title'] = t('Interpretations (!num)', array('!num'=>$num));
    $element['#collapsed'] = FALSE;
  }
  else {
    $element['#title'] = t('No Interpretation so far');
    $element['#collapsed'] = TRUE;
  }

  $element['#value'] = $content;
  $element['#attributes'] = array('id' => 'interpretations-fieldset');

  $output = '<div id="interpretations">';
  $output .= theme('fieldset', $element);
  $output .= '</div>';
  return $output;
}

function phptemplate_cprofile_title_bar($title, $node = NULL) {
  if ($node) {
    $terms = ctaxo_node_taxonomy($node);
    $vars['religions'] = $terms['religion'];
    $vars['movements'] = $terms['movement'];
  }
  $vars['title'] = $title;
  return  _phptemplate_callback('cprofile-title', $vars);
}

/**
 * Theme a cprofile entry
 */
function phptemplate_cprofile_entry($data, $i, $interpretations) {

  if ($data->field_origin_statement_value) {
    $node = new stdClass();
    $node->field_origin_statement[0]['value'] = $data->field_origin_statement_value;
    $node->field_origin_statement_lang[0]['value'] = $data->field_origin_statement_lang_value;
    //    $node->field_origin_statement_dir[0]['value'] = $data->field_origin_statement_dir_value;
  }
  $religion = taxonomy_node_get_terms_by_vocabulary($data->nid, CREEDIA_RELIGION_VID);
  $beliefset = taxonomy_node_get_terms_by_vocabulary($data->nid, CREEDIA_BELIEFSET_VID);
  $new = !isset($data->position);

  $vars = array();
  $vars['data'] = $data;
  $vars['i'] = $i;
  $vars['node'] = $node;
  $vars['religion'] = array_shift($religion);
  $vars['beliefset'] = $beliefset;
  $vars['new'] = $new;
  $interpretation_num = count($interpretations);
  $vars['interpretation_num'] = $interpretation_num;
  $vars['interpretations'] =  $interpretation_num ? theme('item_list', $interpretations) : NULL;

  return  _phptemplate_callback('cprofile-entry', $vars);
}


/**
 * Theme 'Related Creeds' View
 */
function phptemplate_views_view_list_related_creeds_prog($view, $nodes, $type) {
  $fields = _views_get_fields();

  //  firep($view, 'view in related-creed view theming');
  //  firep($nodes, 'nodes in related-creed view theming');
  //  firep($fields, 'fields in related-creed view theming');

  foreach ($nodes as $i => $node) {

    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';

    $nid = $node->nid;
    $religion = array();
    $terms = taxonomy_node_get_terms_by_vocabulary($nid, CREEDIA_RELIGION_VID);
    foreach($terms as $term) {
      $religion[] = theme('religion', $term, 'image');
    }
    $beliefset = array();
    $terms = taxonomy_node_get_terms_by_vocabulary($nid, CREEDIA_BELIEFSET_VID);
    foreach($terms as $term) {
      $beliefset[] = theme('beliefset', $term, 'image');
    }
    $vars['religion'] = $religion;
    $vars['beliefset'] = $beliefset;

//     $snode = new stdClass();
//     // views provides the information already formatted, which is problematic 
//     // for using dir and lang as attributes. The right approach is to write 
//     // a cck module for origin statement, but that too much for now. So we
//     // directly pull the information from the cck tables.

//     $sql  = "SELECT s.field_origin_statement_value, s.delta, ";
//     //    $sql .= "d.field_origin_statement_dir_value, d.delta, ";
//     $sql .= "l.field_origin_statement_lang_value, l.delta "; 
//     $sql .= "FROM {content_field_origin_statement} s ";  // cck multiple value field instance
//     $sql .= "INNER JOIN {node} n ";
//     $sql .= "ON n.nid = %d AND n.status = 1 ";                   // published creed nodes
//     $sql .= "AND n.nid = s.nid AND s.vid = n.vid AND s.delta = 0 ";
//     //    $sql .= "LEFT JOIN {content_field_origin_statement_dir} d ";  // cck multiple value field instance
//     //    $sql .= "ON n.nid = d.nid AND d.vid = n.vid AND d.delta = s.delta ";
//     $sql .= "LEFT JOIN {content_field_origin_statement_lang} l ";  // cck multiple value field instance
//     $sql .= "ON n.nid = l.nid AND l.vid = n.vid AND l.delta = s.delta ";

//     $result = db_query(db_rewrite_sql($sql), $nid);
//     $data = db_fetch_object($result);

//     $snode->field_origin_statement[0]['value'] = $data->field_origin_statement_value;
//     $snode->field_origin_statement_lang[0]['value'] = $data->field_origin_statement_lang_value;

    foreach ($view->field as $id => $field) {
      $val = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      $name = $field['field']; 
      $vars[$name] = $val;
    }
    $vars['title'] = theme('truncated_title', $node->node_title, $nid, 32);
//    $vars['statement'] = theme('origin_statement', $snode, TRUE, 18); 

    $items[] = _phptemplate_callback('views-list-related_creeds_prog', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

function phptemplate_views_view_list_latest_creeds_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_creeds_prog($view, $nodes, $type);
}

function phptemplate_views_view_list_featured_creeds_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_creeds_prog($view, $nodes, $type);
}

function phptemplate_views_view_list_front_latest_creeds_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_creeds_prog($view, $nodes, $type);
}

/**
 * Theme 'Related Opinions' View
 */
function phptemplate_views_view_list_related_opinions_prog($view, $nodes, $type) {
  $fields = _views_get_fields();

  foreach ($nodes as $i => $node) {

    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';

    $snode = new stdClass();
    foreach ($view->field as $id => $field) {
      $val = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      $name = $field['field']; 
      switch($name) {
      case field_opinion_image_fid:
	$snode->field_opinion_image[0]['view'] = $val;
	break;
      case field_opinion_em_picture_embed:
	$snode->field_opinion_em_picture[0]['view'] = $val;
	break;
      case field_opinion_em_video_embed:
	$snode->field_opinion_em_video[0]['view'] = $val;
	break;
      case field_opinion_em_audio_embed:
	//	$snode->field_opinion_em_audio[0]['view'] = $val;
	// There is a bug I could not trace which doesn't set thumbnail picture even
	// if a path for a default thumbnail is set. So, we override it here.
	if ($val) {
	  $snode->field_opinion_em_audio[0]['view'] = theme('image', path_to_theme() .'/images/audio.png');
	}
	break;
      default:
 	$vars[$name] = $val;
      }
    }
    $vars['opinion_image'] = theme('opinion_image', $snode); 
    $vars['title'] = theme('truncated_title', $node->node_title, $node->nid, 17);
    $items[] = _phptemplate_callback('views-list-related_opinions_prog', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

function phptemplate_views_view_list_latest_opinions_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_opinions_prog($view, $nodes, $type);
}
function phptemplate_views_view_list_front_latest_opinions_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_opinions_prog($view, $nodes, $type);
}
function phptemplate_views_view_list_featured_opinions_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_opinions_prog($view, $nodes, $type);
}

/**
 * Theme 'Related Members' View
 */
function phptemplate_views_view_list_related_members_prog($view, $nodes, $type) {
  $fields = _views_get_fields();

  foreach ($nodes as $i => $node) {
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';

    foreach ($view->field as $id => $field) {
      $name = $field['field']; 
      $val = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      $vars[$name] = $val;
    }
    $vars['name'] = theme('truncated_user', 
			  $node->node_data_field_full_name_field_full_name_value, 
			  $node->node_title, $node->users_uid, 16);
    if ($vars['field_one_liner_value']) {
      // show only a single text field in block. 
      $vars['body'] = '';
      $vars['field_one_liner_value'] = truncate_utf8d($vars['field_one_liner_value'], 48, TRUE, TRUE );
    }
    // align the author picture to the block size
    $account = user_load(array('uid' => $node->users_uid));
    if ($account) {
      $vars['picture'] = theme('user_picture', $account, 'block');
    }
    $items[] = _phptemplate_callback('views-list-related_members_prog', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

/**
 * Theme 'My Way Members' View
 */
function phptemplate_views_view_list_myway_prog($view, $nodes, $type) {
  $fields = _views_get_fields();

  //    firep($view, 'views');
  //    firep($nodes, 'nodes');

  foreach ($nodes as $i => $node) {
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';

    foreach ($view->field as $id => $field) {
      $name = $field['field']; 
      $val = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      $vars[$name] = $val;
    }
    $vars['common'] = $node->cnt;
    $vars['name'] = theme('truncated_user', 
			  $node->node_data_field_full_name_field_full_name_value, 
			  $node->node_title, $node->users_uid, 16);
    $vars['body'] = '';
    if ($vars['field_one_liner_value']) {
      // show only a single text field in block. 
      $vars['field_one_liner_value'] = truncate_utf8d($vars['field_one_liner_value'], 27, TRUE, TRUE );
    }
    // align the author picture to the block size
    $account = user_load(array('uid' => $node->users_uid));
    if ($account) {
      $vars['picture'] = theme('user_picture', $account, 'block');
    }
    $items[] = _phptemplate_callback('views-list-related_members_prog', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

function phptemplate_views_view_list_latest_members_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_members_prog($view, $nodes, $type);
}

function phptemplate_views_view_list_front_latest_members_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_members_prog($view, $nodes, $type);
}

function phptemplate_views_view_list_featured_members_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_members_prog($view, $nodes, $type);
}

/**
 * Theme 'Related Blogs' View
 */
function phptemplate_views_view_list_related_blogs_prog($view, $nodes, $type) {
  $fields = _views_get_fields();

  //    firep($view, 'views');
  //    firep($nodes, 'nodes');

  foreach ($nodes as $i => $node) {
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';

    foreach ($view->field as $id => $field) {
      $name = $field['field']; 
      $val = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      $vars[$name] = $val;
    }
    $vars['name'] = theme('truncated_user', 
			  $node->node_data_field_full_name_field_full_name_value, 
			  $node->node_title, $node->users_uid, 16);
    $vars['title'] = theme('truncated_title', $node->node_title, $node->nid, 17);
    // align the author picture to the block size
    $account = user_load(array('uid' => $node->users_uid));
    if ($account) {
      $vars['picture'] = theme('user_picture', $account, 'block');
    }
    $items[] = _phptemplate_callback('views-list-related_blogs_prog', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

function phptemplate_views_view_list_latest_blogs_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_blogs_prog($view, $nodes, $type);
}

function phptemplate_views_view_list_front_latest_blogs_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_blogs_prog($view, $nodes, $type);
}

function phptemplate_views_view_list_featured_blogs_prog($view, $nodes, $type) {
  return phptemplate_views_view_list_related_blogs_prog($view, $nodes, $type);
}

/**
 * Generic function to override list view
 */
function phptemplate_views_view_list_VIEWNAME($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $items[] = _phptemplate_callback('views-list-VIEWNAME', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

/**
 * Blocks of the same type are
 * themed using the same tpl.php file
 */
function creedia_block_types($block) {

  switch ($block->module) {
  case 'cviews':
    switch ($block->delta) {
    case 0: case 1: case 2: case 3: case 4: case 5: case 12: case 13:
      return 'related';
    case 6: case 7: case 8: case 9: case 10: case 11: case 14:
    default:
      return 'front';
    }
  case 'ctaxo': 
    switch ($block->delta) {
    case 1: case 2: case 4:
      return 'taxo-images';
    case 3:
      return 'taxo-tagadelic';
    }
    break;
  case 'creedia':
    switch ($block->delta) {
    case 0: case 1: case 2: case 3: case 4: case 5: case 7:
      return 'action';
    case 6:
      return 'feedback';
    }
    break;
  case 'cfront':
    switch ($block->delta) {
    case 0:
      return 'register';
    case 1:
      return 'news';
    }
    break;
  case 'feedback':
    switch ($block->delta) {
    default:
      return 'feedback';
    }
  case 'ctwitter':
    switch ($block->delta) {
    default:
      return 'twitter';
    case 2:
      return 'facebook';
    case 3:
      return 'services';
    }
  case 'cdist':
    switch ($block->delta) {
    case 0:
      return 'related';
    }
  }
  return 'default';
}

/*
 * Override phptemplate_block to theme blocks
 * according to type
 */
function tendu_block($block) {

  $block_type = creedia_block_types($block);

  $suggestions[] = 'block';
  $suggestions[] = 'block-'. $block->region;
  $suggestions[] = 'block-'. $block->module;
  $suggestions[] = 'block-'. $block_type;
  $suggestions[] = 'block-'. $block->module .'-'. $block->delta;
  $suggestions[] = 'block-'. $block->type .'-'. $block->delta;

  // firep($block_type .'-'. $block->module , 'blcok type');
  $vars['block_type'] = $block_type;
  if ($block_type == 'front' && in_array($block->delta, array(6,7,8))) {
      $vars['featured'] = TRUE;
  }
  $vars['block'] = $block;
  $vars['scroll_up'] = theme('image', path_to_theme() .'/images/scroll-up.png', '', 
			     t('scroll up to view all terms.'));
  $vars['scroll_down'] = theme('image', path_to_theme() .'/images/scroll-down.png', '', 
			       t('scroll down to view all terms.'));
  return _phptemplate_callback('block', $vars, $suggestions);

}

/*
 * Override theme_blocks (theme.inc) to set different blocks per 
 * node type.
 * 
 * This is the place to change the order (weight) of blocks 
 * per page (e.g. per node type).
 * 
 * It's possible to turn off some blocks here by taking them from
 * the list. However it is better to parse the arguments within
 * the block code and have no output if not relevant. The block
 * theme (block-...tpl.php) doesn't output if the there is no content.
 * 
 */
function phptemplate_blocks($region) {
  $output = '';

  if ($list = block_list($region)) {
    foreach ($list as $key => $block) {
      // $key == <i>module</i>_<i>delta</i>
      $output .= theme('block', $block);
    }
  }

  // Add any content assigned to this region through drupal_set_content() calls.
  $output .= drupal_get_content($region);

  return $output;
}

/**
 * override Fivestar static widget view to formulate a 'my vote:' tool tip.
 * assumptions: Fivestar is configured to print user vote. 
 */
function phptemplate_fivestar_static($rating, $stars = 5) {
  global $user;
  // Add necessary CSS.
  fivestar_add_css();
  if ($user->uid) {
    $labels = variable_get('fivestar_labels_opinion', array());
    $user_label = round($rating/(100/$stars), 0);
    $title =   t('My vote: !vote', array('!vote' => t($labels[$user_label])));
  }
  else {
    $title =   t('Login or Register to vote');
  }

  $output = '';
  $output .= '<div class="fivestar-widget-static fivestar-widget-static-'. $stars .' clear-block" ';
  $output .= 'title="'. $title .'">';
  $numeric_rating = $rating/(100/$stars);
  for ($n=1; $n <= $stars; $n++) {
    $star_value = ceil((100/$stars) * $n);
    $prev_star_value = ceil((100/$stars) * ($n-1));
    $zebra = ($n % 2 == 0) ? 'even' : 'odd';
    $first = $n == 1 ? ' star-first' : '';
    $last = $n == $stars ? ' star-last' : '';
    $output .= '<div class="star star-'. $n .' star-'. $zebra . $first . $last .'">';
    if ($rating < $star_value && $rating > $prev_star_value) {
      $percent = (($rating - $prev_star_value) / ($star_value - $prev_star_value)) * 100;
      $output .= '<span class="on" style="width: '. $percent .'%">';
    }
    elseif ($rating >= $star_value) {
      $output .= '<span class="on">';
    }
    else {
      $output .= '<span class="off">';
    }
    if ($n == 1)$output .= $numeric_rating;
    $output .= '</span></div>';
  }
  $output .= '</div>';
  return $output;
}

/**
 * Fivestar theme function to print out average vote in text form.
 */
function phptemplate_fivestar_average($nid) {
  $current_avg = votingapi_get_voting_result('node', $nid, 'percent', 'vote', 'average');
  $current_count = votingapi_get_voting_result('node', $nid, 'percent', 'vote', 'count');
  $average_value = $current_avg->value;
  $count_value = $current_count->value;

  $output = '<span class="average-rating" title="';
  $output .= $count_value ? format_plural($count_value, '1 vote', '@count votes') : t('No votes yet');
  $output .= '">';
  if (!$average_value) {
    $average_value = 0;
  }
  $output .= t('Rate: !value', array('!value' => round($average_value, 0))) .'</span>';
  return $output;
}

function _ctrace() {
  $trace = debug_backtrace();
  foreach ($trace as $i => $traceline) {
    $functrace .= "#". $i . " ". $traceline['function'];
    $functrace .= " file: ". $traceline['file']; 
    $functrace .= " line: ". $traceline['line'];
    // 	foreach ($traceline['args'] as $j => $tracearg) {
    // 	  $functrace .= " arg#". $j . " ". substr($tracearg, 0, 10);
    // 	}
    $functrace .= "\n";
  }
  firep($functrace, 'func-trace');
  return $functrace;
}

/**
 * Display a node preview for display during node creation and editing.
 *
 * @param $node
 *   The node object which is being previewed.
 *
 * Fix two-step creed creation to work with preview.
 */
function phptemplate_node_preview($node) {
  // convert the saved religion settings from step 1 to the expected CCK format.
  $value = $node->hidden_field_religion_single;
  if ($value) {
    $node->field_religion_single = array('tids' => $value);
    unset($node->hidden_field_religion_single);
  }

  $output = '<div class="preview">';
//   if ($node->teaser && $node->teaser != $node->body) {
//     if ($node->type == 'creed') {
//       drupal_set_message(t('The trimmed version of your post shows what your post looks like when presented in a list of posts or when exported for syndication.'));
//     }
//     else {
//       drupal_set_message(t('The trimmed version of your post shows what your post looks like when promoted to the main page or when exported for syndication. You can insert the delimiter "&lt;!--break--&gt;" (without the quotes) to fine-tune where your post gets split.'));    }
//     $output .= '<h3>'. t('Preview trimmed version') .'</h3>';
//     $output .= node_view(drupal_clone($node), 1, FALSE, 0);
//     $output .= '<h3>'. t('Preview full version') .'</h3>';
//     $output .= node_view($node, 0, FALSE, 0);
//   }
//   else {
    $output .= node_view($node, 0, FALSE, 0);
//   }
  $output .= "</div>\n";

  return $output;
}

/**
 * Add next-slide-on-mouse-click behavior
 *
 *  this inline js sets up the timer for this slideshow
 */
function phptemplate_views_slideshow_div_js($view, $nodes, $type, $items, $div) {
  $divs = '"' . implode('", "', array_keys($items)) . '"';
  $num_divs = sizeof($items);
  $timer_delay = isset($view->slideshow['timer_delay']) ? $view->slideshow['timer_delay'] : variable_get('views_slideshow_default_timer_delay', VIEWS_SLIDESHOW_DEFAULT_TIMER_DELAY);
  $sort = isset($view->slideshow['sort_order']) ? $view->slideshow['sort_order'] : variable_get('views_slideshow_default_sort_order', VIEWS_SLIDESHOW_DEFAULT_SORT_ORDER);
  $fade = isset($view->slideshow['fade']) ? $view->slideshow['fade'] : variable_get('views_slideshow_default_fade', VIEWS_SLIDESHOW_DEFAULT_FADE);
  $fade = $fade ? 'true' : 'false';
  $fade_speed = isset($view->slideshow['fade_speed']) ? $view->slideshow['fade_speed'] : variable_get('views_slideshow_default_fade_speed', VIEWS_SLIDESHOW_DEFAULT_FADE_SPEED);
  $fade_value = isset($view->slideshow['fade_value']) ? $view->slideshow['fade_value'] : variable_get('views_slideshow_default_fade_value', VIEWS_SLIDESHOW_DEFAULT_FADE_VALUE);
  //  $hover = (module_invoke('jq', 'add', 'hoverIntent')) ? 'hoverIntent' : 'hover';
  $js = '
// set the timer data for a view slideshow
$(document).ready(function() {
  // these are the divs containing the elements to be displayed in the main div in rotation or mouseover
  slideshow_data["' . $div . '"] = new views_slideshow_data(' . $num_divs . ', ' . $timer_delay . ', ' . $sort . ', ' . $fade . ', "' . $fade_speed . '", ' . $fade_value . ');

  views_slideshow_init("'. $div .'");

});
';
  return $js;
}


/**
 * Theme the display of the entire link set
 */
function phptemplate_link_widget_form($element) {
  drupal_add_css(drupal_get_path('module', 'link') .'/link.css');
  // Check for multiple (output normally).
  if (isset($element[1])) {
    $output = drupal_render($element);
  }
  // Add the field label to the 'Title' and 'URL' labels.
  else {
    if (isset($element[0]['title'])) {
      $element[0]['title']['#title'] = t('Title');
      $element[0]['url']['#title'] = $element['#title'];
    }
    else {
      $element[0]['url']['#title'] = $element['#title'];
    }
    $element[0]['#description'] = $element['#description'];
    $element[0]['#type'] = 'item';
    $output = drupal_render($element[0]);
  }

  return $output;
}

/**
 * Theme the display of a single form row
 */
function phptemplate_link_widget_form_row($element) {
  $output = '';
  $output .= '<div class="link-field-row clear-block"><div class="link-field-subrow clear-block">';
  $output .= '<div class="link-field-url' . ($element['title'] ? ' link-field-column' : '') . '">' . drupal_render($element['url']) . '</div>';
  if ($element['title']) {
    $output .= '<div class="link-field-title link-field-column">' . drupal_render($element['title']) . '</div>';
  }
  $output .= '</div>';
  if ($element['attributes']) {
    $output .= '<div class="link-attributes">' . drupal_render($element['attributes']) . '</div>';
  }
  $output .= drupal_render($element);
  $output .= '</div>';
  return $output;
}

/**
 * Themeable message body
 */
function phptemplate_mimemail_message($body, $mailkey = null) {

  $output = '<html><head>';
  $output .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

  $output .= '<style type="text/css">body,.backgroundTable{background-color:#F7F7F7;}#contentTable{border:0px none #000000;margin-top:10px;}.headerTop{background-color:#F7F7F7;border-top:0px none #000000;border-bottom:0px none #FFFFFF;text-align:center;padding:0px;}.adminText{font-size:10px;color:#663300;line-height:200%;font-family:Verdana;text-decoration:none;}.headerBar{background-color:#FFFFFF;border-top:0px none #333333;border-bottom:0px none #FFFFFF;padding:0px;}.headerBarText{color:#333333;font-size:30px;font-family:Verdana;font-weight:normal;text-align:left;}.title{font-size:24px;font-weight:bold;color:#8b0000;font-family:Georgia;line-height:150%;}.subTitle{font-size:14px;font-weight:bold;color:#000000;font-style:normal;font-family:Georgia;}.defaultText{font-size:12px;color:#333333;line-height:150%;font-family:Verdana;background-color:#FFFFFF;padding:20px;border:0px none #FFFFFF;}.footerRow{background-color:#cccccc;border-top:0px none #FFFFFF;padding:20px;}.footerText{font-size:10px;color:#333333;line-height:100%;font-family:Verdana;}a,a:link,a:visited{color:#800000;text-decoration:underline;font-weight:normal;}.headerTop a{color:#663300;text-decoration:none;font-weight:normal;}.footerRow a{color:#800000;text-decoration:underline;font-weight:normal;}</style>';

  $output .= '</head>';
  $output .= '<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="background-color: #F7F7F7;">';

  // background Table
  $output .= '<table width="100%" cellspacing="0" class="backgroundTable" style="background-color: #F7F7F7;">';
  $output .= '<tr>';
  $output .= '<td valign="top" align="center">';

  // Content Table
  $output .= '<table id="contentTable" cellspacing="0" cellpadding="0" width="600" style="border: 0px none #000000;margin-top: 10px;">';
  $output .= '<tr>';
  $output .= '<td class="mailBanner" align="center" style="background-color: #F7F7F7;border-top: 0px none #000000;border-bottom: 0px none #FFFFFF;text-align: center;padding: 0px;">';
  $output .= '<div>';
  $output .= theme('imagecache', 'mailbanner', path_to_theme() .'/images/email-banner.jpeg', 'Creedia');
  $output .= '</div>';
  $output .= '</td>';
  $output .= '</tr>';

  $output .= '<tr>';
  $output .= '<td class="mailBody" align="center" style="background-color: #F7F7F7;border-top: 0px none #000000;border-bottom: 0px none #FFFFFF;text-align: left;padding: 0px; margin-top: 10px;">';
  $output .= '<div>';
  $output .= $body;
  $output .= '</div>';
  $output .= '</td>';
  $output .= '</tr>';

  $output .= '<tr>';
  $output .= '<td class="mailfooter" align="center" style="background-color: #F7F7F7;border-top: 0px none #000000;border-bottom: 0px none #FFFFFF;text-align: center;padding: 0px; margin-top: 10px;">';
  $output .= '<div>';
  $output .= '<p>';
  $output .= variable_get('site_mission', t('!site is an online community of individuals seeking to connect on values and beliefs.', 
					    array('!site' => l('Creedia', '', array(), NULL, NULL, TRUE)) ));
  $output .= '</p>';
  $output .= '<p>';
  $output .= l('Members', '/members', array('style' => 'padding-right:10px;'), NULL, NULL, TRUE);
  $output .= l('Creeds', '/creeds', array('style' => 'padding-right:10px;'), NULL, NULL, TRUE);
  $output .= l('Blogs', '/blogs', array('style' => 'padding-right:10px;'), NULL, NULL, TRUE);
  $output .= l('Discussions', '/opinions', array('style' => 'padding-right:10px;'), NULL, NULL, TRUE);
  $output .= l('Join', '/user/register', array('style' => 'padding-right:10px;'), NULL, NULL, TRUE);
  $output .= '</p>';
  $output .= '</div>';
  $output .= '</td>';
  $output .= '</tr>';

  $output .= '</table>';

  $output .= '</td>';
  $output .= '</tr>';
  $output .= '</table>';

  $output .= '</body>';
  $output .= '</html>';
 
//   // attempt to include a mail-specific version of the css.
//   // if you want smaller mail messages, add a mail.css file to your theme
//   $styles = path_to_theme() .'/mail.css';

//   $output .= '<style type="text/css"><!--';
//   if (!file_exists($styles)) {
//     // embed a version of all style definitions
//     $styles = preg_replace('|<style.*"'. base_path() .'([^"]*)".*|', '\1', drupal_get_css());
//   }
//   foreach (explode("\n", $styles) as $style) {
//     $output .= file_get_contents($style);
//   }
//  $output .= '--></style></head><body id="mimemail-body"><div id="center"><div id="main">'. $body .'</div></div></body></html>';

  // compress output
  return preg_replace('/\s+|\n|\r|^\s|\s$/', ' ', $output);
}
