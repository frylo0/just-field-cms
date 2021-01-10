<?php

namespace JustField {
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

      function at_id($id)
      {
         return new DBItem($this->orm, $id);
      }
   };
};
