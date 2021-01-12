<?php

namespace JustField {
   class T_image
   {
      function __construct($orm, $glo)
      {
         $this->orm = clone $orm;

         if (!str_ends_with($this->orm->table_prefix, 'T_'))
            $this->orm->table_prefix .= 'T_';

         $this->orm->table('image');

         $this->glo = $glo;
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

      function steal_file($image_id)
      {
         $image = new T_image($this->orm, $this->glo);
         $image->set_id($image_id);

         $image_value = $image->get_value();
         $image_src = $image_value['src'];
         $image_name = $image_value['name'];

         $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
         $target_name = "{$this->id}.{$ext}";
         $target_file = $this->glo['assets'] . "/$target_name";

         file_put_contents($target_file, file_get_contents($image_src));

         $this->orm->update(['image_src' => $target_name])->where("`id_image` = '{$this->id}'")();
         return $target_file;
      }

      function get_value()
      {
         //$this->orm->is_simulate = true;
         //echo '<script> /* ' . $this->orm->select('image_src')->where("`id_image` = '{$this->id}'")() . '*/</script>';
         $src = $this->orm->select('image_src')->where("`id_image` = '{$this->id}'")()[0]['image_src'];
         return [
            'name' => $src,
            'src' => $src ? $this->glo['assets'] . '/' . $src : '',
         ];
         //return [
         //   'name' => '',
         //   'src' => '',
         //];
      }

      function delete()
      {
         $old_file = $this->get_value()['src'];
         if (file_exists($old_file)) unlink($old_file);

         $this->orm->delete()->where_id($this->id)();
      }
   }
}
