<?php
/**
 * Filter handler for the current user or NULL
 */
class views_handler_filter_user_current_or_NULL extends views_handler_filter_user_current {
  function construct() {
    parent::construct();
    $this->value_value = t('Logged in user. Option is to either OR with NULL or not:');
  }

  function query() {
    $this->ensure_my_table();

    $where = "$this->table_alias.$this->real_field ";
    $where .= '= ***CURRENT_USER***';
    if ($this->value) {
      $where = '(' . $where . " OR $this->table_alias.$this->real_field IS NULL)";
    }

    $this->query->add_where($this->options['group'], $where);
  }
}
