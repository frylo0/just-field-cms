<?php

namespace JustField {
   class DBItemType
   {
      function __construct($orm, $id)
      {
         $data = $orm->from('type')->select('*')->where("id_type = '$id'")();
         if ($data === false) throw new \Exception('No type data in "' . $id . '" in JustField\\DBItemType::__construct');
         $data = $data[0];

         $this->id = $id;
         $this->is_basic = $data['type_is-basic'] == '1' ? true : false;
         $this->name = $data['type_name'];
         if ($data['type_name'] == 'NULL')
            $this->description = null;
         else {
            $this->description = json_decode($data['type_descr'], true);
         }
      }
   };

   class DBItem
   {
      function __construct($orm, $id)
      {
         $this->orm = $orm;
         $this->id = $id;

         $data = $this->orm->from('db-item')->select('*')->where("`id_db-item` = '$id'")();
         if ($data === false) throw new \Exception('No data in ' . $id . ' in JustField\\DBItem::__construct');
         $data = $data[0];

         $this->key = $data['db-item_key'];
         $this->name = $data['db-item_name'];
         if ($data['db-item_value'] == '')
            $this->value = null;
         else
            $this->value = explode(',', $data['db-item_value']);

         if ($data['db-item_value-type'] == '')
            $this->type = null;
         else
            $this->type = new DBItemType($orm, $data['db-item_value-type']);
         if ($data['db-item_value-subtype'] == '')
            $this->subtype = null;
         else
            $this->subtype = new DBItemType($orm, $data['db-item_value-subtype']);
      }

      function get_children()
      {
         if (!$this->value) return null;

         $res = [];
         foreach ($this->value as $child_id) {
            array_push($res, new DBItem($this->orm, $child_id));
         }
         return $res;
      }
      function get_child($key)
      {
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
   };

   class DB
   {
      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->orm->from('db');
      }

      function get_root()
      {
         return new DBItem($this->orm, '1');
      }

      function get_item_data($id)
      {
         return new DBItem($this->orm, $id);
      }

      function at_path($path)
      {
         $root = $this->get_root();

         if (!$path) return $root;

         $parts = explode('/', $path);
         $target = $root;
         foreach ($parts as $part) {
            $child = $target->get_child($part);
            if (!$child)
               throw new \Exception('During ' . $path . ' processing: path part (' . $part . ') a child');
            $target = $child;
         }

         return $target;
      }
   };
};
