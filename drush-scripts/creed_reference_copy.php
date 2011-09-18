<?php
// Copy all references from field_creed_reference1 to field_creed_reference
// Needed to convert all interpretations to use the same reference used by other posts.

$result = db_query("SELECT * FROM {content_field_creed_reference1}");

while($data = $db_result($result)) {
  $sql = "INSERT INTO {content_field_creed_reference} (vid, delta, nid, field_creed_reference_nid) VALUES (%d, %d, %d, %d)";
  db_query($sql, $data->vid, $data->delta, $data->nid, $data->field_creed_reference1_nid);
}
