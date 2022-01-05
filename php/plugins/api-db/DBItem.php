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

      var $key;
      var $name;
      var $path;

      var DBItemType $type;
      var $subtype; // DBItemType | null

      var $value_id;
      var $value;

      var $parent_id; // ak. parent

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
         $this->parent_id = $this->parent;
      }

      /**
       * Factory function to get behaviour *(consist get_value, create, remove, and so on methods)* for target type. In process of getting behaviour generate T_type object and set an ID to it.
       * @param string|null $type_name Usually taken from $this, exception is when we create field inside of current
       * @return T_field|T_image|T_object|null Returns type object (behaviour) with already set_id. Returns NULL if no relative behaviour have found.
       */
      private function get_type_behaviour($type_name = null) {
         global $reg;

         if ($type_name === null)
            $type_name = $this->type->name;

         if (!array_key_exists($type_name, $reg->DB->type)) {
            echo "<script>console.error(`Error: unable get_value of \"$type_name\" type. This type is not registered correctly. Add it to \$reg->DB->type['$type_name'].`);</script>";
            return null;
         }
            
         $behaviour = new $reg->DB->type[$type_name]($this->orm);
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
         return $this->get_type_behaviour()->get_children($this);
      }
      function get_child(string $key)
      {
         return $this->get_type_behaviour()->get_child($this, $key);
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

      /**
       * @return string $new_field_id
       */
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
         $value = $this->orm->select('`db-item_value`')->where("`id_db-item` = '{$this->id}'")()[0]['db-item_value'];
         if ($value == '') // if object is free
            $value = [];
         else // if object has children
            $value = explode(',', $value);

         array_push($value, $new_field_id);

         // update current field
         $this->orm->from('db-item')->update(['db-item_value' => implode(',', $value)])->where("`id_db-item` = '{$this->id}'")();

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
               return $this->get_type_behaviour()->update($this, $value_set);
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
         $this->get_type_behaviour()->remove($this);

         // self remove
         $parent = new DBItem($this->orm, $this->parent);
         $parent_value = explode(',', $parent->value);
         $this_id_in_val = array_search("{$this->id}", $parent_value);
         unset($parent_value[$this_id_in_val]);

         $parent->orm->update(['db-item_value' => implode(',', $parent_value)])();
         $this->orm->delete()->where_id($this->id)();
      }

      /** @return string $new_field_id */
      function duplicate()
      {
         return DBItem::duplicate_field_to($this, new DBItem($this->orm, $this->parent));
      }

      /** 
       * Duplicate $field to $target_parent, to the end of children. Also duplicate data in T_table using behaviour->duplicate_value_to method.
       * @param DBItem $field Field to be copied with value in T_table.
       * @param DBItem $target_parent Target parent field (object and so on). This object will consist $target at the end of $children after duplicate.
       * @return stdClass<new_field_id,duplicate_res> Return->new_field_id, or ID of duplicate in db-item table. Return->duplicate_res, ot return from T_->duplicate function. */
      static function duplicate_field_to(DBItem $field, DBItem $target_parent)
      {
         $orm = $field->orm;

         // adding new field of target type in db_item scope, value is free and no data duplicate in T_table
         /** @var string $new_field_id */
         $new_field_id = $target_parent->add_field($field->type->id);
         $new_field = new DBItem($orm, $new_field_id);

         // copy key and name of target field in db_item scope
         $field_data = [
            'key' => $field->key,
            'name' => $field->name,
         ];

         // foreach prop (key, name) => copy
         foreach ($field_data as $key => $value) {
            $new_field->update($key, $value);
         }

         // copy VALUE of target file, means copy data in T_table, and so on (e.g. copy image file, or other things)
         // if function works with 'object', then line lower means COPY ALL CHILDREN RECURSIVE.
         $duplicate_res = $field->get_type_behaviour()->duplicate_value_to($field, $new_field);

         $ret = new \stdClass();
         $ret->new_field_id = $new_field_id;
         $ret->duplicate_res = $duplicate_res;

         return $ret;
      }
   };
}
