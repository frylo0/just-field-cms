<?php

namespace JustField {

   /**
    * Required type methods
    *
    * + TYPE->create() - creates new field in type table
    *      @returns new field id
    * + TYPE->remove(DBItem $this) - removes field value from field type table
    *      @returns none 
    *
    * + TYPE->get_value(int $field_id) - takes field value in type table by id in this table
    *      @returns field value
    * + TYPE->get_children(DBItem $this) - get children of field or null if no children
    *      @returns { array<DBItem> | null } children
    * + TYPE->get_child(DBItem $this, string $key) - get child with key or null if no children or no such key 
    *      @returns { DBItem | null } child with key
    *
    * + TYPE->update(DBItem $this, ValueSet $value_set) - updates value of this field
    *      ValueSet: [ 'value' => string, '_FILES' => $_FILES ]
    *      @returns none
    *
    * + TYPE->duplicate_value_to(DBItem $field, DBItem $new_field) - duplicates field value in field type table
    *      @returns none 
    */

   class DBItem
   {
      var $orm;
      var $id;

      function __construct($orm, $id, $parent_path = '')
      {
         $this->orm = $orm;
         $this->id = $id;

         $data = $this->orm->from('db-item')->select('*')->where("`id_db-item` = '$id'")();
         if ($data === false || count($data) == 0) {
            var_dump($data);
            $this->orm->is_simulate = true;
            $sql = $this->orm->from('db-item')->select('*')->where("`id_db-item` = '$id'")();
            throw new \Exception("No data in $id in JustField\\DBItem::__construct ( $sql )");
         }
         $data = $data[0];

         $this->key = $data['db-item_key'];
         $this->name = $data['db-item_name'];

         $this->path = "{$parent_path}/{$this->key}";

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

      private function get_type_behaviour($type_name) {
         global $jf_REG;
         if (!array_key_exists($type_name, $jf_REG['DB']['type'])) {
            echo "<script>console.error(`Error: unable get_value of \"$type_name\" type. This type is not registered correctly. Add it to \$jf_REG['DB']['type']['$type_name'].`);</script>";
            return null;
         }
            
         $behaviour = new $jf_REG['DB']['type'][$type_name]($this->orm);
         $behaviour->set_id($this->id);
         return $behaviour;
      }

      private function get_value($item_data, $type_name)
      {
         $value = $item_data['db-item_value'];

         return $this->get_type_behaviour($type_name)->get_value($value);
      }


      function get_children()
      {
         if (!$this->value) return null;
         return $this->get_type_behaviour($this->type->name)->get_children($this);
      }
      function get_child(string $key)
      {
         return $this->get_type_behaviour($this->type->name)->get_child($this, $key);
      }

      function at_path(string $path)
      {
         $root = $this;

         if (!$path) return $root;

         $parts = explode('/', $path);
         $target = $root;
         foreach ($parts as $part) {
            $child = $target->get_child($part);
            if (!$child)
               throw new \Exception('During "' . $path . '" processing: path part ("' . $part . '") a child');
            $target = $child;
         }

         return $target;
      }

      function add_field($field_type_id)
      {
         //echo '<script>/*' . "1: Adding type id: $field_type_id" . '*/</script>';

         $type = new DBItemType($this->orm, $field_type_id);

         // put value to T table
         $field_id = $this->get_type_behaviour($type->name)->create();

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

         // updating self value (special for duplicate method)
         if ($this->value)
            array_push($this->value, $new_field_id);
         else
            $this->value = [$new_field_id];

         // update current field
         $this->orm->from('db-item')->update(['db-item_value' => implode(',', $this->value)])->where("`id_db-item` = '{$this->id}'")();

         return $new_field_id;
      }

      function update($key, $value)
      {
         switch ($key) {
            case 'value':
               $files = null;
               if (array_key_exists('value', $_FILES))
                  $files = $_FILES['value'];

               $value_set = ['value' => $value, '_FILES' => $files];
               $this->get_type_behaviour($this->type->name)->update($this, $value_set);
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
         $this->get_type_behaviour($this->type->name)->remove($this);

         // self remove
         $parent = new DBItem($this->orm, $this->parent);
         $parent_value = $parent->value;
         $this_id_in_val = array_search("{$this->id}", $parent_value);
         unset($parent_value[$this_id_in_val]);

         $parent->orm->update(['db-item_value' => implode(',', $parent_value)])();
         $this->orm->delete()->where_id($this->id)();
      }

      function duplicate()
      {
         return $this->duplicate_value_to($this, new DBItem($this->orm, $this->parent));
      }

      private function duplicate_value_to(DBItem $field, DBItem $target_parent)
      {
         $orm = $this->orm;

         $new_field_id = $target_parent->add_field($field->type->id);
         $new_field = new DBItem($orm, $new_field_id);

         $field_data = [
            'key' => $field->key,
            'name' => $field->name,
         ];

         foreach ($field_data as $key => $value) {
            $new_field->update($key, $value);
         }

         $this->get_type_behaviour($field->type->name)->duplicate_value_to($field, $new_field);

         return $new_field_id;
      }
   };
}
