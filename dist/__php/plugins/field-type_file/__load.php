<?php

namespace JustField {
   $assets_folder = '../__assets/';

   class T_file {
      function __construct($orm) {
         $this->orm = clone $orm;
         $this->type_table_orm = clone $orm;

         $ends_with_T = ends_with($this->orm->table_prefix, 'T_');
         if (!$ends_with_T)
            $this->type_table_orm->table_prefix .= 'T_';

         $this->type_table_orm->table('file');

         $this->id = null;
      }

      function set_id($id) {
         $type_table_id = $this->orm->select('`db-item_value`')->where("`id_db-item` = '$id'")()[0]['db-item_value'];
         $this->id = $type_table_id;
      }

      function create() {
         $this->type_table_orm->insert([
            'id_file' => null,
            'file_src' => '',
         ])();

         $id = $this->type_table_orm->select('MAX(`id_file`) as max_id')()[0]['max_id'];
         $this->id = $id;
         return $id;
      }

      function update(DBItem $item, $value) {
         $value = $value['_FILES'];
         global $assets_folder;

         if ($value['error'] != UPLOAD_ERR_OK) 
            throw new UploadException($value['error']);

         $old_file = $this->get_value()->src;
         if (file_exists($old_file)) unlink($old_file);

         $ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
         $target_name = "f{$this->id}.{$ext}";
         $target_file = "$assets_folder$target_name"; // assets_folder has '/' at end

         move_uploaded_file($value['tmp_name'], $target_file);
         chmod($target_file, 0777);

         $this->type_table_orm->update(['file_src' => $target_name])->where("`id_file` = '{$this->id}'")();
         return $target_file;
      }

      function duplicate_value_to(DBItem $field, DBItem $new_field) {
         global $assets_folder;

         $file_value = $field->value;
         $file_src = $file_value->src;
         $file_name = $file_value->name;

         $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
         $target_name = "f{$new_field->value_id}.{$ext}";
         $target_file = "$assets_folder$target_name"; // assets folder already have '/' at end

         if (file_exists($file_src)) {
            file_put_contents($target_file, file_get_contents($file_src)); // copy file contents to new field file
            chmod($target_file, 0777);

            $this->type_table_orm->update(['file_src' => $target_name])->where("`id_file` = '{$new_field->value_id}'")();
         }

         return $target_file;
      }

      function get_value() {
         global $assets_folder;

         $src = $this->type_table_orm->select('`file_src`')->where("`id_file` = '{$this->id}'")()[0]['file_src'];

         $ret = new \stdClass();
         $ret->name = $src;
         $ret->src = $src ? $assets_folder . $src : '';

         return $ret;
      }

      function remove(DBItem $item) {
         $old_file = $item->value->src;
         if (file_exists($old_file)) unlink($old_file);

         $this->type_table_orm->delete()->where_id($this->id)();
      }

      function to_string($item_value) {
         return $item_value->src;
      }

      static function render_item(DBItem $child) { ?>

         <tr
            class="item_T_file"
            data-item-id="<?=$child->id?>"
            data-item-type="<?= $child->type->name ?>"
         >
            <td colname='order' class="table__order row jcc aic cup" >
               <img src="../__attach/Images/up-down.svg" draggable="false" />
            </td>
            <td colname='id' class="tac"><?= $child->id ?></td>
            <td colname='key' class="p0">
               <input placeholder='Input key...' value="<?= htmlspecialChars($child->key) ?>" />
            </td>
            <td colname='name' class="p0">
               <input placeholder='Input name...' value="<?= htmlspecialChars($child->name) ?>" />
            </td>
            <td colname="value" class="w100 p0">
               <div class="row">
                  <?php if ($child->value->src) : ?>
                     <button class="box p1 box_mode_dark button tal cup brad0 item_T_file__download-button">
                        <a href="<?= $child->value->src ?>" download="">
                           Download
                        </a>
                     </button>
                  <?php else : ?>
                     <button class="box p1 box_mode_dark button tal cup brad0 item_T_file__download-button" disabled="disabled">
                        <a href="" download="">
                           Download
                        </a>
                     </button>
                  <?php endif; ?>
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_file__upload-button">
                     Upload
                  </button>
                  <form class="dn item_T_file__file-form">
                     <input class="item_T_file__file" type="file" name="file" accept="*" />
                  </form>
               </div>
            <td colname='type' colspan=2><?= $child->type->name ?></td>
            <td colname='permission' class="tac">edit</td>
         </tr>

      <?php }

      static function render_template() { ?>

         <tr
            class="item_T_file"
            data-item-id="{id}"
            data-item-type="{type}"
         >
            <td colname='order' class="table__order row jcc aic cup" >
               <img src="../__attach/Images/up-down.svg" draggable="false" />
            </td>
            <td colname='id' class="tac">{id}</td>
            <td colname='key' class="p0">
               <input placeholder='Input key...' value="{key}" />
            </td>
            <td colname='name' class="p0">
               <input placeholder='Input name...' value="{name}" />
            </td>
            <td colname="value" class="w100 p0">
               <div class="row">
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_file__download-button" disabled="disabled">
                     <a href="{value}" download="">
                        Download
                     </a>
                  </button>
                  <button class="box p1 box_mode_dark button tal cup brad0 item_T_file__upload-button">
                     Upload
                  </button>
                  <form class="dn item_T_file__file-form">
                     <input class="item_T_file__file" type="file" name="file" accept="*" />
                  </form>
               </div>
            <td colname='type' colspan=2>{type}</td>
            <td colname='permission' class="tac">edit</td>
         </tr>

      <?php }

      static function render_addictive_templates() {

      }
      
   }

   $reg->DB->type['file'] = 'JustField\T_file';
}
