<?php
namespace JustField {

require_once __DIR__ . '/deleteDir.php';
require_once __DIR__ . '/copyDir.php';
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

         $value_raw = json_encode($json->value);
         $value = htmlentities($value_raw);
         $html = $json->html;

         $this->type_table_orm->update([
            'text_value' => $value,
            'text_html' => $html,
         ])->where("`id_text` = '{$this->id}'")();

         return str_replace('"', '\"', $value_raw);
      }

      function get_value()
      {
         $res = $this->type_table_orm->select('text_value, text_html')->where("`id_text` = '{$this->id}'")()[0];

         $ret = new \stdClass();
         $ret->value = $res['text_value'];
         $ret->html = $res['text_html'];

         return $ret;
      }

      function remove()
      {
         $this->type_table_orm->delete()->where_id($this->id)();
         deleteDir(T_text::$assets_folder . $this->id);
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         function replace_id($old_string, $old_id, $new_id) {
            $new_string = $old_string;
            $new_string = str_replace("__assets/T_text/$old_id/", "__assets/T_text/$new_id/", $new_string);
            $new_string = str_replace("__assets\\/T_text\\/$old_id\\/", "__assets\\/T_text\\/$new_id\\/", $new_string);
            return $new_string;
         }

         $new_field->update('value', json_encode([
            'value' => json_decode(
               replace_id(
                  html_entity_decode($field->value->value), 
                  $field->value_id, 
                  $new_field->value_id
               )
            ),
            'html' => replace_id(
               $field->value->html, 
               $field->value_id, 
               $new_field->value_id
            ),
         ]));

         copyDir(
            T_text::$assets_folder . $field->value_id,
            T_text::$assets_folder . $new_field->value_id
         );
      }
   }

   $jf_REG['DB']['type']['text'] = 'JustField\T_text';
}
