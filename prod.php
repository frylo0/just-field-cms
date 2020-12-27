<?php

$VER = '1.0';
$ATTACH = './../Attach/';
$PHP = './../php/';

use JsPhpize\JsPhpizePhug;

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/php/ORM.php';

require_once './php/orm.config.php';
$orm->table_prefix = 'jf-cms_';
$orm->is_log = true;

Phug::addExtension(JsPhpizePhug::class);
Phug::setOption('debug', false); // remove debug and performance info from output file

foreach (glob('./src/Pages/*', GLOB_ONLYDIR) as $dir) {
   $page_folder_path = $dir;
   $page_name = basename($dir);

   $page_php = Phug::compileFile("./src/Pages/{$page_name}/{$page_name}.pug");
   $page_php = replace_dev_links($page_php);
   $file_start = generate_vars_start($page_name);
   $page_php = $file_start . $page_php;

   if (!is_dir("./dist/$page_name")) {
      mkdir("./dist/$page_name", 0777);
   }

   file_put_contents("./dist/$page_name/index.php", $page_php);

   echo table([$page_folder_path, $page_name], [30, 0]);
}

echo "\n";

$orm->close();



function generate_vars_start($page_name)
{
   global $VER;

   $vars = [
      'link' => "./{$page_name}",
      'ver' => "$VER",
   ];

   $vars_string = '';
   foreach ($vars as $name => $val) {
      $vars_string .= "$$name = '$val';\n";
   }
   $file_start = "
<?php
// comment
$vars_string
?>
";

   return $file_start;
}

function replace_dev_links($page_php)
{
   return str_replace('dev.php?page=', '../', $page_php);
}

function table($row, $sizes)
{
   $row_str = "\n";
   foreach ($row as $i => $col) {
      $size = $sizes[$i];
      $col_size = mb_strlen($col);
      if ($col_size < $size) {
         $col = $col . str_repeat(' ', $size - $col_size);
      }
      $row_str .= $col;
   }
   return $row_str;
}