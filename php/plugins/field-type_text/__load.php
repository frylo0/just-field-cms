<?php
namespace JustField {
require_once __DIR__ . '/deleteDir.php';
   class T_text {
      static private string $assets_folder = '../__assets/T_text/';

      function __construct($orm)
      {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $this->type_table_orm->table_prefix .= 'T_';
         $this->type_table_orm->table('text');

         $this->value = '';
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
            'id_text' => null,
            'text_value' => '',
            'text_html' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_text`) as max_id')()[0]['max_id'];
         $this->id = $id;
         
         mkdir(T_text::$assets_folder . $id);
         chmod(T_text::$assets_folder . $id, 0777);

         return $id;
      }

      function update(DBItem $item, array $value)
      {
         $json = json_decode($value['value']);

         $value = htmlentities(json_encode($json->value));
         $html = $json->html;

         $this->type_table_orm->update([
            'text_value' => $value,
            'text_html' => $html,
         ])->where("`id_text` = '{$this->id}'")();
      }

      function get_value()
      {
         $res = $this->type_table_orm->select('text_value, text_html')->where("`id_text` = '{$this->id}'")()[0];
         return [
            'value' => $res['text_value'],
            'html' => $res['text_html'],
         ];
      }

      function remove()
      {
         $this->type_table_orm->delete()->where_id($this->id)();
         deleteDir(T_text::$assets_folder . $this->id);
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         $new_field->update('value', $field->value);
         //$new_field->update('html', $field->value);
      }
   }

   $jf_REG['DB']['type']['text'] = 'JustField\T_text';
}
