<?php

namespace JustField {
   class T_image
   {
      function __construct($orm, $glo)
      {
         $this->orm = clone $orm;
         $this->orm->table_prefix .= 'T_';
         $this->orm->table('image');

         $this->glo = $glo;

         $this->value = '';
         $this->id = null;
      }

      function set_id($id)
      {
         $this->id = $id;
      }

      function create()
      {
         $this->orm->insert([
            'id_image' => null,
            'image_src' => '',
         ])();

         $id = $this->orm->select('MAX(`id_image`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update($value)
      {
         $old_file = $this->get_value()['src'];
         if (file_exists($old_file)) unlink($old_file);

         $ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
         $target_name = "{$this->id}.{$ext}";
         $target_file = $this->glo['assets'] . "/$target_name";

         move_uploaded_file($value['tmp_name'], $target_file);

         $this->orm->update(['image_src' => $target_name])->where("`id_image` = '{$this->id}'")();
         return $target_file;
      }

      function get_value()
      {
         $src = $this->orm->select('image_src')->where("`id_image` = '{$this->id}'")()[0]['image_src'];
         return [
            'name' => $src,
            'src' => $src ? $this->glo['assets'] . '/' . $src : '',
         ];
      }

      function delete()
      {
         $old_file = $this->get_value()['src'];
         var_dump($old_file);

         $this->orm->delete()->where_id($this->id)();
      }
   }
}
