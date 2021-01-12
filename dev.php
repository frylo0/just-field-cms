<?php

$VER = time();
$ATTACH = './src/Attach';
$PHP = './php';
$ROOT = './src/Root';
$ASSETS = './src/Assets';

use JsPhpize\JsPhpizePhug;

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/php/ORM.php';
require_once __DIR__ . '/php/unset-session.php';

require_once './php/orm.config.php';
$orm->table_prefix = 'jf-cms_';
$orm->is_log = true;

Phug::addExtension(JsPhpizePhug::class);
$page_name = isset($_GET['page']) ? $_GET['page'] : 'login';
$variables = [
   'link' => "./src/Pages/{$page_name}/dist/{$page_name}",
   'ver' => "$VER",
   'orm' => $orm,
   '$_POST' => $_POST,
   '$_GET' => $_GET,
   '$_COOKIE' => $_COOKIE,
   'php' => $PHP,
   'attach' => $ATTACH,
   'assets' => $ASSETS,
   'root' => $ROOT,
   'unset_session_prop' => $unset_session_prop,
   'mode' => 'dev',
];
$options = [
   'cache_dir' => 'cache'
];
Phug::setOption('debug', false); // remove debug and performance info from output file
Phug::displayFile("./src/Pages/{$page_name}/{$page_name}.pug", $variables, $options);

$orm->close();
