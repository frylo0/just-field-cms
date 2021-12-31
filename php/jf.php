<?php
require '../php/__load.php';
$db = new JustField\DB($orm);

function field($path) {
   global $db;
   return $db->at_path($path)->value;
}
function at_id($id) {
   global $db;
   return $db->at_id($id)->value;
}
?>