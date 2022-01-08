<?php

namespace JustField {

   class T_object {
      var \ORM $orm;
      var $id;

      function __construct($orm) {
         $this->orm = clone $orm;
         $this->id = null;
      }

      function set_id($id) {
         $this->id = $id;
      }

      function create() {
         // all object create logic is in DBItem.php
         return '';
      }

      function update(DBItem $item, $value) {
         $this->orm->update(['db-item_value' => $value['value']])->where("`id_db-item` = '{$this->id}'")();
      }

      function get_value() {
         return $this->orm->select('`db-item_value`')->where("`id_db-item` = '{$this->id}'")()[0]['db-item_value'];
      }

      function get_children(DBItem $item) {
         $value = $item->value;

         if ($value != '') {
            $children = [];

            $children_id = explode(',', $value);
            foreach ($children_id as $child_id) {
               array_push($children, new DBItem($this->orm, $child_id));
            }

            return $children;
         } else {
            return null;
         }
      }

      function get_child(DBItem $item, string $key) {
         $value = $item->value;
         if (!$value) return null;

         $value = explode(',', $value);

         $this->orm->from('db-item');

         foreach ($value as $child_id) {
            $curr = $this->orm->select('*')->where("`id_db-item` = '$child_id'")()[0];
            if ($curr['db-item_key'] == $key) {
               return new DBItem($this->orm, $child_id, $item->path);
            }
         }
         console_log('reached end');
         return null;
      }

      function remove(DBItem $item) {
         // all logic of self remove made by DBItem.php

         // logic of child delete
         $children = $this->get_children($item);
         if ($children) {
            foreach ($children as $child) {
               $child->remove();
            }
         }
      }

      function duplicate_value_to(DBItem $item, DBItem $new_item) {
         // take all OLD children
         $children = $item->get_children($item);

         // if no children in old item, then we can exit
         if (!$children) return; // if no children given, then $children === null
         // if there are some children in old item, then we are here

         $new_children_id = []; // creating array to store children duplicates IDs
         // then iterating each children and making duplicates from old item to new one
         foreach ($children as $child) {
            // receiving duplicate ID to variable
            $new_child_id = DBItem::duplicate_field_to($child, $new_item)->new_field_id; // duplicate child 
            array_push($new_children_id, $new_child_id); // adding duplicate ID to storage
         }
         // if we are here, then $new_children_id is full, and has at list one duplicate ID

         // now lets update the parent of children duplicates, to bind children to parent
         $new_item->update('value', implode(',', $new_children_id)); // insert new children ids as value of new object
      }

      function to_string($item_value) {
         return $item_value;
      }

      static function render_value(DBItem $child) { ?>
         <?php
         $path = substr($child->path, 1);
         $path_parts = explode('/', $path);
         $path_i = count($path_parts);
         ?>
            <a class="link p1 db" href="./../field?view=tree&p=<?= $path ?>&pi=<?= $path_i ?>">Open</a>
      <?php }

      static function render_value_template() { ?>
         <a class="link p1 db" href="./../field?view=tree&p={path}{key}&pi={path_i}">Open</a>
      <?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['object'] = 'JustField\T_object';
}
