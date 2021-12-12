<?php

namespace JustField {

   $jf_REG['DB'] = [];
   $jf_REG['DB']['type'] = [];

   class DB
   {
      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->orm->from('db');
      }

      function get_root()
      {
         return new DBItem($this->orm, '1', '');
      }

      function get_item_data($id)
      {
         return new DBItem($this->orm, $id, '');
      }

      function at_path(string $path)
      {
         $root = $this->get_root();

         if (!$path) return $root;

         return $root->at_path($path);
      }

      function at_id($id)
      {
         return new DBItem($this->orm, $id, '');
      }
   };
};
