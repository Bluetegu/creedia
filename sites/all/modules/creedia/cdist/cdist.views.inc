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
        'title' => t('User #1'),
        'help' => t('User id of first user'),
//        'relationship' => array(
//          'base' => 'users',
//          'field' => 'uid',
//          'handler' => 'views_handler_relationship',
//          'label' => 'User Id',
//        ),
      ),

      'mid' => array(
        'title' => t('User #2'),
        'help' => t('User id of second user'),
        // calculate the distance of all users with respect to the arg user.
        'argument' => array(
          'handler' => 'views_handler_argument_numeric',
        ),
        // calculate the distance of all users with respect to the filter user.
        'filter' => array(
          'handler' => 'views_handler_filter_numeric',
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
        // required for AND distance between users is not zero.
        'filter' => array(
          'handler' => 'views_handler_filter_numeric',
        ),
      ),
    )
  );

  return $data;
}

