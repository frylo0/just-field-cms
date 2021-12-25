<?php
$PHP = '../'
?><?php
$VER = time();
$PHP = (isset($PHP) ? $PHP : '') . './__php';
$ATTACH = './src/__attach';
$ASSETS = './src/__assets';
$ROOT = './src/Root';
$MODE = 'dev';

require_once $PHP . '/__load.php';
?><?php
session_start();

if (!isset($_SESSION['id'])) {
   session_destroy();
   exit("<meta http-equiv='refresh' content='0; url=./../login'>");
   die;
}?><?php
$user_info = $orm->from('account')->select('*')->where("id_account = '{$_SESSION['id']}'")()[0];?><?php
$db = new JustField\DB($orm);

if (!isset($_GET['view']))
   header('Location: ./../field?view=tree');

function query_update ($key, $value) { 
   if (!isset($_GET[$key])) 
      return; 
   return './?' . str_replace("$key=".$_GET[$key], "$key=$value", $_SERVER['QUERY_STRING']); 
};
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fields | Just Field</title>
    <link rel="apple-touch-icon" sizes="57x57" href="./../apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./../apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./../apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./../apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./../apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./../apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./../apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./../apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./../apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./../android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./../favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./../favicon-16x16.png">
    <link rel="manifest" href="./../manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./../ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
  <link href="../field/field.bundle.css" rel="stylesheet"></head>
  <body class="row"><?php
$aside_width = 400;
if (array_key_exists('-jf_aside-width', $_COOKIE)) {
   $aside_width = $_COOKIE['-jf_aside-width'];
}
$anti_aside_width = "calc(100% - {$aside_width}px)";?>
    <aside class="aside rel" style="width: <?=$aside_width?>px">
      <div class="aside__content col jcsb">
        <div class="col">
          <div class="box p1 box_mode_none aside__logo row aic">
            <svg class="logo" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 1.75em; width: 1.75em;">
              <g clip-path="url(#clip0)">
                <path d="M33.0447 9.87597C33.3487 9.01785 34.2907 8.5686 35.1489 8.87255L48.0542 13.4437L30.4171 63.2376C30.1131 64.0957 29.1711 64.5449 28.3129 64.241L15.4076 59.6698L33.0447 9.87597Z" fill="#E6E6E6"></path>
                <path d="M16.1526 -5.10426C16.4565 -5.96238 17.3986 -6.41162 18.2567 -6.10767L30.696 -1.70163L15.9493 39.9315C15.6454 40.7897 14.7033 41.2389 13.8452 40.935L1.40596 36.5289L16.1526 -5.10426Z" fill="#E6E6E6"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M25 9.67329C18.7414 9.63097 12.8629 13.5104 10.6556 19.7421C8.46611 25.9236 10.5403 32.5803 15.3466 36.5L25 9.67329ZM34.5 13.1146L25 39.9006C31.1824 39.8587 36.9579 35.9961 39.1413 29.8318C41.3233 23.6716 39.2709 17.0396 34.5 13.1146Z" fill="white"></path>
                <path d="M25.7996 4.68757L13.6919 38.8704L3.04983e-05 38.8704" stroke="black" stroke-width="5.49451" stroke-linejoin="round"></path>
                <path d="M23.392 45.2206L29.4459 28.1292M50 11.0378L35.4997 11.0378L29.4459 28.1292M29.4459 28.1292L39.0763 21.9225" stroke="black" stroke-width="5.49451" stroke-linejoin="round"></path>
              </g>
              <defs>
                <clippath id="clip0">
                  <rect width="50" height="50" fill="white"></rect>
                </clippath>
              </defs>
            </svg><strong class="plo75">Just Field CMS</strong>
          </div>
          <div class="box p1 box_mode_none aside__logged-as"><span>Logged as </span><strong class="tdu"><?= $user_info['account_login'] ?></strong>
          </div>
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../dashboard">Dashboard
          </a>
          <a class="box p1 box_mode_light cud block_disabled aside__item w100 db tdn" href="./../field">Fields
          </a>
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../field-type">Field types
          </a>
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../account">Accounts
          </a>
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../backup">Backup / Migrate
          </a>
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../store">Store
          </a>
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../plugins">Plugins
          </a>
        </div>
        <div class="col">
          <a class="box p1 box_mode_dark aside__item w100 db tdn" href="./../scripts?script=exit">Exit
          </a>
        </div>
      </div>
      <div class="aside__resizer abs h100"></div>
    </aside>
    <main class="rel" style="<?= "width: $anti_aside_width;" ?>">
      <div class="row page_tabs">
        <a class="box p1 box_mode_<?php echo ($_GET['view'] == 'tree' ? 'light' : 'dark') ?> tdn" href="<?= query_update('view', 'tree') ?>">Tree View
        </a>
        <a class="box p1 box_mode_<?php echo ($_GET['view'] == 'type' ? 'light' : 'dark') ?> tdn" href="<?= query_update('view', 'type') ?>">Type View
        </a>
      </div><?php if ($_GET['view'] == 'tree') : ?>
      <div class="page_path row aic w100 pl1">
        <?php
$full_path = (array_key_exists('path', $_GET) ? $_GET['path'] : '');
$curr_path_i = 0;
if (array_key_exists('curr_path_i', $_GET))
   $curr_path_i = $_GET['curr_path_i'];
$curr_path_i = intval($curr_path_i);

$parts = explode('/', $full_path);

$path_parts = [];
for ($i = 0; $i < $curr_path_i; $i++)
   array_push($path_parts, $parts[$i]);
$path = implode('/', $path_parts);

$global['path'] = $path;
$global['path_parts'] = $path_parts;
?><script>var state = {};</script>
        <script>state.path = '<?= $path ?>';</script><?php
//var_dump($parts);
echo '<script>console.log(`' . 'curr_path_i: ' . $curr_path_i .'`);</script>';
echo '<script>console.log(`' . 'count parts: ' . count($parts) .'`);</script>';
if ($curr_path_i < count($parts)-1)
   echo "<script>state.pathNext = '{$parts[$curr_path_i]}';</script>";
else
   echo "<script>state.pathNext = '';</script>";

if (count($parts) == 1 && $parts[0] == '')
   $parts = [];
array_unshift($parts, '/');
$i = 0;
?><?php foreach ($parts as $part): ?>
<?php $is_curr = ($i == $curr_path_i); ?><a class="<?= $is_curr ? 'page_path__part_curr' : '' ?> page_path__part tdn" href="<?= query_update('curr_path_i', $i) ?>"><?= $part ?></a><?php $i++; ?>
<?php endforeach; ?>
      </div>
      <div class="page_content ova w100">
        <template id="template_T_field"><?php if (isset($child)) : ?>
          <tr class="item_T_field" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="<?= $child->key ?>">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="<?= $child->name ?>">
            </td>
            <td class="w100 p0" colname="value">
              <input placeholder="Input value..." value="<?= $child->value ?>">
            </td>
            <td colname="type" colspan="2"><?= $child->type->name ?></td>
            <td class="tac" colname="permission">edit</td>
          </tr><?php else : ?>
          <tr class="item_T_field" data-item-id="{id}" data-item-type="{type}">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="{key}">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="{name}">
            </td>
            <td class="w100 p0" colname="value">
              <input placeholder="Input value..." value="{value}">
            </td>
            <td colname="type" colspan="2">{type}</td>
            <td class="tac" colname="permission">{permission}</td>
          </tr><?php endif; ?>
        </template>
        <template id="template_T_object"><?php if (isset($child)) : ?>
          <tr class="item_T_object" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="<?= $child->key ?>">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="<?= $child->name ?>">
            </td>
            <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = $child->key;
else :
   $loc_path = "{$path}/{$child->key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
            </td>
            <td colname="type" colspan="2"><?= $child->type->name ?></td>
            <td class="tac" colname="permission">edit</td>
          </tr><?php else : ?>
          <tr class="item_T_object" data-item-id="{id}" data-item-type="{type}">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="{key}">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="{name}">
            </td>
            <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = '{key}';
else :
   $loc_path = "{$path}/{key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
            </td>
            <td colname="type" colspan="2">{type}</td>
            <td class="tac" colname="permission">{permission}</td>
          </tr><?php endif; ?>
        </template>
        <template id="template_T_list"><?php if (isset($child)) : ?>
          <tr class="item_T_list" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="<?= $child->key ?>">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="<?= $child->name ?>">
            </td>
            <td class="w100 p0" colname="value">
              <input placeholder="Input value..." value="<?= $child->value ?>">
            </td>
            <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = $child->key;
else :
   $loc_path = "{$path}/{$child->key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
            </td>
            <td colname="type" colspan="1"><?= $child->type->name ?></td>
            <td colname="subtype" colspan="1"><?= $child->subtype->name ?></td>
            <td class="tac" colname="permission">edit</td>
          </tr><?php else : ?>
          <tr class="item_T_list" data-item-id="{id}" data-item-type="{type}">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="{key}">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="{name}">
            </td>
            <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = '{key}';
else :
   $loc_path = "{$path}/{key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
            </td>
            <td colname="type" colspan="1">{type}</td>
            <td colname="subtype" colspan="1">{subtype}</td>
            <td class="tac" colname="permission">{permission}</td>
          </tr><?php endif; ?>
        </template>
        <template id="template_T_image"><?php if (isset($child)) : ?>
          <tr class="item_T_image" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="<?= $child->key ?>">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="<?= $child->name ?>">
            </td>
            <td class="w100 p0" colname="value">
              <div class="row"><?php if (isset($child->value['src'])) : ?>
                <div class="item_T_image__thumbnail row jcc aic"><img src="<?= $child->value['src'] ?>">
                </div>
                <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" data-mfp-src="<?= $child->value['src'] ?>">Show
                </button><?php else : ?>
                <div class="item_T_image__thumbnail item_T_image__thumbnail_free row jcc aic"><img class="dn" src=""></div>
                <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" data-mfp-src="" disabled="disabled">Show
                </button><?php endif; ?>
                <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__upload-button">Upload
                </button>
                <form class="dn item_T_image__file-form">
                  <input class="item_T_image__file" type="file" name="image" accept="image/*">
                </form>
              </div>
            </td>
            <td colname="type" colspan="2"><?= $child->type->name ?></td>
            <td class="tac" colname="permission">edit</td>
          </tr><?php else : ?>
          <tr class="item_T_image" data-item-id="{id}" data-item-type="{type}">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="{key}">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="{name}">
            </td>
            <td class="w100 p0" colname="value">
              <div class="row">
                <div class="item_T_image__thumbnail item_T_image__thumbnail_free row jcc aic"><img class="dn" src=""></div>
                <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" href="{value}" disabled="disabled">Show
                </button>
                <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__upload-button">Upload
                </button>
                <form class="dn item_T_image__file-form">
                  <input class="item_T_image__file" type="file" name="image" accept="image/*">
                </form>
              </div>
            </td>
            <td colname="type" colspan="2">{type}</td>
            <td class="tac" colname="permission">edit</td>
          </tr><?php endif; ?>
        </template>
        <template id="template_T_space"><?php if (isset($child)) : ?>
          <tr class="item_T_space" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="w100 p0 rel" colname="value" colspan="3">
              <input class="w100" placeholder="La Commento..." value="<?= $child->value ?>"><span class="abs <?= ($child->value == '') ? 'dn' : '' ?>">// la commento</span>
            </td>
            <td colname="type" colspan="2"><?= $child->type->name ?></td>
            <td class="tac" colname="permission">edit</td>
          </tr><?php else : ?>
          <tr class="item_T_space" data-item-id="{id}" data-item-type="{type}">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="w100 p0 rel" colname="value" colspan="3">
              <input class="w100" placeholder="La Commento..." value="{value}"><span class="abs dn">// la commento</span>
            </td>
            <td colname="type" colspan="2">{type}</td>
            <td class="tac" colname="permission">{permission}</td>
          </tr><?php endif; ?>
        </template>
        <template id="template_T_text"><?php if (isset($child)) : ?>
          <tr class="item_T_text" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="<?= $child->key ?>">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="<?= $child->name ?>">
            </td>
            <td class="w100 p0" colname="value">
              <button class="box p1 box_mode_dark button tal cup brad0 w100" data-value="<?= $child->value ?>">Text editor
              </button>
            </td>
            <td colname="type" colspan="2"><?= $child->type->name ?></td>
            <td class="tac" colname="permission">edit</td>
          </tr><?php else : ?>
          <tr class="item_T_text" data-item-id="{id}" data-item-type="{type}">
            <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="p0" colname="key">
              <input placeholder="Input key..." value="{key}">
            </td>
            <td class="p0" colname="name">
              <input placeholder="Input name..." value="{name}">
            </td>
            <td class="w100 p0" colname="value">
              <button class="box p1 box_mode_dark button tal cup brad0 w100" data-value="{value}">Text editor
              </button>
            </td>
            <td colname="type" colspan="2">{type}</td>
            <td class="tac" colname="permission">{permission}</td>
          </tr><?php endif; ?>
        </template>
        <template id="template_T_text_editor">
          <div class="item_T_text__editor editor-tabs dn">
            <div class="editor-tabs__controls">
              <div class="editor-tabs__tabs">
                <div class="editor-tabs__tab box box_mode_light">
                  <div class="p1">Tab 1</div>
                  <div class="editor-tab__close-button box p1" data-tip="Close">
                    <!-- https://www.flaticon.com/packs/user-interface-176--><img src="../__attach/Images/close.png">
                  </div>
                </div>
                <div class="editor-tabs__tab box box_mode_dark">
                  <div class="p1">Tab 2</div>
                  <div class="editor-tab__close-button box p1" data-tip="Close"><img src="../__attach/Images/close-white.png"></div>
                </div>
              </div>
              <div class="editor-tabs__total-buttons">
                <div class="editor-tabs__colla pse-button box p1 box_mode_light" data-tip="Collapse"><img src="../__attach/Images/collapse.png"></div>
                <div class="editor-tabs__close-button box p1 box_mode_light" data-tip="Close all editors"><img src="../__attach/Images/close.png"></div>
              </div>
            </div>
            <div class="editor-tabs__editorjs" id="editorjs"></div>
          </div>
        </template><?php $is_data = true; ?>
        <table data-update-link="./../scripts/?script=field-update">
          <thead>
            <tr>
              <td>Order</td>
              <td>Key</td>
              <td>Name</td>
              <td class="w100">Value</td>
              <td colspan="2">Type</td>
              <td>Permission</td>
            </tr>
          </thead>
          <tbody><?php $children = $db->at_path($path); ?>
<?php $children = $children->get_children(); ?>
<?php if ($children == null) : ?>
<?php $is_data = false; ?>
<?php else : ?>
<?php foreach ($children as $child) : ?>
<?php if ($child->type->name == 'field') : ?><?php if (isset($child)) : ?>
            <tr class="item_T_field" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="<?= $child->key ?>">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="<?= $child->name ?>">
              </td>
              <td class="w100 p0" colname="value">
                <input placeholder="Input value..." value="<?= $child->value ?>">
              </td>
              <td colname="type" colspan="2"><?= $child->type->name ?></td>
              <td class="tac" colname="permission">edit</td>
            </tr><?php else : ?>
            <tr class="item_T_field" data-item-id="{id}" data-item-type="{type}">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="{key}">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="{name}">
              </td>
              <td class="w100 p0" colname="value">
                <input placeholder="Input value..." value="{value}">
              </td>
              <td colname="type" colspan="2">{type}</td>
              <td class="tac" colname="permission">{permission}</td>
            </tr><?php endif; ?><?php elseif ($child->type->name == 'image') : ?><?php if (isset($child)) : ?>
            <tr class="item_T_image" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="<?= $child->key ?>">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="<?= $child->name ?>">
              </td>
              <td class="w100 p0" colname="value">
                <div class="row"><?php if (isset($child->value['src'])) : ?>
                  <div class="item_T_image__thumbnail row jcc aic"><img src="<?= $child->value['src'] ?>">
                  </div>
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" data-mfp-src="<?= $child->value['src'] ?>">Show
                  </button><?php else : ?>
                  <div class="item_T_image__thumbnail item_T_image__thumbnail_free row jcc aic"><img class="dn" src=""></div>
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" data-mfp-src="" disabled="disabled">Show
                  </button><?php endif; ?>
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__upload-button">Upload
                  </button>
                  <form class="dn item_T_image__file-form">
                    <input class="item_T_image__file" type="file" name="image" accept="image/*">
                  </form>
                </div>
              </td>
              <td colname="type" colspan="2"><?= $child->type->name ?></td>
              <td class="tac" colname="permission">edit</td>
            </tr><?php else : ?>
            <tr class="item_T_image" data-item-id="{id}" data-item-type="{type}">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="{key}">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="{name}">
              </td>
              <td class="w100 p0" colname="value">
                <div class="row">
                  <div class="item_T_image__thumbnail item_T_image__thumbnail_free row jcc aic"><img class="dn" src=""></div>
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__show-button" href="{value}" disabled="disabled">Show
                  </button>
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_image__upload-button">Upload
                  </button>
                  <form class="dn item_T_image__file-form">
                    <input class="item_T_image__file" type="file" name="image" accept="image/*">
                  </form>
                </div>
              </td>
              <td colname="type" colspan="2">{type}</td>
              <td class="tac" colname="permission">edit</td>
            </tr><?php endif; ?><?php elseif ($child->type->name == 'object') : ?><?php if (isset($child)) : ?>
            <tr class="item_T_object" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="<?= $child->key ?>">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="<?= $child->name ?>">
              </td>
              <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = $child->key;
else :
   $loc_path = "{$path}/{$child->key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
              </td>
              <td colname="type" colspan="2"><?= $child->type->name ?></td>
              <td class="tac" colname="permission">edit</td>
            </tr><?php else : ?>
            <tr class="item_T_object" data-item-id="{id}" data-item-type="{type}">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="{key}">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="{name}">
              </td>
              <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = '{key}';
else :
   $loc_path = "{$path}/{key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
              </td>
              <td colname="type" colspan="2">{type}</td>
              <td class="tac" colname="permission">{permission}</td>
            </tr><?php endif; ?><?php elseif ($child->type->name == 'list') : ?><?php if (isset($child)) : ?>
            <tr class="item_T_list" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="<?= $child->key ?>">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="<?= $child->name ?>">
              </td>
              <td class="w100 p0" colname="value">
                <input placeholder="Input value..." value="<?= $child->value ?>">
              </td>
              <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = $child->key;
else :
   $loc_path = "{$path}/{$child->key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
              </td>
              <td colname="type" colspan="1"><?= $child->type->name ?></td>
              <td colname="subtype" colspan="1"><?= $child->subtype->name ?></td>
              <td class="tac" colname="permission">edit</td>
            </tr><?php else : ?>
            <tr class="item_T_list" data-item-id="{id}" data-item-type="{type}">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="{key}">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="{name}">
              </td>
              <td class="w100 p0" colname="value"><?php
$path_i = count($path_parts)+1;
$loc_path;
if ($path == '') :
   $loc_path = '{key}';
else :
   $loc_path = "{$path}/{key}";
endif;?><a class="link p1 db" href="./../field?view=tree&path=<?= $loc_path ?>&curr_path_i=<?= $path_i ?>">Open</a>
              </td>
              <td colname="type" colspan="1">{type}</td>
              <td colname="subtype" colspan="1">{subtype}</td>
              <td class="tac" colname="permission">{permission}</td>
            </tr><?php endif; ?><?php elseif ($child->type->name == 'space') : ?><?php if (isset($child)) : ?>
            <tr class="item_T_space" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="w100 p0 rel" colname="value" colspan="3">
                <input class="w100" placeholder="La Commento..." value="<?= $child->value ?>"><span class="abs <?= ($child->value == '') ? 'dn' : '' ?>">// la commento</span>
              </td>
              <td colname="type" colspan="2"><?= $child->type->name ?></td>
              <td class="tac" colname="permission">edit</td>
            </tr><?php else : ?>
            <tr class="item_T_space" data-item-id="{id}" data-item-type="{type}">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="w100 p0 rel" colname="value" colspan="3">
                <input class="w100" placeholder="La Commento..." value="{value}"><span class="abs dn">// la commento</span>
              </td>
              <td colname="type" colspan="2">{type}</td>
              <td class="tac" colname="permission">{permission}</td>
            </tr><?php endif; ?><?php elseif ($child->type->name == 'text') : ?><?php if (isset($child)) : ?>
            <tr class="item_T_text" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="<?= $child->key ?>">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="<?= $child->name ?>">
              </td>
              <td class="w100 p0" colname="value">
                <button class="box p1 box_mode_dark button tal cup brad0 w100" data-value="<?= $child->value ?>">Text editor
                </button>
              </td>
              <td colname="type" colspan="2"><?= $child->type->name ?></td>
              <td class="tac" colname="permission">edit</td>
            </tr><?php else : ?>
            <tr class="item_T_text" data-item-id="{id}" data-item-type="{type}">
              <td class="page_table-order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
              <td class="p0" colname="key">
                <input placeholder="Input key..." value="{key}">
              </td>
              <td class="p0" colname="name">
                <input placeholder="Input name..." value="{name}">
              </td>
              <td class="w100 p0" colname="value">
                <button class="box p1 box_mode_dark button tal cup brad0 w100" data-value="{value}">Text editor
                </button>
              </td>
              <td colname="type" colspan="2">{type}</td>
              <td class="tac" colname="permission">{permission}</td>
            </tr><?php endif; ?><?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
          </tbody>
        </table>
        <h2 class="tac <?= ( $is_data ? 'dn' : '' ) ?>" id="title_no-data">No data</h2>
      </div><?php elseif ($_GET['view'] == 'type') : ?>type<?php endif; ?>
      <div class="page_foot-panel w100 row jcsb">
        <div class="row">
          <button class="box p1 box_mode_dark button tal cup brad0 page_button-add rel" data-add-link="./../scripts/?script=field-add">Add
            <div class="page_button-add__content abs col top0 left0 dn"><?php $types = $orm->table('type')->select('*')(); ?>
<?php foreach ($types as $curr_type) : ?>
              <div class="box p1 box_mode_dark page_button-add__type" data-id="<?= $curr_type['id_type'] ?>"><?= $curr_type['type_name'] ?>
              </div><?php endforeach; ?>
            </div>
          </button>
          <button class="box p1 box_mode_dark button tal cup brad0 page_button-delete" data-delete-link="./../scripts/?script=field-delete">Delete<span class="dn" style="color: #6CF6FF88" id="button-delete-count"> (<span>0</span>)</span>
          </button>
          <button class="box p1 box_mode_dark button tal cup brad0 page_button-duplicate" data-duplicate-link="./../scripts/?script=field-duplicate">Duplicate<span class="dn" style="color: #6CF6FF88" id="button-duplicate-count"> (<span>0</span>)</span>
          </button>
        </div>
        <div class="row">
          <div class="p1" id="statusbar">Ready</div>
        </div>
      </div>
    </main>
  <script src="../field/field.bundle.js"></script></body>
</html>