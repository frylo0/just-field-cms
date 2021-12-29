<?php

require_once __DIR__ . '/upload-exception.php';
require_once __DIR__ . '/get-file-any-ext.php';


$assets_folder = '__assets/T_text/';
$php_assets_folder = '../../../' . $assets_folder;
$id = $_POST['id'];
$file = $_POST['image'];
$host = $_POST['host'];

// STOP: This block of code can remove file with same name if it exists.
// But Editor.js ImageTool plugin don't provide functionality to update images.
// So image can't be updated, what means, file can not exist, only new file can be uploaded.
// ------------------------------------------------------------------------------------
//$old_file = get_file_any_ext($php_assets_folder, $id, 'jpeg|jpg|png|gif|svg'); // file to unlink has any ext
//if ($old_file) {
//   // old file exists
//   $old_file = $php_assets_folder . $old_file;
//   if (file_exists($old_file)) unlink($old_file);
//}

$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
$target_name = "{$id}.{$ext}";
$target_file = "$php_assets_folder$target_name"; // assets_folder has '/' at end

if (file_put_contents($file, $target_file)) {
   chmod($target_file, 0777);

   // TODO: host must be insered on data rendering, because of migration thoughts
   $target_file_url = "$host/$assets_folder$target_name";

   echo <<<JSON
   {
      "status": "OK",
      "success" : 1,
      "file": {
         "url" : "$target_file_url"
      }
   }
JSON;
} else {
   // error
   echo <<<JSON
   {
      "status": "Error",
      "message": "File at URL ($file) is unreachable.",
      "success" : 0
   }
JSON;
}

//<?php

//echo <<<JSON
//{
//   "status": "OK",
//   "success" : 1,
//   "file": {
//      "url" : "{$_POST['image']}"
//   }
//}
//JSON;