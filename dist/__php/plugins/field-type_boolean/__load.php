<?php

namespace JustField {
   class T_boolean {
      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $this->type_table_orm->table_prefix .= 'T_';
         $this->type_table_orm->table('boolean');

         $this->value = '';
         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_boolean' => null,
            'boolean_value' => '0',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_boolean`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update(DBItem $item, array $value) {
         $this->type_table_orm->update(['boolean_value' => $value['value']])->where("`id_boolean` = '{$this->id}'")();
      }

      function get_value() {
         return $this->type_table_orm->select('boolean_value')->where("`id_boolean` = '{$this->id}'")()[0]['boolean_value'];
      }

      function remove() {
         $this->type_table_orm->delete()->where_id($this->id)();
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         $new_field->update('value', $field->value);
      }

      function to_string($item_value) {
         return $item_value;
      }

      static function render_item(DBItem $child) { ?>
         <tr class="item_T_boolean" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>">
            <td class="table__order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="tac" colname="id"><?= $child->id ?></td>
            <td class="p0" colname="key">
               <input placeholder="Input key..." value="<?= htmlspecialChars($child->key) ?>">
            </td>
            <td class="p0" colname="name">
               <input placeholder="Input name..." value="<?= htmlspecialChars($child->name) ?>">
            </td>
            <td class="w100 p1" colname="value"><input type="checkbox" <?= $child->value ? 'checked=\"checked\"' : '' ?> id="item_T_boolean_id_<?= $child->id ?>" />
               <label for="item_T_boolean_id_<?= $child->id ?>"></label>
            </td>
            <td colname="type" colspan="2"><?= $child->type->name ?></td>
            <td class="tac" colname="permission">edit</td>
         </tr>
      <?php }

      static function render_template() { ?>
         <tr class="item_T_boolean" data-item-id="{id}" data-item-type="{type}">
            <td class="table__order row jcc aic cup" colname="order"><img src="../__attach/Images/up-down.svg" draggable="false"></td>
            <td class="tac" colname="id">{id}</td>
            <td class="p0" colname="key">
               <input placeholder="Input key..." value="{key}">
            </td>
            <td class="p0" colname="name">
               <input placeholder="Input name..." value="{name}">
            </td>
            <td class="w100 p1" colname="value"><input type="checkbox" id="item_T_boolean_id_{id}" />
               <label for="item_T_boolean_id_{id}"></label>
            </td>
            <td colname="type" colspan="2">{type}</td>
            <td class="tac" colname="permission">{permission}</td>
         </tr>
      <?php }

      static function render_addictive_templates() {
      }
   }

   $reg->DB->type['boolean'] = 'JustField\T_boolean';
}
