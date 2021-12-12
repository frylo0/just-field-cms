<?php

namespace JustField {
   $assets_folder = '../__assets/';

   function ends_with($haystack, $needle)
   {
      $length = strlen($needle);
      if (!$length) {
         return true;
      }
      return substr($haystack, -$length) === $needle;
   }
   class T_image
   {
      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $ends_with_T = ends_with($this->orm->table_prefix, 'T_');
         if (!$ends_with_T)
            $this->type_table_orm->table_prefix .= 'T_';

         $this->type_table_orm->table('image');

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
            'id_image' => null,
            'image_src' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_image`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update($value)
      {
         global $assets_folder;

         $old_file = $this->get_value()['src'];
         if (file_exists($old_file)) unlink($old_file);

         $ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
         $target_name = "{$this->id}.{$ext}";
         $target_file = "$assets_folder/$target_name";

         move_uploaded_file($value['tmp_name'], $target_file);

         $this->type_table_orm->update(['image_src' => $target_name])->where("`id_image` = '{$this->id}'")();
         return $target_file;
      }

      function duplicate_file($image_id)
      {
         global $assets_folder;

         $image = new T_image($this->orm);
         $image->set_id($image_id);

         $image_value = $image->get_value();
         $image_src = $image_value['src'];
         $image_name = $image_value['name'];

         $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
         $target_name = "{$this->id}.{$ext}";
         $target_file = "$assets_folder/$target_name";

         if (file_exists($image_src)) {
            file_put_contents($target_file, file_get_contents($image_src));

            $this->type_table_orm->update(['image_src' => $target_name])->where("`id_image` = '{$this->id}'")();
         }

         return $target_file;
      }

      function get_value()
      {
         global $assets_folder;
         
         $src = $this->type_table_orm->select('`image_src`')->where("`id_image` = '{$this->id}'")()[0]['image_src'];
         return [
            'name' => $src,
            'src' => $src ? $assets_folder . $src : '',
         ];
      }

      function delete()
      {
         $old_file = $this->get_value()['src'];
         if (file_exists($old_file)) unlink($old_file);

         $this->type_table_orm->delete()->where_id($this->id)();
      }
   }

   $jf_REG['DB']['type']['image'] = 'JustField\T_image';
}

