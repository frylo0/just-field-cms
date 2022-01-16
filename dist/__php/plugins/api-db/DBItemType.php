<?php

namespace JustField {

   /**
    * @property bool $is_basic Defines if type is basic. Basic types are built in in CMS. Deleting of basic type can bring a lot of errors.
    * @property bool $has_children Defines if type can nest other DBItems. Simples example is "object" type.
    * @property string $name The name of type.
    * @property string $icon Icon file name in type plugin folder.
    * @property array $description JSON array, telling which properties value of type has.
    * 
    * @property \ORM $orm The ORM, to execute queries to data base.
    * @property mixed $id The id of type in type table.
    */
   class DBItemType
   {
      function __construct($orm, $id)
      {
         $orm = clone $orm;
         $this->orm = $orm;
         $this->id = $id;
      }


      private function get_orm_db_item_type_prop($prop) {
         $this->orm->table('type');
         $res = $this->orm->select("`type_$prop`")->where("`id_type` = '{$this->id}'")()[0]["type_$prop"];
         return $res;
      }
      private function set_orm_db_item_prop($prop, $value) {
         $res = $this->orm->update(["type_$prop" => $value])->where("`id_type` = '{$this->id}'")();
         return $res;
      }

      
      private function magic_get($prop) {
         $target_prop = $prop; // because some props has few props with different names

         if ($prop == 'is_basic')
            $target_prop = 'is-basic';
         else if ($prop == 'has_children')
            $target_prop = 'has-children';
         else if ($prop == 'is_local')
            $target_prop = 'is-local';

         switch ($prop) {
            case 'is_basic':
            case 'has_children':
            case 'is_local':
               $res = $this->get_orm_db_item_type_prop($target_prop);
               return $res == '1' ? true : false;
               break;

            case 'name':
            case 'icon':
               return $this->get_orm_db_item_type_prop($target_prop);
               break;

            case 'description':
               $target_prop = 'descr';
               $res = $this->get_orm_db_item_type_prop($target_prop);

               $name = $this->name;
               if ($name == 'NULL')
                  return null;
               else
                  return json_decode($res, true);

               break;

            default:
               return $this->{$prop};
               break;
         };
      }

      private function magic_set($prop, $value) {
         $target_prop = $prop; // because some props has few props with different names
         switch ($prop) {
            case 'type':
            case 'subtype':
               $target_prop = 'value-'.$target_prop; // value-type, value-subtype
               return $this->set_orm_db_item_prop($target_prop, $value);
               break;

            case 'value_id':
               $target_prop = 'value';
            case 'parent_id':
               $target_prop = 'parent';
            case 'key':
            case 'name':
            case 'path':
               return $this->set_orm_db_item_prop($target_prop, $value);
               break;
            case 'value':
               return $this->set_orm_db_item_prop('value', $value);
               break;
            default:
               return $this->{$prop} = $value;
               break;
         };
      }


      function __get($prop) {
         return $this->magic_get($prop);
      }
      function __set($prop, $value) {
         return $this->magic_set($prop, $value);
      }
   };
}
