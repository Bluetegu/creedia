<?php
/**
 * Filter handler for the current user or NULL
 */
class cdist_handler_filter_profile_sharing extends views_handler_filter {
  function construct() {
    parent::construct();
    $this->value_value = t('Filter according to profile sharing settings.');
  }

  function query() {
    $this->ensure_my_table();

    $where = "$this->table_alias.$this->real_field ";
    $where .= '<> 255';  // private profiles are not listed
    $where = '(' . $where . " AND NOT ( ***CURRENT_USER*** = 0 AND $this->table_alias.$this->real_field = 1))";

    $this->query->add_where($this->options['group'], $where);
  }
}
