<?php

namespace JustField {

class T_object
   {
      var \ORM $orm;
      var $id;

      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->id = null;
      }

      function set_id($id)
      {
         $this->id = $id;
      }

      function create()
      {
         $this->orm->insert([
            'id_field' => null,
            'field_value' => '',
         ])();

         $id = $this->orm->select('MAX(`id_field`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update($value)
      {
         $this->orm->update(['field_value' => $value])->where("`id_field` = '{$this->id}'")();
      }

      function get_value()
      {
         return $this->orm->select('`db-item_value`')->where("`id_db-item` = '{$this->id}'")()[0]['db-item_value'];
      }

      function get_children(DBItem $item)
      {
         $value = $item->value;

         if ($value != '') {
            $children = [];

            $children_id = explode(',', $value);
            foreach ($children_id as $child_id) {
               array_push($children, new DBItem($this->orm, $child_id));
            }

            return $children;
         }
         else {
            return null;
         }
      }

      function get_child(DBItem $item, string $key) {
         $value = $item->value;
         if (!$value) return null;
         console_log('is value');
         console_log('key: ' . $key);
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

      function delete()
      {
         $this->orm->delete()->where_id($this->id)();
      }
   }

   $jf_REG['DB']['type']['object'] = 'JustField\T_object';
}