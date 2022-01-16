<?php

namespace JustField {

   use Exception;

   class DBItemPropRegister {
      private DBItem $item;

      function __construct(DBItem $item) {
         $this->item = $item;
      }

      function __get($path)
      {
         return $this->item->at_path($path);
      }
      function __set($path, $value)
      {
         return $this->item->at_path($path)->update('value', $value);
      }
      function __call($name, $args) {
         throw new Exception("DBItem->prop->{$name} call error. Props can are not callable.");
      }
   };

   class DBItemPathWalkerNull {
      function __get($name) {
         return new DBItemPathWalkerNull();
      }
      function __set($name, $value) {
         throw new \Error('Trying to set value to DBItemPathWalkerNull, this property don\'t exists.');
      }
      function __call($name, $args) {
         // if value taking
         if (!array_key_exists(0, $args) || !$args[0]) {
            return null;
         } else // else return null walker
            return $this;
      }
      function __toString() {
         return '';
      }
   }
   class DBItemPathWalker {
      private DBItem $item;
      function __construct($item) {
         $this->item = $item;
      }

      function __get($name) {
         return new DBItemPathWalker($this->item->at_path($name));
      }

      function __call($name, $args) {
         // if walker modifier given
         if (array_key_exists(0, $args)) {
            if ($args[0] == 'item') // if taking item
               return $this->item->at_path($name);
            else if ($args[0] == 'exists') // if check path existence
               if ($this->item->has_path($name)) // if path exists then return walker
                  return new DBItemPathWalker($this->item->at_path($name));
               else
                  return new DBItemPathWalkerNull(); // if no such path then return null walker
            else if ($args[0] == 'children') // if taking children
               return $this->item->at_path($name)->get_children();
         } else
            return $this->item->at_path($name)->value;
      }

      function __toString() {
         return $this->item->__toString();
      }
   }

   /**
    * @property string $key The key of item. Used to specify paths. Have to be unique within one parent.
    * @property string $name Understandable for user field description. Can be not unique.
    * @property string $path Global item path in data base.
    * @property DBItemType $type Item db-type info, such as type name and so on.
    * @property DBItemType|null $subtype Item db-subtype info, such as subtype name an so on.
    * @property string $value_id The content of db-item_value property. Can be T_{type} table id or something else. To reach value use "value" property.
    * @property mixed $value The value of item. Content depend on T_{type} behaviour.
    * @property string $parent_id id_db-item of parent element.
    * @property DBItem $parent The parent item.
    * 
    * @property \ORM $orm Data base ORM, with connection, to execute queries.
    * @property mixed $id Item id_db-item.
    * @property DBItemPathWalker $walker Entry point to "walker" mode. Very useful when you output data in html.
    */

   class DBItem
   {
      private $_orm;
      private $_id;

      private DBItemPropRegister $_props; // useful path getter by getter setter
      private DBItemPathWalker $_walker;

      function __construct(\ORM $orm, $id)
      {
         $this->_orm = $orm;
         $this->_id = $id;
         $this->_props = new DBItemPropRegister($this);
         $this->_walker = new DBItemPathWalker($this);

         $type_name = $this->magic_get('type')->name;
         $behaviour = $this->get_type_behaviour($type_name);

         if (method_exists(get_class($behaviour), 'on_construct')) {
            $this->api = new \JustFieldRegister();
            $behaviour::on_construct($this->api, $this);
         }
      }


      private function get_orm_db_item_prop($prop) {
         $this->orm->table('db-item');
         $res = $this->orm->select("`db-item_$prop`")->where("`id_db-item` = '{$this->id}'")()[0]["db-item_$prop"];
         return $res;
      }
      private function set_orm_db_item_prop($prop, $value) {
         $res = $this->orm->update(["db-item_$prop" => $value])->where("`id_db-item` = '{$this->id}'")();
         return $res;
      }

      
      private function magic_get($prop) {
         $target_prop = $prop; // because some props has few props with different names
         switch ($prop) {
            case 'type':
            case 'subtype':
               $target_prop = 'value-'.$target_prop; // value-type, value-subtype
               $res = $this->get_orm_db_item_prop($target_prop);

               if ($res == '') // if no type
                  return null;
               else // else if type
                  return new DBItemType($this->orm, $res);
               break;

            case 'value_id':
               $target_prop = 'value';
               return $this->get_orm_db_item_prop($target_prop);
               break;
            case 'parent_id':
               $target_prop = 'parent';
               return $this->get_orm_db_item_prop($target_prop);
               break;

            case 'key':
            case 'name':
            case 'path':
               return $this->get_orm_db_item_prop($target_prop);
               break;

            case 'parent':
               $res = $this->get_orm_db_item_prop('parent');
               return new DBItem($this->orm, $res);
               break;
            case 'value':
               $res = $this->get_orm_db_item_prop('value');
               return $this->get_value($res);
               break;

            case 'id':
               return $this->_id; break;
            case 'orm':
               return $this->_orm; break;
            case 'props':
               return $this->_props; break;
            case 'walker':
               return $this->_walker; break;
               
            default:
               return $this->{$prop};
               break;
         };
      }

      private function magic_set($prop, $value) {
         // TODO: fix unlogic functional, use magic_get as ideal
         $target_prop = $prop;
         switch ($prop) {
            case 'key':
            case 'name':
            case 'parent':
            case 'path':
            case 'value':
               $this->update($target_prop, $value);
               break;
            case 'id':
            case 'orm':
            case 'props':
               throw new \Error("Dear fritylo, to set '$prop', please define magic_set method functionality first.");
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
      

      /**
       * Factory function to get behaviour *(consist get_value, create, remove, and so on methods)* for target type. In process of getting behaviour generate T_type object and set an ID to it.
       * @param string|null $type_name Usually taken from $this, exception is when we create field inside of current
       * @return T_field|T_image|T_object|T_mirror|null Returns type object (behaviour) with already set_id. Returns NULL if no relative behaviour have found.
       */
      function get_type_behaviour($type_name = null) {
         global $reg;

         if ($type_name === null)
            $type_name = $this->type->name;

         if (!array_key_exists($type_name, $reg->DB->type)) {
            echo "<script>console.error(`Error: unable get_value of \"$type_name\" type. This type is not registered correctly. Add it to \$reg->DB->type['$type_name'].`);</script>";
            return null;
         }
            
         $behaviour = new $reg->DB->type[$type_name]($this->orm);
         $behaviour->set_id($this->id);

         return $behaviour;
      }

      private function get_value($db_item_value, $type_name = null)
      {
         if ($type_name === null)
            $type_name = $this->type->name;
         return $this->get_type_behaviour($type_name)->get_value($db_item_value);
      }


      private function get_parent_path() {
         if ($this->parent_id) {
            $parent = new DBItem($this->orm, $this->parent_id);
            return ($parent->path == '/' ? '' : $parent->path );
         }
         else {
            return '';
         }
      }


      function get_children()
      {
         if (!$this->value) return null;
         return $this->get_type_behaviour()->get_children($this, false); // false - don't capture local admin items
      }
      function get_children_all()
      {
         if (!$this->value) return null;
         return $this->get_type_behaviour()->get_children($this, true); // true - capture local admin items
      }
      function get_child(string $key)
      {
         return $this->get_type_behaviour()->get_child($this, $key);
      }
      function get_nesters()
      {
         if ($this->type->has_children) {
            $nesters = [];
            $children = $this->get_children();

            if ($children) {
               foreach ($children as $child) {
                  array_push($nesters, $child);
                  if ($child->type->has_children) {
                     $nesters = array_merge($nesters, $child->get_nesters());
                  }
               }
            }

            return $nesters;
         }
         else { // no children in field
            return [];
         }
      }

      function at_path(string $path)
      {
         if (!$path) return $this;

         $this_path = $this->path == '/' ? '' : $this->path;

         $res = $this->orm->select('`id_db-item` as \'id\'')->where("`db-item_path` = '{$this_path}/{$path}'")();
         if ($res) {
            $target_id = $res[0]['id'];
            return new DBItem($this->orm, $target_id);
         }
         else {
            throw new \Error("No field found at path '{$this_path}/{$path}'. Reached when DBItem('{$this->path}')->at_path('$path').");
         }
      }
      
      function has_path(string $path) {
         if (!$path) return $this;

         $this_path = $this->path == '/' ? '' : $this->path;

         $res = $this->orm->select('`id_db-item` as \'id\'')->where("`db-item_path` = '{$this_path}/{$path}'")();
         if ($res) {
            $target_id = $res[0]['id'];
            return $target_id;
         }
         else {
            return false;
         }
      }

      /**
       * @return string $new_field_id
       */
      function add_field($field_type_id)
      {
         $type = new DBItemType($this->orm, $field_type_id);

         // put value to T table
         $field_id = $this->get_type_behaviour($type->name)->create();

         // insert new field
         $this->orm->from('db-item')->insert([
            'id_db-item' => null,
            'db-item_key' => null,
            'db-item_name' => '',
            'db-item_value' => $field_id ? "$field_id" : '',
            'db-item_value-type' => "$field_type_id",
            'db-item_value-subtype' => null,
            'db-item_parent' => $this->id,
            'db-item_path' => $this->get_parent_path() . '/' . ($this->key == '/' ? '' : $this->key ),
         ])();

         // taking new field id
         $new_field_id = $this->orm->select('MAX(`id_db-item`) AS max_id')()[0]['max_id'];

         $this->update_children_value(
         function (array &$children) use ($new_field_id) {
            array_push($children, $new_field_id);
         });

         return new DBItem($this->orm, $new_field_id);
      }

      function update($key, $value)
      {
         switch ($key) {
            case 'value':
               $files = null;
               if (array_key_exists('value', $_FILES))
                  $files = $_FILES['value'];

               $value_set = ['value' => $value, '_FILES' => $files];
               $res = $this->get_type_behaviour()->update($this, $value_set);
               return $res;
               break;

            case 'key':
            case 'name':
            case 'parent':
            case 'path':
               // update value
               $this->orm->from('db-item')->update([
                  "db-item_$key" => "$value",
               ])->where("`id_db-item` = '{$this->id}'")();
               // call handler
               $behaviour = $this->get_type_behaviour();
               if (method_exists($behaviour, "on_update_$key"))
                  $behaviour->{"on_update_$key"}($this, $value);
               break;

            default:
               throw new \Exception("Error: DBItem::update(\$key=$key, \$value=$value) - unexpected key ($key)");
         };
         if ($key == 'key') {
            $this->update_path();
            
            $nesters = $this->get_nesters();
            foreach ($nesters as $nester)
               $nester->update_path();
         }
      }
      function update_path() {
         // self path update
         $this->update('path', $this->get_parent_path() . '/' . ($this->key == '/' ? '' : $this->key ));
         // nesters path update if exist
         $nesters = $this->get_nesters();
         foreach ($nesters as $nester)
            $nester->update_path();
      }
      function update_children_value($callback) {
         // updating self value (special for duplicate method)
         $value = $this->orm->select('`db-item_value`')->where("`id_db-item` = '{$this->id}'")()[0]['db-item_value'];
         if ($value == '') // if object is free
            $value = [];
         else // if object has children
            $value = explode(',', $value);

         $callback($value);

         // update current field
         $this->orm->from('db-item')->update(['db-item_value' => implode(',', $value)])->where("`id_db-item` = '{$this->id}'")();
      }

      function remove()
      {
         $this->get_type_behaviour()->remove($this);

         // self remove
         $parent = new DBItem($this->orm, $this->parent_id);

         $self = $this;
         $parent->update_children_value(
         function (array &$children) use ($self) {
            $this_id_in_val = array_search("{$self->id}", $children);
            unset($children[$this_id_in_val]);
         });

         $this->orm->delete()->where_id($this->id)();
      }

      /** @return string $new_field_id */
      function duplicate()
      {
         return DBItem::duplicate_field_to($this, new DBItem($this->orm, $this->parent_id));
      }

      /** 
       * Duplicate $field to $target_parent, to the end of children. Also duplicate data in T_table using behaviour->duplicate_value_to method.
       * @param DBItem $field Field to be copied with value in T_table.
       * @param DBItem $target_parent Target parent field (object and so on). This object will consist $target at the end of $children after duplicate.
       * @return stdClass<new_field_id,duplicate_res> Return->new_field_id, or ID of duplicate in db-item table. Return->duplicate_res, ot return from T_->duplicate function. */
      static function duplicate_field_to(DBItem $field, DBItem $target_parent)
      {
         $orm = $field->orm;

         // adding new field of target type in db_item scope, value is free and no data duplicate in T_table
         /** @var string $new_field_id */
         $new_field = $target_parent->add_field($field->type->id);

         // copy key and name of target field in db_item scope
         $field_data = [
            'key' => $field->key,
            'name' => $field->name,
         ];

         // foreach prop (key, name) => copy
         foreach ($field_data as $key => $value) {
            $new_field->update($key, $value);
         }

         // copy VALUE of target file, means copy data in T_table, and so on (e.g. copy image file, or other things)
         // if function works with 'object', then line lower means COPY ALL CHILDREN RECURSIVE.
         $duplicate_res = $field->get_type_behaviour()->duplicate_value_to($field, $new_field);

         $ret = new \stdClass();
         $ret->new_field_id = $new_field_id;
         $ret->duplicate_res = $duplicate_res;

         return $ret;
      }

      function move_to(DBItem $target_parent) {
         $self = $this;

         // taking old parent
         $old_parent = new DBItem($this->orm, $this->parent_id);

         $old_parent->update_children_value(
         function (array &$children) use ($self) {
            $children = array_filter($children, function ($value) use ($self) {
               return $value != $self->id;
            });
         });

         // adding this field id to new parent value
         $target_parent->update_children_value(
         function (&$children) use ($self) {
            array_push($children, $self->id);
         });

         // updating this field parent id
         $this->update('parent', $target_parent->id);
         $this->update_path();

         // rendering field html, to return it by call stack via output buffering (ob_start(), ob_get_clear())
         $this->get_type_behaviour()->render_value($this);
      }
      
      function __toString() {
         return $this->get_type_behaviour()->to_string($this->value);
      }

      static function render(string $type_name, DBItem $child = null) { ?>
         <?php
            global $reg;

            // props generating

            $render_props_default = [
               'tr_class_addon' => '',
               'tr_attr_addon' => '',
               'render_order' => true,
               'render_id' => true,
               'render_key' => true,
               'render_name' => true,
               'render_type' => true,
               'render_permission' => true,
               'value_colspan' => 1,
               'value_classes' => 'w100 p0',
               'value_td_attr' => '',
            ];

            $props = $render_props_default;

            $props_new = [];
            if (method_exists($reg->DB->type[$type_name], 'render_props'))
               $props_new = $reg->DB->type[$type_name]::render_props($child);

            foreach ($props_new as $key => $value)
               $props[$key] = $value;
         ?>


         <?php if ($child) : ?>

            <tr class="item_T_<?= $child->type->name ?> <?= $props['tr_class_addon'] ?>" data-item-id="<?= $child->id ?>" data-item-type="<?= $child->type->name ?>" <?= $props['tr_attr_addon'] ?>>
               <?php if ($props['render_order']) : ?>
                  <td class="table__order row jcc aic cup" colname="order">
                     <img src="../__attach/Images/up-down.svg" draggable="false" />
                  </td>
               <?php endif; ?>
               <?php if ($props['render_id']) : ?>
                  <td class="tac" colname="id"><?= $child->id ?></td>
               <?php endif; ?>
               <?php if ($props['render_key']) : ?>
                  <td class="p0" colname="key">
                     <input placeholder="Input key..." value="<?= htmlspecialChars($child->key) ?>">
                  </td>
               <?php endif; ?>
               <?php if ($props['render_name']) : ?>
                  <td class="p0" colname="name">
                    <input placeholder="Input name..." value="<?= htmlspecialChars($child->name) ?>">
                  </td>
               <?php endif; ?>
               <td colname="value" class="<?= $props['value_classes'] ?>" colspan="<?= $props['value_colspan'] ?>" <?= ($props['value_td_attr'] ? $props['value_td_attr'] : "data-item-id=\"{$child->id}\" data-item-type=\"{$child->type->name}\"") ?> >
                  <?php $reg->DB->type[$child->type->name]::render_value($child); ?>
               </td>
               <?php if ($props['render_type']) : ?>
                  <td colname="type" colspan="2"><?= $child->type->name ?></td>
               <?php endif; ?>
               <?php if ($props['render_permission']) : ?>
                  <td class="tac" colname="permission">edit</td>
               <?php endif; ?>
            </tr>

         <?php else : ?>

            <tr class="item_T_<?= $type_name ?> <?= $props['tr_class_addon'] ?>" data-item-id="{id}" data-item-type="{type}" <?= $props['tr_attr_addon'] ?>>
               <?php if ($props['render_order']) : ?>
                  <td colname='order' class="table__order row jcc aic cup">
                     <img src="../__attach/Images/up-down.svg" draggable="false" />
                  </td>
               <?php endif; ?>
               <?php if ($props['render_id']) : ?>
                  <td colname='id' class="tac">{id}</td>
               <?php endif; ?>
               <?php if ($props['render_key']) : ?>
                  <td colname='key' class="p0">
                     <input placeholder='Input key...' value="{key}" />
                  </td>
               <?php endif; ?>
               <?php if ($props['render_name']) : ?>
                  <td colname='name' class="p0">
                     <input placeholder='Input name...' value="{name}" />
                  </td>
               <?php endif; ?>
               <td colname="value" class="<?= $props['value_classes'] ?>" colspan="<?= $props['value_colspan'] ?>" <?= ($props['value_td_attr'] ? $props['value_td_attr'] : 'data-item-id="{id}" data-item-type="{type}"') ?> >
                  <?php $reg->DB->type[$type_name]::render_value_template(); ?>
               </td>
               <?php if ($props['render_type']) : ?>
                  <td colname='type' colspan=2>{type}</td>
               <?php endif; ?>
               <?php if ($props['render_permission']) : ?>
                  <td colname='permission' class="tac">edit</td>
               <?php endif; ?>
            </tr>

         <?php endif; ?>
      <?php }
   };
}
