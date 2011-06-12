<?php
/**
 * This file is used to tell the views module about the cdist table.
 *
 * Database definition:
 * @code
 *   CREATE TABLE cdist_cache (
 *     uid int(10) unsigned NOT NULL,   // user id#1
 *     mid int(10) unsigned NOT NULL,   // user id#2
 *     cnt SMALLINT unsigned default '0',
 *     PRIMARY KEY (uid, mid)
 *   )
 * @endcode
 *
 */

/**
 * Implementation of hook_views_data
 */
function cdist_views_data() {

  $data = array(
    'cdist_cache' => array(

      'table' => array(
        'group' => t('Creedia'),
        // indicate possible joins to base tables
        'join' => array(
          'users' => array(
            'left_field' => 'uid',
            'field' => 'uid'
          ),
          'node' => array(
            'left_field' => 'uid',
            'field' => 'uid'
          ),
        ),
      ),

      'uid' => array(
        'title' => t('Distancee'),
        'help' => t('Running User Id associated with measured distance'),
      ),

      'mid' => array(
        'title' => t('Distance Anchor'),
        'help' => t('User from which to measure distance'),
        // calculate the distance of all users with respect to the arg user.
        'argument' => array(
          'handler' => 'views_handler_argument_numeric',
        ),
        // calculate the distance of all users with respect to the specified user.
        'filter' => array(
          'handler' => 'views_handler_filter_numeric',
        ),
      ),

      'mid_current' => array(
        'title' => t('Distance Current User'),
        'help' => t('Measure distance from current user'),
        'real field' => 'mid',
        // calculate the distance of all users with respect to the current user.
        'filter' => array(
          'handler' => 'views_handler_filter_user_current_or_NULL',
        ),
      ),

      'cnt' => array(
        'title' => t('Distance between members'),
        'help' => t('Distance between members. The number of shared common ways.'),
        'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
        ),
        'sort' => array(
          'handler' => 'views_handler_sort',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_numeric',
        ),
      ),
    )
  );

  return $data;
}

