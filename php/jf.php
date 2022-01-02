<?php
require '../php/__load.php';
$db = new JustField\DB($orm);

/**
 * Path value.
 * @param string $path Path to field.
 * @return mixed Field value.
 */
function pv($path) {
   global $db;
   return $db->at_path($path)->value;
}
/**
 * ID value.
 * @param string $id ID of field.
 * @return mixed Field value.
 */
function iv($id) {
   global $db;
   return $db->at_id($id)->value;
}
?>