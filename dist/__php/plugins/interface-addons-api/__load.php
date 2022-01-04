<?php

namespace JustField\InterfacePlugin {

   class Aside {
      var array $menu_items = [];

      function __construct() {
      }

      function add_menu_item($title, $link) {
         $val = new \stdClass();
         $val->title = $title;
         $val->link = $link;

         array_push($this->menu_items, $val);
      }

      static function rel2abs($rel, $base) {
         $rel = trim($rel, "\t\n\r\0\x0B/");
         $base = trim($base, "\t\n\r\0\x0B/");

         $base_arr = explode('/', $base);
         $rel_arr = explode('/', $rel);

         foreach($rel_arr as $part) {
            if ($part == '..') {
               array_pop($base_arr);
            }
            else if ($part == '.') {
               continue;
            }
            else { // path part
               array_push($base_arr, $part);
            }
         }

         return implode('/', $base_arr);
      }
   }

   class InterfacePlugin {
      var Aside $aside;

      function __construct() {
         $this->aside = new Aside();

         $this->aside->add_menu_item('Dashboard', './../dashboard');
         $this->aside->add_menu_item('Fields', './../field');
         $this->aside->add_menu_item('Field types', './../field-type');
         $this->aside->add_menu_item('Accounts', './../account');
         $this->aside->add_menu_item('Backup / Migrate', './../backup');
         $this->aside->add_menu_item('Store', './../store');
         $this->aside->add_menu_item('Plugins', './../plugins');
      }
   }

   $reg->interface_plugin = new InterfacePlugin();
}
