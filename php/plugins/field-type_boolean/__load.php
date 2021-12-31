<?php

namespace JustField {
   class T_boolean
   {
      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $this->type_table_orm->table_prefix .= 'T_';
         $this->type_table_orm->table('boolean');

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
            'id_boolean' => null,
            'boolean_value' => '0',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_boolean`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update(DBItem $item, array $value)
      {
         $this->type_table_orm->update(['boolean_value' => $value['value']])->where("`id_boolean` = '{$this->id}'")();
      }

      function get_value()
      {
         return $this->type_table_orm->select('boolean_value')->where("`id_boolean` = '{$this->id}'")()[0]['boolean_value'];
      }

      function remove()
      {
         $this->type_table_orm->delete()->where_id($this->id)();
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         $new_field->update('value', $field->value);
      }
   }

   $jf_REG['DB']['type']['boolean'] = 'JustField\T_boolean';
}
