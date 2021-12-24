<?php

namespace JustField {
   class T_space
   {
      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $this->type_table_orm->table_prefix .= 'T_';
         $this->type_table_orm->table('space');

         $this->value = '';
         $this->id = null;
      }

      function set_id($id)
      {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create()
      {
         $this->type_table_orm->insert([
            'id_space' => null,
            'space_value' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_space`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update(DBItem $item, array $value)
      {
         $this->type_table_orm->update(['space_value' => $value['value']])->where("`id_space` = '{$this->id}'")();
      }

      function get_value()
      {
         return $this->type_table_orm->select('space_value')->where("`id_space` = '{$this->id}'")()[0]['space_value'];
      }

      function remove()
      {
         $this->type_table_orm->delete()->where_id($this->id)();
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         $new_field->update('value', $field->value);
      }
   }

   $jf_REG['DB']['type']['space'] = 'JustField\T_space';
}