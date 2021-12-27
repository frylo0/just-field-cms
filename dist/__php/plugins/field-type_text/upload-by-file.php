<?php
// TODO: File upload. Looks like request have not ImageTool block ID, that make harder to remove old uploaded images.
// TODO: Need to inspect
//require_once __DIR__ . '/upload-exception.php';

//$assets_folder = '../__assets/T_text/';
//$value = $_FILES;

//if ($value['error'] != UPLOAD_ERR_OK) 
//   throw new UploadException($value['error']);

//$old_file = $this->get_value()['src'];
//if (file_exists($old_file)) unlink($old_file);

//$ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
//$target_name = "{$this->id}.{$ext}";
//$target_file = "$assets_folder$target_name"; // assets_folder has '/' at end

//move_uploaded_file($value['tmp_name'], $target_file);
//chmod($target_file, 0777);

echo <<<JSON
{
   "success" : 1,
   "file": {
      "url" : "https://www.tesla.com/tesla_theme/assets/img/_vehicle_redesign/roadster_and_semi/roadster/hero.jpg"
   }
}
JSON;