<?php
// $Id: template.php,v 1.1.2.1.2.5 2009/01/24 18:31:51 tombigel Exp $
/**
 * Tendu Default Design - Based on Tendu - CSS Theme For Developers
 * Author: Tom Bigelajzen (http://drupal.org/user/173787) - http://tombigel.com
 */

/**
 * Force refresh of theme registry.
 * DEVELOPMENT USE ONLY - COMMENT OUT FOR PRODUCTION
 */
drupal_rebuild_theme_registry();


/**
 * Implementation of hook_theme
 */
function ctendu_theme($existing, $type, $theme, $path) {
  return array(
    'term' => array(
      'arguments' => array('term' => NULL, 'format' => '', 'path' => '', 'parent' => NULL),
    ),
    'religion' => array(
      'arguments' => array('term' => NULL, 'format' => '', 'path' => ''),
    ),
    'movement' => array(
      'arguments' => array('term' => NULL, 'parent' => NULL, 'format' => '', 'path' => ''),
    ),
    'beliefset' => array(
      'arguments' => array('term' => NULL, 'format' => '', 'path' => ''),
    ),
    'freetag' => array(
      'arguments' => array('term' => NULL, 'format' => '', 'path' => ''),
    ),
    'country' => array(
      'arguments' => array('term' => NULL, 'format' => '', 'path' => ''),
    ),
    'gender' => array(
      'arguments' => array('term' => NULL, 'format' => '', 'path' => ''),
    ),
    'origin_statement' => array(
      'arguments' => array(
        'node' => NULL,
        'one' => FALSE,
        'trim' => 0,
        'num' => 0,
        'hidden' => FALSE
      ),
    ),
    'opinion_image' => array(
      'arguments' => array(
        'node' => NULL,
        'page' => TRUE,
      ),
    ),
    'truncated_user' => array(
      'arguments' => array(
        'fullname' => '',
        'username' => '',
        'uid' => 0,
        'len' => 0,
      ),
    ),
    'truncated_title' => array(
      'arguments' => array(
        'title' => '',
        'nid' => 0,
        'len' => 0,
      ),
    ),
    'pager_result' => array(
      'arguments' => array(),
    ),
    'fivestar_average' => array(
      'arguments' => array(),
    ),
  );
}

/**
 * Theme Taxonomy Terms
 * Depends on taxonomy_image module
 *
 * @param $term     term id
 * @param $format   output format (name of image_cache profile when applicable)
 * @param $path
 * @param $parent   pointer to parent term
 */
function ctendu_term($term, $format = 'image', $path = 'members/featured', $parent = NULL) {
  switch ($format) {
  case 'link':
    $output = l($term->name, $path . $term->tid, array('attributes' => array('title' => $term->description)));
    break;
  case 'image':
    $image = taxonomy_image_display($term->tid);
    if ($image) {
      $output = $image;
    }
    else {
      $output = theme('term', $term, 'link', $path, NULL);
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
      $output .= l($term->name, $path . $term->tid, array('attributes' => array('title' => $term->description)));
    }
    else {
      $image = taxonomy_image_display($term->tid);
      $output .= $image ? $image : $term->name;
      $output .= l($term->name, $path . $term->tid, array('attributes' => array('title' => $term->description, 'style' => 'display:none')));
    }
    break;
  case 'both':
    if ($parent) {
      $image = taxonomy_image_display($parent->tid);
    }
    else {
      $image = taxonomy_image_display($term->tid);
    }
    $output .= $image . l($term->name, $path . $term->tid, array('attributes' => array('title' => $term->description)));
    break;
  case 'breadcrumb':
    $rel = l($parent->name, $path . $parent->tid, array('attributes' => array('title' => $parent->description)));
    $mov = l($term->name, $path . $term->tid, array('attributes' => array('title' => $term->description)));
    $output = theme('breadcrumb', array($mov, $rel));
    break;
  case 'tagadelic':
    $output = l($term->name, $path . $term->tid, array('attributes' => array('title' => $term->description, 'class' => "tagadelic level$term->weight")));
    break;
  default:
    $output = $term->name;
    break;
  }
  return $output;
}

/**
 * Macros to theme_term
 */
function ctendu_religion($term, $format, $path = 'members/featured/') {
  return theme('term', $term, $format, $path);
}
function ctendu_movement($term, $parent, $format, $path = 'members/featured/'){
  return theme('term', $term, $format, $path, $parent);
}
function ctendu_beliefset($term, $format='image', $path = 'members/featured/'){
  return theme('term', $term, $format, $path);
}
function ctendu_freetag($term, $format='link', $path = 'opinions/featured/') {
  return theme('term', $term, $format, $path);
}
function ctendu_country($term, $format='link', $path = 'members/featured/') {
  return theme('term', $term, $format, $path);
}
function ctendu_gender($term, $format='link', $path = 'members/featured/') {
  return theme('term', $term, $format, $path);
}

/**
 * Theme origin statement
 *
 * @param $node     creed node
 * @param $one      If TRUE, only the $num statement is rendered.
 * @param $trim     If non-zero indicate the number of characters to trim the statements
 * @param $num      If $one is true, $num indicates the statement number to print.
 * @param $hidden   If $hidden is true, all statements apart from $num will be hidden
 *                  (make sense only if $one = false)
 */
function ctendu_origin_statement($node, $one = FALSE, $trim = 0, $num = 0, $hidden = FALSE) {
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
      $dir = i18n_language_property($lang, 'direction') == LANGUAGE_LTR ? 'ltr' : 'rtl';
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
 * Theme opinion/interpretation image.
 * Pick either the embedded (referenced) image, video, audio
 * or uploaded image.
 *
 */
function ctendu_opinion_image($node, $page = TRUE) {
  $output = '';

  // Prepare the right image size in advance
  $image = $node->field_opinion_image[0]['view'];
  $audio = $node->field_opinion_audio[0]['filepath'];
  $em_picture = $node->field_opinion_em_picture[0]['view'];
  $em_video = $node->field_opinion_em_video[0]['view'];
  $em_audio = $node->field_opinion_em_audio[0]['view'];

  if ($image) {
    $output .= $image;
  }
  elseif ($audio) {
    if ($page) {
      $output .= swf('../'. $audio, FALSE, FALSE, FALSE, array('player' => 'onepixelout'));
    }
    else {
      $output .= swf('../'. $audio, array('width' => '60', 'height' => '62'));
    }
  }
  elseif ($em_picture) {
    // default picture is saved in em_picture.
    $output .= $em_picture;
  }
  elseif ($em_audio) {
    $output .= $em_audio;
  }
  elseif ($em_video) {
    // for some unknown reason, em_video inserts a 'view viedo' link even if no em video is selected
    // so I'm setting it to be the last one, such that it won't override real images.
    $output .= $em_video;
  }

  return $output;
}

/**
 * Truncated title link
 */
function ctendu_truncated_title($title, $nid, $len) {
  return l(truncate_utf8d($title, $len, TRUE, TRUE), 'node/'.$nid, array('attributes' => array('title' => $title )));
}

/**
 * Theme the pager results
 * @params pager_limit - max number of nodes per page.
 * @params i - pager index
 */
function ctendu_pager_result($pager_limit = CREEDIA_NODES_PER_PAGE, $i = 0) {

  global $pager_page_array;  // current page number
  global $pager_total_items; // total items paged
  global $pager_total;       // number of pages

  if ($pager_total[$i]) {
    // Multiply pager_limit by page number (eg 0, 15, 30) and add 1 to get first item
    $start = 1 + ($pager_page_array[$i] * $pager_limit);

    // Multiply pager_limit by page number + 1 (eg 15, 30, 45) to get last item
    $end = (1 + $pager_page_array[$i]) * $pager_limit;
    // Use total items count if this is less than that
    if ($end > $pager_total_items[$i]) {
      $end = $pager_total_items[$i];
    }
    $content =  t('Results %start-%end of %total',
      array('%start' => $start, '%end' => $end, '%total' => $pager_total_items[$i]));
  }
  return '<span class="pager-result">'. $content .'</span>';
}

/**
 * Truncated user link
 */
function ctendu_truncated_user($fullname, $username, $uid, $len) {
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
  return l(truncate_utf8d($name, $len, TRUE, TRUE), 'user/'.$uid, array('attributes' => array('title' => $name )));
}

/*
 * Theme out the usercomment form (override usercomment theming)
 */
function ctendu_usercomment($content) {
  $output = '<div id="usercomments">';
  $output .= theme('comment_wrapper', $content);
  $output .= "</div>";
  return $output;
}

/*
 * Theme out the empty usercomment form (override usercomment theming)
 */
function ctendu_usercomment_empty() {
  $output = '<div id="usercomments-empty">';
  $output .= "</div>";
  return $output;
}

/**
 * Allow themable wrapping of all comments.
 */
function ctendu_comment_wrapper($content) {
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
 * Logintoboggan: Add link to my profile
 */
function ctendu_lt_loggedinblock() {
  global $user;
  $output = l(t('Log out'), 'logout', array('title' => t('logout')));
  $output .= l(t('My account'), 'user/'.$user->uid,
         array('title' => t('!name account',array('!name' => $user->name))));
  return $output;
}

/**
 * Logintoboggan: Remove the register to a separate block in front page
 */
function ctendu_lt_login_link() {
  // Only display register text if registration is allowed.
  if (variable_get('user_register', 1) && !drupal_is_front_page()) {
    return t('Login/Register');
  }
  else {
    return t('Login');
  }
}

/**
 * override Fivestar static widget view to formulate a 'my vote:' tool tip.
 * assumptions: Fivestar is configured to print user vote.
 */
function ctendu_fivestar_static($rating, $stars = 5, $tag = 'vote') {
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
  $output .= '<div class="fivestar-widget-static fivestar-widget-static-'. $tag .' fivestar-widget-static-'. $stars .' clear-block"';
  $output .= 'title="'. $title .'">';
  if (empty($stars)) {
    $stars = 5;
  }
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
 * This is not an override function.
 */
function ctendu_fivestar_average($nid) {
  $votes = fivestar_get_votes('node', $nid);
  $average_value = $votes['average']['value'];
  $count_value = $votes['count']['value'];

  $output = '<span class="average-rating" title="';
  $output .= $count_value ? format_plural($count_value, '1 vote', '@count votes') : t('No votes yet');
  $output .= '">';
  if (!$average_value) {
    $average_value = 0;
  }
  $output .= t('Rate: !value', array('!value' => round($average_value, 0))) .'</span>';
  return $output;
}

/**
 * Override theme_links (includes/theme.inc)
 * Function copied as is. Only change is add handling of 'pre' attribute
 * added using hook_links_alter by creedia.module
 */
function ctendu_links($links, $attributes = array('class' => 'links')) {
  global $language;
  $output = '';

  if (count($links) > 0) {
    $output = '<ul'. drupal_attributes($attributes) .'>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = $key;

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
          && (empty($link['language']) || $link['language']->language == $language->language)) {
        $class .= ' active';
      }
      $output .= '<li'. drupal_attributes(array('class' => $class)) .'>';

      // add pre if available
      if (isset($link['pre'])) {
        $output .= $link['pre'];
      }

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      else if (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span'. $span_attributes .'>'. $link['title'] .'</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}

/**
 * Replace links with images (flag module) per http://drupal.org/node/305061
 */
function ctendu_preprocess_flag(&$vars) {
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
 * Add 'Results i-j of N' hidden message.
 * Ajax code extract the message to update the pager results in page.
 */
function ctendu_preprocess_views_view(&$vars) {
  $view = $vars['view'];
  $vars['pager_result'] = theme('pager_result', $view->pager['items_per_page']);
  return;
}

/**
 * Node varialbles preprocess
 * @param $vars
 */
function ctendu_preprocess_node(&$vars) {
  global $user;
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
    $featured = theme('imagecache', 'featured', path_to_theme() . '/images/featured.png', '', $ftitle);

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
      $vars['adopt_text'] = t('Adopted: !count', array('!count' => $counts['adopt'] ? $counts['adopt'] : 0 ));
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
        //  $twitter_url = theme('image', path_to_theme() .'/images/twitter.png');
        $twitter_url .= l($twittername, 'http://twitter.com/'. $twittername);
        $vars['twittername'] = $twitter_url;
      }
      $vars['twittername_label'] = t('Twitter ');

      if ($user->uid) {
        $vars['common'] = cdist_dist($node->uid);
      }
      break;
  }
  return;
}

/**
 * Helper function for preprocess page
 * @param $node   member node
 */
function _ctendu_member_title($node) {
  $name = $node->field_full_name[0]['value'];
  return $name ? $name : $node->title;
}

/**
 * Page varialbles preprocess
 * @param $vars
 */
function ctendu_preprocess_page(&$vars) {
  global $user;
  /* Add classes to the "body" tag, for easier layout styling
   * Idea taken from ZEN theme (but my changes make it incompatible with it)
   */
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
  elseif (arg(0) == 'user') {
    $body_classes[] = 'tabs-user-style';
  }
  $vars['body_classes'] = implode(' ', $body_classes); // Concatenate with spaces

  // add pager results
  if (in_array(arg(0), array('gallery','gallery3'))) {
    $pager_result = theme('pager_result', CREEDIA_IMAGES_PER_GALLERY);
  }
  else {
    $pager_result = theme('pager_result');
  }
  if (in_array(arg(0), array('creeds','opinions','members', 'blogs', 'deeds'))) {
    $vars['tabs'] = $pager_result . '<span id="tabs-title">'. t('Sort by:') .'</span>'. $vars['tabs'];
  }
  elseif (in_array(arg(0), array('gallery','gallery3', 'taxonomy', 'blog'))) {
    $vars['tabs'] = $pager_result . $vars['tabs'];
  }

  // rewrite title
  $breadcrumb = '';
  $background = FALSE;
  $use_title = TRUE;
  $class = arg(0);
  if (drupal_is_front_page()) {
    $title = $vars['site_slogan'];
  }
  elseif (arg(0) == 'node'){
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
            //    case 'member':
            //      $title = member_title($node);
            //      break;
          case 'blog': case 'dblog':
            $class = 'Blog';
            break;
        }
      }
    }
    elseif (arg(1) == 'add' && arg(2) == 'interpretation') {
      $title = t(ucfirst(arg(2)));
    }
  }
  elseif (arg(0) == 'user') {
    $background = TRUE;
    if (is_numeric(arg(1))) {
      $uid = arg(1);
      $class = 'Members';
      $node = content_profile_load('member', $uid);
      if ($node) {
        $title = _ctendu_member_title($node);
      }
    }
    else {
      $class = 'Creedia';
      $title = ucfirst(arg(1));
    }
  }
  elseif (arg(0) == 'comment') {
    $class = t('Comments');
    $title = arg(1) ? ucfirst(arg(1)) : '';
  }
  elseif (in_array(arg(0), array('creeds', 'opinions', 'members', 'gallery', 'taxonomy', 'blogs', 'deeds'))){
    if (arg(0) == 'opinions') {
      $class = 'Discussions';
    }
    $use_title = FALSE;
  }
  elseif (arg(0) == 'blog') {
    $class = 'Creedia';
    $title = t('Company Blog');
  }
  elseif (arg(0) == 'admin') {
    $breadcrumb = $vars['breadcrumb'];
  }
  else {
    $background = TRUE;
    $class = 'Creedia';
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
  return;
}

/**
 * Helper function for block preprocess. Blocks of the same type are themed alike.
 */
function _ctendu_block_types($block, &$featured) {
  $featured = FALSE;

  switch ($block->module) {
  case 'cviews':
    switch ($block->delta) {
    case 0: case 1: case 2: case 3: case 4: case 5: case 12: case 13:
      return 'related';
    case 6: case 7: case 8:
      $featured = TRUE;
      return 'front';
    case 9: case 10: case 11: case 14:
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
    case 0: case 1: case 2: case 3: case 4: case 5: case 6:
      return 'action';
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

/**
 * Block variables preprocess
 * @vars   variables
 */
function ctendu_preprocess_block(&$vars) {
  $block = $vars['block'];
  $block_type = _ctendu_block_types($block, $featured);
  $vars['block_type'] = $block_type;
  $vars['featured'] = $featured;

  $vars['scroll_up'] = theme('image', path_to_theme() .'/images/scroll-up.png', '',
           t('scroll up to view all terms.'));
  $vars['scroll_down'] = theme('image', path_to_theme() .'/images/scroll-down.png', '',
           t('scroll down to view all terms.'));

  $vars['template_files'][] = 'block';
  $vars['template_files'][] = 'block-'. $block->region;
  $vars['template_files'][] = 'block-'. $block->module;
  $vars['template_files'][] = 'block-'. $block_type;
  $vars['template_files'][] = 'block-'. $block->module .'-'. $block->delta;
  $vars['template_files'][] = 'block-'. $block->type .'-'. $block->delta;

  return;
}

/**
 * views Creed blocks preprocess
 */
function ctendu_preprocess_views_view_fields__Creed_blocks(&$vars) {
  $node = new stdClass();
  $node->nid = $vars['fields']['nid']->raw;
  $node->vid = $vars['fields']['vid']->raw;
  $node->title = $vars['fields']['title']->raw;
  $religion = array();
  $terms = taxonomy_node_get_terms_by_vocabulary($node, CREEDIA_RELIGION_VID);
  foreach($terms as $term) {
    $religion[] = theme('religion', $term, 'image');
  }
  $beliefset = array();
  $terms = taxonomy_node_get_terms_by_vocabulary($node, CREEDIA_BELIEFSET_VID);
  foreach($terms as $term) {
    $beliefset[] = theme('beliefset', $term, 'image');
  }
  $vars['religion'] = $religion;
  $vars['beliefset'] = $beliefset;
  $vars['title'] = theme('truncated_title', $node->title, $node->nid, 32);
}

/**
 * views Member blocks preprocess
 */
function ctendu_preprocess_views_view_fields__Member_blocks(&$vars) {
  $full_name = $vars['fields']['field_full_name_value']->raw;
  $one_liner = $vars['fields']['field_one_liner_value']->raw;
  $title = $vars['fields']['title']->raw;
  $uid = $vars['fields']['uid']->raw;
  $cnt = $vars['fields']['cnt']->content;
  $teaser = $vars['fields']['teaser']->content;

  $vars['common'] = $cnt;
  $vars['name'] = theme('truncated_user', $full_name, $title, $uid, 16);
  if ($one_liner) {
    // show only a single text field in block.
    $vars['one_liner'] = truncate_utf8d($one_liner, $cnt ? 36 : 48, TRUE, TRUE );
  }
  else {
    $vars['body'] = $teaser;
  }
  // align the author picture to the block size
  $account = user_load(array('uid' => $uid));
  if ($account) {
    $vars['picture'] = theme('user_picture', $account, 'block');
  }
}

/**
 * views Blog blocks preprocess
 */
function ctendu_preprocess_views_view_fields__Blog_blocks(&$vars) {
  $title = $vars['fields']['title']->raw; // if content is used we get double check_plain
  $uid = $vars['fields']['uid']->raw;
  $nid = $vars['fields']['nid']->raw;
  $teaser = $vars['fields']['teaser']->content;

  $vars['title'] = theme('truncated_title', $title, $nid, 32);
  $vars['body'] = $teaser;
  // align the author picture to the block size
  $account = user_load(array('uid' => $uid));
  if ($account) {
    $vars['picture'] = theme('user_picture', $account, 'block');
  }
}

/**
 * views Discussion blocks preprocess
 */
function ctendu_preprocess_views_view_fields__Discussion_blocks(&$vars) {
  $node = new stdClass();

  $title = $vars['fields']['title']->raw; // if content is used we get double check_plain
  $nid = $vars['fields']['nid']->raw;
  $teaser = $vars['fields']['teaser']->content;

  $node->nid = $nid;
  $node->field_opinion_image[0]['view'] = $vars['fields']['field_opinion_image_fid']->content;
  $node->field_opinion_em_picture[0]['view'] = $vars['fields']['field_opinion_em_picture_embed']->content;
  $node->field_opinion_em_video[0]['view'] = $vars['fields']['field_opinion_em_video_embed']->content;
  if ($vars['fields']['field_opinion_em_audio_embed']->raw) {
    $node->field_opinion_em_audio[0]['view'] = $vars['fields']['field_opinion_em_audio_embed']->content;
  }
//      // There is a bug I could not trace which doesn't set thumbnail picture even
//      // if a path for a default thumbnail is set. So, we override it here.
//      if ($val) {
//        $snode->field_opinion_em_audio[0]['view'] = theme('image', path_to_theme() .'/images/audio.png');
//      }

  $vars['opinion_image'] = theme('opinion_image', $node);
  $vars['title'] = theme('truncated_title', $title, $nid, 32);
  $vars['body'] = $teaser;
}

