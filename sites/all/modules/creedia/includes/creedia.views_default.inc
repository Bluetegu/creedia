<?php
//$Id:
/**
 * Default Creedia Views
 */

/**
 * Implementation of hook_views_default_views()
 */
function creedia_views_default_views() {
  $views = array();

  $view = creedia_creeds_default_view();
  $views[$view->name] = $view;

  $view = creedia_discussions_default_view();
  $views[$view->name] = $view;

  $view = creedia_blogs_default_view();
  $views[$view->name] = $view;

  $view = creedia_members_default_view();
  $views[$view->name] = $view;

  $view = creedia_deeds_default_view();
  $views[$view->name] = $view;

  $view = creedia_deeds_bydate_default_view();
  $views[$view->name] = $view;

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

/**
 * Exported discussion view
 */
function creedia_discussions_default_view() {
  $view = new view;
  $view->name = 'Discussions';
  $view->description = 'Discussions using exposed filters in node format';
  $view->tag = '';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('sorts', array(
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('filters', array(
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
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'interpretation' => 'interpretation',
      'opinion' => 'opinion',
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
  'field_free_tag_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 1,
      'operator' => 'freetag_op',
      'identifier' => 'freetag',
      'label' => 'Free Tags',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'id' => 'field_free_tag_value',
    'table' => 'node_data_field_free_tag',
    'field' => 'field_free_tag_value',
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
  $handler->override_option('title', 'Discussions');
  $handler->override_option('empty', 'No discussion tagged with selected terms.');
  $handler->override_option('empty_format', '4');
  $handler->override_option('use_ajax', TRUE);
  $handler->override_option('use_pager', '1');
  $handler->override_option('distinct', 1);
  $handler->override_option('row_plugin', 'node');
  $handler->override_option('exposed_block', TRUE);
  $handler = $view->new_display('page', 'Main', 'page_2');
  $handler->override_option('relationships', array(
  'flag_content_rel' => array(
    'label' => 'flag',
    'required' => 0,
    'flag' => 'featured',
    'user_scope' => 'any',
    'id' => 'flag_content_rel',
    'table' => 'node',
    'field' => 'flag_content_rel',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('sorts', array(
  'timestamp' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'timestamp',
    'table' => 'flag_content',
    'field' => 'timestamp',
    'relationship' => 'flag_content_rel',
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
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'opinions');
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
  $handler = $view->new_display('page', 'Featured', 'page_1');
  $handler->override_option('relationships', array(
  'flag_content_rel' => array(
    'label' => 'flag',
    'required' => 0,
    'flag' => 'featured',
    'user_scope' => 'any',
    'id' => 'flag_content_rel',
    'table' => 'node',
    'field' => 'flag_content_rel',
    'relationship' => 'none',
    'override' => array(
      'button' => 'Use default',
  ),
  ),
  ));
  $handler->override_option('sorts', array(
  'timestamp' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'timestamp',
    'table' => 'flag_content',
    'field' => 'timestamp',
    'relationship' => 'flag_content_rel',
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
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'opinions/featured');
  $handler->override_option('menu', array(
  'type' => 'default tab',
  'title' => 'Featured',
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
  $handler = $view->new_display('page', 'Recent', 'page_3');
  $handler->override_option('path', 'opinions/recent');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'Recent',
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
  $handler = $view->new_display('page', 'Most Viewed', 'page_5');
  $handler->override_option('sorts', array(
  'totalcount' => array(
    'order' => 'DESC',
    'id' => 'totalcount',
    'table' => 'node_counter',
    'field' => 'totalcount',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'opinions/viewed');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'Most Viewed',
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
  $handler = $view->new_display('page', 'Highest Rated', 'page_4');
  $handler->override_option('relationships', array(
  'votingapi_cache' => array(
    'label' => 'Vote Number',
    'required' => 0,
    'votingapi' => array(
      'value_type' => 'percent',
      'tag' => 'vote',
      'function' => 'count',
  ),
    'id' => 'votingapi_cache',
    'table' => 'node',
    'field' => 'votingapi_cache',
    'relationship' => 'none',
  ),
  'votingapi_cache_1' => array(
    'label' => 'Vote Average',
    'required' => 0,
    'votingapi' => array(
      'value_type' => 'percent',
      'tag' => 'vote',
      'function' => 'average',
  ),
    'id' => 'votingapi_cache_1',
    'table' => 'node',
    'field' => 'votingapi_cache',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('sorts', array(
  'value_1' => array(
    'order' => 'DESC',
    'id' => 'value_1',
    'table' => 'votingapi_cache',
    'field' => 'value',
    'relationship' => 'votingapi_cache_1',
    'override' => array(
      'button' => 'Use default',
  ),
  ),
  'value' => array(
    'order' => 'DESC',
    'id' => 'value',
    'table' => 'votingapi_cache',
    'field' => 'value',
    'relationship' => 'votingapi_cache',
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
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'opinions/rated');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'Highest Rated',
  'description' => '',
  'weight' => '3',
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

/**
 * Exported creeds view
 */
function creedia_blogs_default_view() {
  $view = new view;
  $view->name = 'Blogs';
  $view->description = 'Blogss using exposed filters in node format';
  $view->tag = '';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('sorts', array(
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('filters', array(
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
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'dblog' => 'dblog',
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
  'field_free_tag_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 1,
      'operator' => 'freetag_op',
      'identifier' => 'freetag',
      'label' => 'Free Tags',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'id' => 'field_free_tag_value',
    'table' => 'node_data_field_free_tag',
    'field' => 'field_free_tag_value',
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
  $handler->override_option('title', 'Blogs');
  $handler->override_option('empty', 'No blog posts tagged with selected terms.');
  $handler->override_option('empty_format', '4');
  $handler->override_option('use_ajax', TRUE);
  $handler->override_option('use_pager', '1');
  $handler->override_option('distinct', 1);
  $handler->override_option('row_plugin', 'node');
  $handler->override_option('exposed_block', TRUE);
  $handler = $view->new_display('page', 'Main', 'page_2');
  $handler->override_option('relationships', array(
  'flag_content_rel' => array(
    'label' => 'flag',
    'required' => 0,
    'flag' => 'featured',
    'user_scope' => 'any',
    'id' => 'flag_content_rel',
    'table' => 'node',
    'field' => 'flag_content_rel',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('sorts', array(
  'timestamp' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'timestamp',
    'table' => 'flag_content',
    'field' => 'timestamp',
    'relationship' => 'flag_content_rel',
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
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'blogs');
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
  $handler = $view->new_display('page', 'Featured', 'page_1');
  $handler->override_option('relationships', array(
  'flag_content_rel' => array(
    'label' => 'flag',
    'required' => 0,
    'flag' => 'featured',
    'user_scope' => 'any',
    'id' => 'flag_content_rel',
    'table' => 'node',
    'field' => 'flag_content_rel',
    'relationship' => 'none',
    'override' => array(
      'button' => 'Use default',
  ),
  ),
  ));
  $handler->override_option('sorts', array(
  'timestamp' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'timestamp',
    'table' => 'flag_content',
    'field' => 'timestamp',
    'relationship' => 'flag_content_rel',
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
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'blogs/featured');
  $handler->override_option('menu', array(
  'type' => 'default tab',
  'title' => 'Featured',
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
  $handler = $view->new_display('page', 'Recent', 'page_3');
  $handler->override_option('path', 'blogs/recent');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'Recent',
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
  $handler = $view->new_display('page', 'Most Viewed', 'page_5');
  $handler->override_option('sorts', array(
  'totalcount' => array(
    'order' => 'DESC',
    'id' => 'totalcount',
    'table' => 'node_counter',
    'field' => 'totalcount',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'blogs/viewed');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'Most Viewed',
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
  return $view;
}

/**
 * Exported deeds view (by calendar)
 */
function creedia_deeds_default_view() {
  $view = new view;
  $view->name = 'Deeds';
  $view->description = 'Deeds calendar';
  $view->tag = 'Calendar';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('fields', array(
  'title' => array(
    'label' => '',
    'link_to_node' => 1,
    'exclude' => 0,
    'id' => 'title',
    'field' => 'title',
    'table' => 'node',
    'relationship' => 'none',
  ),
  'field_when_value' => array(
    'label' => 'When',
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
    'label_type' => 'widget',
    'format' => 'default',
    'multiple' => array(
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_to' => '',
      'group' => '',
  ),
    'repeat' => array(
      'show_repeat_rule' => '',
  ),
    'fromto' => array(
      'fromto' => 'both',
  ),
    'exclude' => 1,
    'id' => 'field_when_value',
    'table' => 'node_data_field_when',
    'field' => 'field_when_value',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('sorts', array(
  'field_when_value' => array(
    'order' => 'ASC',
    'delta' => -1,
    'id' => 'field_when_value',
    'table' => 'node_data_field_when',
    'field' => 'field_when_value',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('arguments', array(
  'date_argument' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'date',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'date_fields' => array(
      'node_data_field_when.field_when_value' => 'node_data_field_when.field_when_value',
  ),
    'year_range' => '-3:+3',
    'date_method' => 'OR',
    'granularity' => 'month',
    'id' => 'date_argument',
    'table' => 'node',
    'field' => 'date_argument',
    'relationship' => 'none',
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => '',
    'validate_argument_node_type' => array(
      'blog' => 0,
      'faq' => 0,
      'creed' => 0,
      'dblog' => 0,
      'deed' => 0,
      'image_cck' => 0,
      'interpretation' => 0,
      'member' => 0,
      'opinion' => 0,
      'page' => 0,
      'profile' => 0,
      'religion_info' => 0,
      'simplenews' => 0,
      'story' => 0,
  ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(
      '1' => 0,
      '3' => 0,
      '5' => 0,
      '6' => 0,
      '9' => 0,
      '7' => 0,
      '2' => 0,
      '8' => 0,
      '4' => 0,
  ),
    'validate_argument_type' => 'tid',
    'validate_argument_php' => '',
    'override' => array(
      'button' => 'Override',
  ),
    'default_options_div_prefix' => '',
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      '2' => 0,
      '3' => 0,
  ),
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_node_flag_name' => '*relationship*',
    'validate_argument_node_flag_test' => 'flaggable',
    'validate_argument_node_flag_id_type' => 'id',
    'validate_argument_user_flag_name' => '*relationship*',
    'validate_argument_user_flag_test' => 'flaggable',
    'validate_argument_user_flag_id_type' => 'id',
  ),
  ));
  $handler->override_option('filters', array(
  'status' => array(
    'operator' => '=',
    'value' => 1,
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'status',
    'table' => 'node',
    'field' => 'status',
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'deed' => 'deed',
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
  ));
  $handler->override_option('access', array(
  'type' => 'none',
  'role' => array(),
  'perm' => '',
  ));
  $handler->override_option('cache', array(
  'type' => 'none',
  ));
  $handler->override_option('title', 'Deeds');
  $handler->override_option('header_empty', 1);
  $handler->override_option('items_per_page', 0);
  $handler->override_option('use_more', 0);
  $handler->override_option('style_plugin', 'calendar_nav');
  $handler = $view->new_display('calendar', 'Calendar page', 'calendar_1');
  $handler->override_option('style_options', NULL);
  $handler->override_option('row_plugin', '');
  $handler->override_option('row_options', NULL);
  $handler->override_option('path', 'deeds/bycal');
  $handler->override_option('menu', array(
  'type' => 'default tab',
  'title' => 'By Calendar',
  'description' => '',
  'weight' => '0',
  'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
  'type' => 'normal',
  'title' => 'Deeds',
  'description' => '',
  'weight' => '0',
  'name' => 'primary-links',
  ));
  $handler->override_option('calendar_colors', array(
  '0' => array(),
  ));
  $handler->override_option('calendar_colors_vocabulary', array());
  $handler->override_option('calendar_colors_taxonomy', array());
  $handler->override_option('calendar_colors_group', array());
  $handler->override_option('calendar_popup', 0);
  $handler->override_option('calendar_date_link', '');
  $handler = $view->new_display('calendar_block', 'Calendar block', 'calendar_block_1');
  $handler->override_option('style_options', NULL);
  $handler->override_option('row_plugin', '');
  $handler->override_option('row_options', NULL);
  $handler->override_option('block_description', 'Calendar');
  $handler->override_option('block_caching', -1);
  $handler = $view->new_display('calendar_period', 'Year view', 'calendar_period_1');
  $handler->override_option('style_plugin', 'calendar_style');
  $handler->override_option('style_options', array(
  'display_type' => 'year',
  'name_size' => 1,
  'max_items' => 0,
  ));
  $handler->override_option('attachment_position', 'after');
  $handler->override_option('inherit_arguments', TRUE);
  $handler->override_option('inherit_exposed_filters', TRUE);
  $handler->override_option('inherit_pager', FALSE);
  $handler->override_option('render_pager', TRUE);
  $handler->override_option('displays', array(
  'calendar_1' => 'calendar_1',
  'default' => 0,
  'calendar_block_1' => 0,
  ));
  $handler->override_option('calendar_type', 'year');
  $handler = $view->new_display('calendar_period', 'Month view', 'calendar_period_2');
  $handler->override_option('style_plugin', 'calendar_style');
  $handler->override_option('style_options', array(
  'display_type' => 'month',
  'name_size' => '99',
  'with_weekno' => '1',
  'date_fields' => NULL,
  'max_items' => 0,
  ));
  $handler->override_option('attachment_position', 'after');
  $handler->override_option('inherit_arguments', TRUE);
  $handler->override_option('inherit_exposed_filters', TRUE);
  $handler->override_option('inherit_pager', FALSE);
  $handler->override_option('render_pager', TRUE);
  $handler->override_option('displays', array(
  'calendar_1' => 'calendar_1',
  'default' => 0,
  'calendar_block_1' => 0,
  ));
  $handler->override_option('calendar_type', 'month');
  $handler = $view->new_display('calendar_period', 'Day view', 'calendar_period_3');
  $handler->override_option('style_plugin', 'calendar_style');
  $handler->override_option('style_options', array(
  'name_size' => '99',
  'with_weekno' => 0,
  'max_items' => 0,
  'max_items_behavior' => 'more',
  'groupby_times' => 'hour',
  'groupby_times_custom' => '',
  'groupby_field' => '',
  ));
  $handler->override_option('attachment_position', 'after');
  $handler->override_option('inherit_arguments', TRUE);
  $handler->override_option('inherit_exposed_filters', TRUE);
  $handler->override_option('inherit_pager', FALSE);
  $handler->override_option('render_pager', TRUE);
  $handler->override_option('displays', array(
  'calendar_1' => 'calendar_1',
  'default' => 0,
  'calendar_block_1' => 0,
  ));
  $handler->override_option('calendar_type', 'day');
  $handler = $view->new_display('calendar_period', 'Week view', 'calendar_period_4');
  $handler->override_option('style_plugin', 'calendar_style');
  $handler->override_option('style_options', array(
  'name_size' => '99',
  'with_weekno' => 0,
  'max_items' => 0,
  'max_items_behavior' => 'more',
  'groupby_times' => 'hour',
  'groupby_times_custom' => '',
  'groupby_field' => '',
  ));
  $handler->override_option('attachment_position', 'after');
  $handler->override_option('inherit_arguments', TRUE);
  $handler->override_option('inherit_exposed_filters', TRUE);
  $handler->override_option('inherit_pager', FALSE);
  $handler->override_option('render_pager', TRUE);
  $handler->override_option('displays', array(
  'calendar_1' => 'calendar_1',
  'default' => 0,
  'calendar_block_1' => 0,
  ));
  $handler->override_option('calendar_type', 'week');
  $handler = $view->new_display('calendar_period', 'Block view', 'calendar_period_5');
  $handler->override_option('style_plugin', 'calendar_style');
  $handler->override_option('style_options', array(
  'display_type' => 'month',
  'name_size' => '1',
  ));
  $handler->override_option('attachment_position', 'after');
  $handler->override_option('inherit_arguments', TRUE);
  $handler->override_option('inherit_exposed_filters', TRUE);
  $handler->override_option('inherit_pager', FALSE);
  $handler->override_option('render_pager', TRUE);
  $handler->override_option('displays', array(
  'calendar_1' => 0,
  'default' => 0,
  'calendar_block_1' => 'calendar_block_1',
  ));
  $handler->override_option('calendar_type', 'month');
  $handler = $view->new_display('block', 'Upcoming', 'block_1');
  $handler->override_option('fields', array(
  'title' => array(
    'label' => '',
    'link_to_node' => 1,
    'exclude' => 0,
    'id' => 'title',
    'field' => 'title',
    'table' => 'node',
    'relationship' => 'none',
    'format' => 'default',
  ),
  'changed' => array(
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
    'date_format' => 'small',
    'custom_date_format' => '',
    'exclude' => 1,
    'link_to_node' => 0,
    'id' => 'changed',
    'field' => 'changed',
    'table' => 'node',
    'relationship' => 'none',
    'format' => 'default',
    'override' => array(
      'button' => 'Use default',
  ),
  ),
  'field_when_value' => array(
    'label' => 'When',
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
    'label_type' => 'widget',
    'format' => 'default',
    'multiple' => array(
      'multiple_number' => '',
      'multiple_from' => '',
      'multiple_to' => '',
      'group' => '',
  ),
    'repeat' => array(
      'show_repeat_rule' => '',
  ),
    'fromto' => array(
      'fromto' => 'both',
  ),
    'exclude' => 0,
    'id' => 'field_when_value',
    'table' => 'node_data_field_when',
    'field' => 'field_when_value',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('arguments', array());
  $handler->override_option('filters', array(
  'status' => array(
    'operator' => '=',
    'value' => 1,
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'status',
    'table' => 'node',
    'field' => 'status',
    'relationship' => 'none',
  ),
  'field_when_value' => array(
    'operator' => '>=',
    'value' => array(
      'value' => NULL,
      'min' => NULL,
      'max' => NULL,
      'default_date' => 'now',
      'default_to_date' => '',
  ),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'date_fields' => array(
      'node_data_field_when.field_when_value' => 'node_data_field_when.field_when_value',
  ),
    'date_method' => 'OR',
    'granularity' => 'day',
    'form_type' => 'date_select',
    'default_date' => 'now',
    'default_to_date' => '',
    'year_range' => '-3:+3',
    'id' => 'field_when_value',
    'table' => 'node_data_field_when',
    'field' => 'field_when_value',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('title', 'Upcoming');
  $handler->override_option('items_per_page', 5);
  $handler->override_option('use_more', 1);
  $handler->override_option('style_plugin', 'list');
  $handler->override_option('style_options', array(
  'grouping' => '',
  'type' => 'ul',
  ));
  $handler->override_option('block_description', 'Upcoming');
  $handler->override_option('block_caching', -1);

  return $view;
}

/**
 * Exported deeds view (date browser)
 */
function creedia_deeds_bydate_default_view() {
  $view = new view;
  $view->name = 'Deeds_bydate';
  $view->description = 'Browse through deeds by year, month, day, or week. Date browser attachment adds back/next navigation to the top of the page.';
  $view->tag = 'Date';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('arguments', array(
  'date_argument' => array(
    'default_action' => 'default',
    'style_plugin' => 'default_summary',
    'style_options' => array(),
    'wildcard' => 'all',
    'wildcard_substitution' => 'All',
    'title' => '',
    'breadcrumb' => '',
    'default_argument_type' => 'date',
    'default_argument' => '',
    'validate_type' => 'none',
    'validate_fail' => 'not found',
    'date_fields' => array(
      'node_data_field_when.field_when_value' => 'node_data_field_when.field_when_value',
  ),
    'year_range' => '-3:+3',
    'date_method' => 'OR',
    'granularity' => 'month',
    'id' => 'date_argument',
    'table' => 'node',
    'field' => 'date_argument',
    'relationship' => 'none',
    'default_argument_user' => 0,
    'default_argument_fixed' => '',
    'default_argument_php' => '',
    'validate_argument_node_type' => array(
      'blog' => 0,
      'faq' => 0,
      'creed' => 0,
      'dblog' => 0,
      'deed' => 0,
      'image_cck' => 0,
      'interpretation' => 0,
      'member' => 0,
      'opinion' => 0,
      'page' => 0,
      'profile' => 0,
      'religion_info' => 0,
      'simplenews' => 0,
      'story' => 0,
  ),
    'validate_argument_node_access' => 0,
    'validate_argument_nid_type' => 'nid',
    'validate_argument_vocabulary' => array(
      '1' => 0,
      '3' => 0,
      '5' => 0,
      '6' => 0,
      '9' => 0,
      '7' => 0,
      '2' => 0,
      '8' => 0,
      '4' => 0,
  ),
    'validate_argument_type' => 'tid',
    'validate_argument_php' => '',
    'default_options_div_prefix' => '',
    'validate_argument_signup_status' => 'any',
    'validate_argument_signup_node_access' => 0,
    'override' => array(
      'button' => 'Override',
  ),
    'validate_user_argument_type' => 'uid',
    'validate_user_roles' => array(
      '2' => 0,
      '3' => 0,
  ),
    'validate_argument_transform' => 0,
    'validate_user_restrict_roles' => 0,
    'validate_argument_node_flag_name' => '*relationship*',
    'validate_argument_node_flag_test' => 'flaggable',
    'validate_argument_node_flag_id_type' => 'id',
    'validate_argument_user_flag_name' => '*relationship*',
    'validate_argument_user_flag_test' => 'flaggable',
    'validate_argument_user_flag_id_type' => 'id',
  ),
  ));
  $handler->override_option('filters', array(
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
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'deed' => 'deed',
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
  ));
  $handler->override_option('access', array(
  'type' => 'none',
  'role' => array(),
  'perm' => '',
  ));
  $handler->override_option('cache', array(
  'type' => 'none',
  ));
  $handler->override_option('items_per_page', 0);
  $handler->override_option('use_pager', '1');
  $handler->override_option('row_plugin', 'node');
  $handler->override_option('row_options', array(
  'teaser' => 1,
  'links' => 1,
  'comments' => 0,
  ));
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->override_option('path', 'deeds/bydate');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'By Date',
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
  $handler = $view->new_display('date_nav', 'Date browser', 'date_nav_1');
  $handler->override_option('style_plugin', 'date_nav');
  $handler->override_option('row_plugin', 'fields');
  $handler->override_option('row_options', array());
  $handler->override_option('attachment_position', 'before');
  $handler->override_option('inherit_arguments', TRUE);
  $handler->override_option('inherit_exposed_filters', TRUE);
  $handler->override_option('inherit_pager', FALSE);
  $handler->override_option('render_pager', TRUE);
  $handler->override_option('displays', array(
  'page' => 'page',
  'default' => 0,
  ));

  return $view;
}

/**
 * Exported members view
 */
function creedia_members_default_view() {
  $view = new view;
  $view->name = 'Members';
  $view->description = 'Members using exposed filters in node format';
  $view->tag = '';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('sorts', array(
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('filters', array(
  'status_1' => array(
    'operator' => '=',
    'value' => '1',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'status_1',
    'table' => 'users',
    'field' => 'status',
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'member' => 'member',
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
  'field_country_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'country_op',
      'identifier' => 'country',
      'label' => 'Content: Country (field_country)',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'id' => 'field_country_value',
    'table' => 'node_data_field_country',
    'field' => 'field_country_value',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
  ),
  'field_gender_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'field_gender_value',
    'table' => 'node_data_field_gender',
    'field' => 'field_gender_value',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
  ),
  'term_node_tid_depth' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'term_node_tid_depth_op',
      'identifier' => 'religion',
      'label' => 'Para',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'type' => 'select',
    'limit' => TRUE,
    'vid' => '2',
    'depth' => '1',
    'id' => 'term_node_tid_depth',
    'table' => 'node',
    'field' => 'term_node_tid_depth',
    'hierarchy' => 1,
    'configure_hs' => '<a href="/admin/build/views/hs_config/Members/default/term_node_tid_depth">Configure Hierarchical Select</a>',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
    'override' => array(
      'button' => 'Override',
  ),
  ),
  ));
  $handler->override_option('access', array(
  'type' => 'none',
  ));
  $handler->override_option('cache', array(
  'type' => 'none',
  ));
  $handler->override_option('title', 'Members');
  $handler->override_option('empty', 'No member tagged with selected terms.');
  $handler->override_option('empty_format', '4');
  $handler->override_option('use_ajax', TRUE);
  $handler->override_option('use_pager', '1');
  $handler->override_option('distinct', 1);
  $handler->override_option('row_plugin', 'node');
  $handler->override_option('exposed_block', TRUE);
  $handler = $view->new_display('page', 'Main', 'page_2');
  $handler->override_option('relationships', array(
  'flag_content_rel' => array(
    'label' => 'flag',
    'required' => 0,
    'flag' => 'featured',
    'user_scope' => 'any',
    'id' => 'flag_content_rel',
    'table' => 'node',
    'field' => 'flag_content_rel',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('sorts', array(
  'timestamp' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'timestamp',
    'table' => 'flag_content',
    'field' => 'timestamp',
    'relationship' => 'flag_content_rel',
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
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'members');
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
  $handler = $view->new_display('page', 'Featured', 'page_1');
  $handler->override_option('relationships', array(
  'flag_content_rel' => array(
    'label' => 'flag',
    'required' => 0,
    'flag' => 'featured',
    'user_scope' => 'any',
    'id' => 'flag_content_rel',
    'table' => 'node',
    'field' => 'flag_content_rel',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('sorts', array(
  'timestamp' => array(
    'order' => 'DESC',
    'granularity' => 'second',
    'id' => 'timestamp',
    'table' => 'flag_content',
    'field' => 'timestamp',
    'relationship' => 'flag_content_rel',
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
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'members/featured');
  $handler->override_option('menu', array(
  'type' => 'default tab',
  'title' => 'Featured',
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
  $handler = $view->new_display('page', 'Recently Joined', 'page_3');
  $handler->override_option('path', 'members/joined');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'Recently Joined',
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
  $handler = $view->new_display('page', 'By Name', 'page_5');
  $handler->override_option('sorts', array(
  'field_full_name_value' => array(
    'order' => 'ASC',
    'delta' => -1,
    'id' => 'field_full_name_value',
    'table' => 'node_data_field_full_name',
    'field' => 'field_full_name_value',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'members/byfullname');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'By Name',
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
  $handler = $view->new_display('page', 'By Way', 'page_4');
  $handler->override_option('sorts', array(
  'cnt' => array(
    'order' => 'DESC',
    'id' => 'cnt',
    'table' => 'cdist_cache',
    'field' => 'cnt',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  'created' => array(
    'order' => 'DESC',
    'granularity' => 'hour',
    'id' => 'created',
    'table' => 'node',
    'field' => 'created',
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('filters', array(
  'status_1' => array(
    'operator' => '=',
    'value' => '1',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'status_1',
    'table' => 'users',
    'field' => 'status',
    'relationship' => 'none',
  ),
  'type' => array(
    'operator' => 'in',
    'value' => array(
      'member' => 'member',
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
  'field_profile_sharing_value_dist' => array(
    'id' => 'field_profile_sharing_value_dist',
    'table' => 'node_data_field_profile_sharing',
    'field' => 'field_profile_sharing_value_dist',
  ),
  'field_country_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'country_op',
      'identifier' => 'country',
      'label' => 'Content: Country (field_country)',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'id' => 'field_country_value',
    'table' => 'node_data_field_country',
    'field' => 'field_country_value',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
  ),
  'field_religion_affiliation_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => TRUE,
    'expose' => array(
      'use_operator' => 0,
      'operator' => 'field_religion_affiliation_value_op',
      'identifier' => 'religion',
      'label' => 'Content: Religion and Movement (field_religion_affiliation)',
      'optional' => 1,
      'single' => 0,
      'remember' => 1,
      'reduce' => 0,
  ),
    'id' => 'field_religion_affiliation_value',
    'table' => 'node_data_field_religion_affiliation',
    'field' => 'field_religion_affiliation_value',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
  ),
  'field_gender_value' => array(
    'operator' => 'or',
    'value' => array(),
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'field_gender_value',
    'table' => 'node_data_field_gender',
    'field' => 'field_gender_value',
    'relationship' => 'none',
    'reduce_duplicates' => 1,
  ),
  'mid_current' => array(
    'operator' => '=',
    'value' => '1',
    'group' => '0',
    'exposed' => FALSE,
    'expose' => array(
      'operator' => FALSE,
      'label' => '',
  ),
    'id' => 'mid_current',
    'table' => 'cdist_cache',
    'field' => 'mid_current',
    'override' => array(
      'button' => 'Use default',
  ),
    'relationship' => 'none',
  ),
  ));
  $handler->override_option('path', 'members/byway');
  $handler->override_option('menu', array(
  'type' => 'tab',
  'title' => 'By Way',
  'description' => '',
  'weight' => '3',
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
