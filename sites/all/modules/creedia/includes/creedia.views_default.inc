<?php
//$Id:
/**
 * Set up so it can be used as an API to create default calendars for
*/

/**
 * Implementation of hook_views_default_views()
 */
function creedia_views_default_views() {
  $views = array();

  $view = creedia_creeds_default_view();
  $views[$view->name] = $view;

//  $view = creedia_opinions_default_view();
//  $views[$view->name] = $view;

  return $views;
}

/**
 * Exported creeds view
 */
function creedia_creeds_default_view() {
  $view = new view;
  $view->name = 'Creeds';
  $view->description = 'Creeds using exposed filters in node format';
  $view->tag = '';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('relationships', array(
  'flag_count_rel' => array(
    'label' => 'counter',
    'required' => 0,
    'flag' => 'adopt',
    'id' => 'flag_count_rel',
    'table' => 'node',
    'field' => 'flag_count_rel',
    'relationship' => 'none',
    'override' => array(
      'button' => 'Override',
  ),
  ),
  ));
  $handler->override_option('sorts', array(
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'override' => array(
      'button' => 'Override',
  ),
    'relationship' => 'none',
  ),
  'count' => array(
    'id' => 'count',
    'table' => 'flag_counts',
    'field' => 'count',
    'relationship' => 'flag_count_rel',
  ),
  ));
  $handler->override_option('filters', array(
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'creed' => 'creed',
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
  'status' => array(
    'operator' => '=',
    'value' => '1',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'status',
    'table' => 'node',
    'field' => 'status',
    'override' => array(
      'button' => 'Override',
  ),
    'relationship' => 'none',
  ),
  'field_religion_single_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 1,
      'operator' => 'religion_op',
      'identifier' => 'religion',
      'label' => 'Traditions & Philosophies',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'id' => 'field_religion_single_value',
    'table' => 'node_data_field_religion_single',
    'field' => 'field_religion_single_value',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
  ),
  'field_beliefset_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 1,
      'operator' => 'beliefset_op',
      'identifier' => 'beliefset',
      'label' => 'Category',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'id' => 'field_beliefset_value',
    'table' => 'node_data_field_beliefset',
    'field' => 'field_beliefset_value',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
  ),
  ));
  $handler->override_option('access', array(
  'type' => 'none',
  ));
  $handler->override_option('cache', array(
  'type' => 'none',
  ));
  $handler->override_option('title', 'Creeds');
  $handler->override_option('empty', 'No creed statement tagged with selected terms.');
  $handler->override_option('empty_format', '4');
  $handler->override_option('use_ajax', TRUE);
  $handler->override_option('use_pager', '1');
  $handler->override_option('distinct', 1);
  $handler->override_option('style_options', NULL);
  $handler->override_option('row_plugin', 'node');
  $handler->override_option('exposed_block', TRUE);
  $handler = $view->new_display('page', 'Main', 'page_1');
  $handler->override_option('sorts', array(
  'count' => array(
    'order' => 'DESC',
    'id' => 'count',
    'table' => 'flag_counts',
    'field' => 'count',
    'relationship' => 'flag_count_rel',
  ),
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'day',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'override' => array(
      'button' => 'Override',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'creeds');
  $handler->override_option('menu', array(
  'type' => 'none',
  'title' => 'Popular',
  'description' => '',
  'weight' => '0',
  'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
  ));
  $handler = $view->new_display('page', 'By Name', 'page_2');
  $handler->override_option('sorts', array(
  'title' => array(
    'order' => 'ASC',
    'id' => 'title',
    'table' => 'node',
    'field' => 'title',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'day',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'override' => array(
      'button' => 'Override',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'creeds/byname');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'By Name',
  'description' => '',
  'weight' => '1',
  'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
  ));
  $handler = $view->new_display('page', 'Recent', 'page_3');
  $handler->override_option('path', 'creeds/recent');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'Recent',
  'description' => '',
  'weight' => '2',
  'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => 0,
  'name' => 'navigation',
  ));
  $handler = $view->new_display('page', 'Popular', 'page_4');
  $handler->override_option('sorts', array(
  'count' => array(
    'order' => 'DESC',
    'id' => 'count',
    'table' => 'flag_counts',
    'field' => 'count',
    'relationship' => 'flag_count_rel',
    'override' => array(
      'button' => 'Use default',
  ),
  ),
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'override' => array(
      'button' => 'Override',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'creeds/popular');
  $handler->override_option('menu', array(
  'type' => 'default tab',
  'title' => 'Popular',
  'description' => '',
  'weight' => '0',
  'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
  'type' => 'none',
  'title' => '',
  'description' => '',
  'weight' => '0',
  'name' => 'navigation',
  ));
  return $view;
}