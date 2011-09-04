<?php
// Based on scripts discussed in http://drupal.org/node/485328
// Not using node_save to avoid collatoral damage (watcher module sending notifications to users, etc.)
// Only current version of node is updated.
// Overrides set values
// Single value fields are not included here as the d5->d6 migration takes care of this.

$map = array(
  'member' => array(
    5 => 'field_country',
    8 => 'field_profile_facets',
    2 => 'field_religion_affiliation',
  ),
  'creed' => array(
    2 => 'field_religion_single',
    3 => 'field_beliefset',
  ),
  'opinion' => array(
    2 => 'field_religion',
    3 => 'field_beliefset',
    4 => 'field_free_tag',
  ),
  'interpretation' => array(
    2 => 'field_religion',
    3 => 'field_beliefset',
    4 => 'field_free_tag',
  ),
  'dblog' => array(
    2 => 'field_religion',
    3 => 'field_beliefset',
    4 => 'field_free_tag',
  ),
);

foreach ($map as $type => $tmap) {
  $result = db_query("SELECT nid FROM {node} WHERE type = '%s' ", $type);
  // run over all nodes of given type
  while ($nid = db_result($result)) {
    $node = node_load($nid);
    // run over all relevant fields
    foreach ($tmap as $vid => $fieldname) {
      $terms = taxonomy_node_get_terms_by_vocabulary($node, $vid); // these terms are already filtered according to node->vid
      
      if (count($terms)){
        // delete current values
        $sql = "DELETE FROM {content_{$fieldname}} WHERE vid = %d AND nid = %d ";
        db_query($sql, $node->vid, $node->nid);
        echo sprintf($sql ."\n", $node->vid, $node->nid);

        foreach ($terms as $term) {
          $sql = "INSERT INTO {content_{$fieldname}} (vid, delta, nid, {$fieldname}_value) VALUES (%d, %d, %d, %d)";
          $sql .=  "ON DUPLICATE KEY UPDATE {$fieldname}_value = %d";
          // delta is set to tid - content_taxonomy module's convention
          db_query($sql, $node->vid, $term->tid, $node->nid, $term->tid, $term->tid);
          echo sprintf($sql ."\n", $node->vid, $term->tid, $node->nid, $term->tid, $term->tid);
        }
      }
    }
  }
}
