<?php

namespace JustField {
   class DBItem
   {
      function __construct($orm, $id)
      {
         $this->orm = $orm;
         $this->id = $id;

         $data = $this->orm->from('db-item')->select('*')->where("`id_db-item` = '$id'")();
         if ($data === false || count($data) == 0) {
            $this->orm->is_simulate = true;
            $sql = $this->orm->from('db-item')->select('*')->where("`id_db-item` = '$id'")();
            throw new \Exception("No data in $id in JustField\\DBItem::__construct ( $sql )");
         }
         $data = $data[0];

         $this->key = $data['db-item_key'];
         $this->name = $data['db-item_name'];

         if ($data['db-item_value-type'] == '')
            $this->type = null;
         else
            $this->type = new DBItemType($orm, $data['db-item_value-type']);
         if ($data['db-item_value-subtype'] == '')
            $this->subtype = null;
         else
            $this->subtype = new DBItemType($orm, $data['db-item_value-subtype']);

         $this->value = $this->get_value($data, $this->type->name);
         $this->value_id = $data['db-item_value'];

         $this->parent = $data['db-item_parent'];
      }

      private function get_value($item_data, $type_name)
      {
         $value = $item_data['db-item_value'];

         if ($value == '') return null;

         switch ($type_name) {
            case 'field':
               $field = new T_field($this->orm);
               $field->set_id($value);
               return $field->get_value();

            case 'list':
            case 'object':
               return explode(',', $value);
         };
      }


      function get_children()
      {
         if (!($this->type->name == 'list' || $this->type->name == 'object')) return null;
         if (!$this->value) return null;

         $res = [];
         foreach ($this->value as $child_id) {
            array_push($res, new DBItem($this->orm, $child_id));
         }
         return $res;
      }
      function get_child($key)
      {
         if (!($this->type->name == 'list' || $this->type->name == 'object')) return null;
         if (!$this->value) return null;

         $this->orm->from('db-item');

         foreach ($this->value as $child_id) {
            $curr = $this->orm->select('*')->where("`id_db-item` = '$child_id'")()[0];
            if ($curr['db-item_key'] == $key) {
               return new DBItem($this->orm, $child_id);
            }
         }
         return null;
      }

      function add_field($field_type_id)
      {
         $type = new DBItemType($this->orm, $field_type_id);

         $field_id = null;

         if (!($type->name == 'object' || $type->name == 'list')) {
            // put value to T table
            $field = new T_field($this->orm);
            $field_id = $field->create();
         }

         // insert new field
         $this->orm->from('db-item')->insert([
            'id_db-item' => null,
            'db-item_key' => null,
            'db-item_name' => '',
            'db-item_value' => $field_id ? "$field_id" : '',
            'db-item_value-type' => "$field_type_id",
            'db-item_value-subtype' => null,
            'db-item_parent' => $this->id,
         ])();

         // taking new field id
         $new_field_id = $this->orm->select('MAX(`id_db-item`) AS max_id')()[0]['max_id'];

         // update current field
         $this->orm->from('db-item')->update([
            'db-item_value' => ($this->value ? implode(',', $this->value) . ',' : '') . $new_field_id,
         ])->where("`id_db-item` = '{$this->id}'")();

         return $new_field_id;
      }

      function update($key, $value)
      {
         switch ($key) {
            case 'value':
               switch ($this->type->name) {
                  case 'field':
                     $field = new T_field($this->orm);
                     $field->set_id($this->value_id);
                     $field->update($value);
                     break;
               }
               break;
            case 'key':
            case 'name':
               $this->orm->from('db-item')->update([
                  "db-item_$key" => "$value",
               ])->where("`id_db-item` = '{$this->id}'")();
               break;
            default:
               throw new \Exception("Error: DBItem::update(\$key=$key, \$value=$value) - unexpected key ($key)");
         };
      }

      function remove()
      {
         // value remove
         switch ($this->type->name) {
            case 'field':
               $field = new T_field($this->orm);
               $field->set_id($this->value_id);
               $field->delete();
               break;
            case 'object':
            case 'list':
               $children = $this->get_children();
               if ($children) {
                  foreach ($children as $child) {
                     $child->remove();
                  }
               }
         };

         // self remove
         $parent = new DBItem($this->orm, $this->parent);
         $parent_value = $parent->value;
         $this_id_in_val = array_search("{$this->id}", $parent_value);
         unset($parent_value[$this_id_in_val]);

         $parent->orm->update(['db-item_value' => implode(',', $parent_value)])();
         $this->orm->delete()->where_id($this->id)();
      }
   };
}
