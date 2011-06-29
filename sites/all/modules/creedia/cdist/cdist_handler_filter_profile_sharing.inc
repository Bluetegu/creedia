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

    $cond1 = "$this->table_alias.$this->real_field IS NULL";
    $cond2 = "$this->table_alias.$this->real_field = 0"; // private profiles are not listed
    $cond3 = "(***CURRENT_USER*** != 0 AND $this->table_alias.$this->real_field = 1)";
    $where = '('. $cond1 .' OR '. $cond2 .' OR '. $cond3 .')';

    $this->query->add_where($this->options['group'], $where);
  }
}
