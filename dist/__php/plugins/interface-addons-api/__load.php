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
         $query_pos = strrpos($base, '?');
         if ($query_pos)
            $base = mb_substr($base, 0, $query_pos);

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

      static private function parse_query($url) {
         $query_pos = strrpos($url, '?');

         if ($query_pos == false) {
            $res = new \stdClass();
            $res->url = $url;
            $res->query = [];
            
            return $res;
         }
         // else if '?' have found

         $clear_url = substr($url, 0, $query_pos);
         $clear_query = substr($url, $query_pos + 1);

         $clear_query_split = explode('&', $clear_query);

         $clear_query_arr = [];
         foreach ($clear_query_split as $part) {
            $part_split = explode('=', $part);
            if (count($part_split) == 1)
               $part_split[1] = '';
            $clear_query_arr[$part_split[0]] = $part_split[1];
         }

         $res = new \stdClass();
         $res->url = trim($clear_url, "\t\n\r\0\x0B/");;
         $res->query = $clear_query_arr;

         return $res;
      }


      static function is_url_match($rel_url, $abs_url) {
         $abs1 = Aside::rel2abs($rel_url, $abs_url);
         $abs2 = $abs_url;

         $abs1 = Aside::parse_query($abs1);
         $abs2 = Aside::parse_query($abs2);

         if ($abs1->url == $abs2->url) {
            foreach (array_keys($abs1->query) as $key) {
               if (array_key_exists($key, $abs2->query)) {
                  if ($abs1->query[$key] == $abs2->query[$key])
                     continue;
                  else
                     return false;
               } else
                  return false;
            }
            return true;
         } else
            return false;
      }
   }

   class PluginPage {
      var array $renderers = [];

      function add_renderer($plugin_name, $page_title, $renderer) {
         $this->renderers[$plugin_name] = [$page_title, $renderer];
      }

      function get_title($plugin_name) {
         if (array_key_exists($plugin_name, $this->renderers))
            return $this->renderers[$plugin_name][0];
         else
            return "Error: \"$plugin_name\" has no renderer";
      }

      function render($plugin_name) {
         if (array_key_exists($plugin_name, $this->renderers))
            $this->renderers[$plugin_name][1]();
         else {
            echo <<<HTML
               <div class="box p1">
                  <h1>No plugin page defined for plugin "$plugin_name"</h1>
                  <p>To add plugin page renderer, please use this code in your plugin:<br><code><strong style="font-face: monospace;">\$reg->interface->plugin_page->add_renderer('$plugin_name', function () { /* page code here */ } );</strong></code></p>
               </div>
HTML;
         }
      }
   }

   class InterfacePlugin {
      var Aside $aside;
      var PluginPage $plugin_page;

      function __construct() {
         $this->aside = new Aside();

         $this->aside->add_menu_item('Dashboard', './../dashboard');
         $this->aside->add_menu_item('Fields', './../field');
         $this->aside->add_menu_item('Field types', './../field-type');
         $this->aside->add_menu_item('Accounts', './../account');
         $this->aside->add_menu_item('Backup / Migrate', './../backup');
         $this->aside->add_menu_item('Store', './../store');
         $this->aside->add_menu_item('Plugins', './../plugins');

         $this->plugin_page = new PluginPage();
      }

      
   }

   $reg->interface = new InterfacePlugin();
}
