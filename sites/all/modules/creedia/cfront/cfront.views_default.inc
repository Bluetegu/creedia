<?php
//$Id:
/**
 * Default cfront Views
 */

/**
 * Implementation of hook_views_default_views()
 */
function cfront_views_default_views() {
  $views = array();

  $view = cfront_slideshow_default_view();
  $views[$view->name] = $view;

  return $views;
}

/**
 * Exported slideshow front view
 * Note: Set disable = TRUE view after exporting
 */
function cfront_slideshow_default_view() {
  $view = new view;
  $view->name = 'slideshow_front';
  $view->description = 'Front Slideshow';
  $view->tag = '';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = TRUE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('fields', array(
  'field_image_fid' => array(
    'label' => '',
    'alter' => array(
      'alter_text' => 0,
      'text' => '',
      'make_link' => 0,
      'path' => '',
      'link_class' => '',
      'alt' => '',
      'prefix' => '',
      'suffix' => '',
      'target' => '',
      'help' => '',
      'trim' => 0,
      'max_length' => '',
      'word_boundary' => 1,
      'ellipsis' => 1,
      'html' => 0,
      'strip_tags' => 0,
  ),
    'empty' => '',
    'hide_empty' => 0,
    'empty_zero' => 0,
    'link_to_node' => 0,
    'label_type' => 'custom',
    'format' => 'slideshow_front_default',
    'multiple' => array(
      'group' => TRUE,
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_reversed' => FALSE,
  ),
    'exclude' => 0,
    'id' => 'field_image_fid',
    'table' => 'node_data_field_image',
    'field' => 'field_image_fid',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('sorts', array(
  'field_front_num_value' => array(
    'order' => 'ASC',
    'delta' => -1,
    'id' => 'field_front_num_value',
    'table' => 'node_data_field_front_num',
    'field' => 'field_front_num_value',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('filters', array(
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'image_cck' => 'image_cck',
  ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'type',
    'table' => 'node',
    'field' => 'type',
    'relationship' => 'none',
  ),
  'field_front_num_value' => array(
    'operator' => '>',
    'value' => array(
      'value' => '0',
      'min' => '',
      'max' => '',
  ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'field_front_num_value',
    'table' => 'node_data_field_front_num',
    'field' => 'field_front_num_value',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('access', array(
  'type' => 'none',
  ));
  $handler->override_option('cache', array(
  'type' => 'none',
  ));
  $handler->override_option('use_ajax', TRUE);
  $handler->override_option('items_per_page', 17);
  $handler->override_option('use_pager', '1');
  $handler->override_option('style_plugin', 'slideshow');
  $handler->override_option('style_options', array(
  'type' => 'ol',
  'mode' => 'views_slideshow_singleframe',
  'views_slideshow_singleframe-prefix' => '',
  'views_slideshow_singleframe' => array(
    'timeout' => '3000',
    'delay' => '0',
    'speed' => '700',
    'start_paused' => 0,
    'fixed_height' => '1',
    'random' => '0',
    'pause' => '1',
    'pause_on_click' => '0',
    'pause_when_hidden' => 0,
    'pause_when_hidden_type' => 'full',
    'amount_allowed_visible' => '',
    'remember_slide' => 0,
    'remember_slide_days' => '1',
    'controls' => '0',
    'pager' => '0',
    'pager_type' => 'Thumbnails',
    'pager_hover' => '1',
    'pager_click_to_page' => 0,
    'image_count' => '0',
    'items_per_slide' => '1',
    'effect' => 'fade',
    'sync' => '1',
    'nowrap' => '0',
    'advanced' => 'next: \'#views_slideshow_singleframe_main_slideshow_front-page_1\'',
    'ie' => array(
      'cleartype' => 'true',
      'cleartypenobg' => 'false',
  ),
  ),
  ));
  $handler = $view->new_display('page', 'Page', 'page_1');
  $handler->override_option('path', 'slideshow');
  $handler->override_option('menu', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
  ));

  return $view;
}
