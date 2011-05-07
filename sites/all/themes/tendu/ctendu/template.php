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
 * Preprocess varialbles for nodes
 *
 * @param $variables
 */
function ctendu_preprocess_node(&$variables) {
  $i = 1;
  //dpr($variables);
}


