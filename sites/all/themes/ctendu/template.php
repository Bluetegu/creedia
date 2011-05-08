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
//drupal_rebuild_theme_registry();


/**
 * Implementation of hook_theme
 */
function ctendu_theme() {
  return array(
    'term' => array(
      'file' => 'template.php',
      'arguments' => array(
        'term' => NULL,
        'format' => '',
        'path' => '',
        'parent' => NULL
      ),
    ),
    'religion' => array(
      'file' => 'template.php',
      'arguments' => array(
        'term' => NULL,
        'format' => '',
        'path' => '',
      ),
    ),
    'movement' => array(
      'file' => 'template.php',
      'arguments' => array(
        'term' => NULL,
        'parent' => NULL,
        'format' => '',
        'path' => '',
      ),
    ),
    'beliefset' => array(
      'file' => 'template.php',
      'arguments' => array(
        'term' => NULL,
        'format' => '',
        'path' => '',
      ),
    ),
    'freetag' => array(
      'file' => 'template.php',
      'arguments' => array(
        'term' => NULL,
        'format' => '',
        'path' => '',
      ),
    ),
    'country' => array(
      'file' => 'template.php',
      'arguments' => array(
        'term' => NULL,
        'format' => '',
        'path' => '',
      ),
    ),
    'gender' => array(
      'file' => 'template.php',
      'arguments' => array(
        'term' => NULL,
        'format' => '',
        'path' => '',
      ),
    ),
    'origin_statement' => array(
      'file' => 'template.php',
      'arguments' => array(
        'node' => NULL,
        'one' => FALSE,
        'trim' => 0,
        'num' => 0,
        'hidden' => FALSE
      ),
    ),
    'opinion_image' => array(
      'file' => 'template.php',
      'arguments' => array(
        'node' => NULL,
        'page' => TRUE,
      ),
    ),
    'interpretation_wrapper' => array(
      'file' => 'template.php',
      'arguments' => array(
        'content' => NULL,
        'num' => 0,
      ),
    ),
    'truncated_user' => array(
      'file' => 'template.php',
      'arguments' => array(
        'fullname' => '',
        'username' => '',
        'uid' => 0,
        'len' => 0,
      ),
    ),
    'truncated_title' => array(
      'file' => 'template.php',
      'arguments' => array(
        'title' => '',
        'nid' => 0,
        'len' => 0,
      ),
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
function theme_term($term, $format = 'image', $path = 'members/featured', $parent = NULL) {
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
 * Theme origin statement
 *
 * @param $node     creed node
 * @param $one      If TRUE, only the $num statement is rendered.
 * @param $trim     If non-zero indicate the number of characters to trim the statements
 * @param $num      If $one is true, $num indicates the statement number to print.
 * @param $hidden   If $hidden is true, all statements apart from $num will be hidden
 *                  (make sense only if $one = false)
 */
function theme_origin_statement($node, $one = FALSE, $trim = 0, $num = 0, $hidden = FALSE) {
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
function theme_opinion_image($node, $page = TRUE) {
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
function theme_truncated_title($title, $nid, $len) {
  return l(truncate_utf8($title, $len, TRUE, TRUE), 'node/'.$nid, array('attributes' => array('title' => $title )));
}

/**
 * Truncated user link
 */
function theme_truncated_user($fullname, $username, $uid, $len) {
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
 * enable hook_link_alter for comments by overriding comments theming functions
 * see http://drupal.org/node/169890
 */
function ctendu_comment_flat_expanded($comment) {
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
function theme_interpretation_wrapper($content, $num) {

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



/**
 * Preprocess varialbles for nodes
 *
 * @param $variables
 */
function ctendu_preprocess_node(&$variables) {
  $i = 1;
  //dpr($variables);
}


