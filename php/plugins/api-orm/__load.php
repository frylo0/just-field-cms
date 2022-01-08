<?php
$orm_mysqli = null;

function orm_mysqli_init($host, $user, $pass, $db_name) {
   global $orm_mysqli;
   $orm_mysqli =  new mysqli($host, $user, $pass, $db_name);

   if ($orm_mysqli->connect_error) {
      die('ORM mysqli connection error (' . $orm_mysqli->connect_errno . ') '
         . $orm_mysqli->connect_error);
   }
}
class ORM {
   var $db;

   var $is_log = false;
   var $is_simulate = false;
   var $last_operation = null;
   var $last_operation_args = null;

   var $table_prefix = '';
   var $conditions;
   var $selector;
   var $table_name;
   var $table_name_raw;

   function __construct($host = null, $user = null, $pass = null, $db_name = null)
   {
      global $orm_mysqli;

      if ($host !== null) {
         orm_mysqli_init($host, $user, $pass, $db_name);
      }

      $this->db = $orm_mysqli;
      $this->conditions = '';
   }

   // CONFIG
   function __clone() {
      $new_orm = new ORM();

      $new_orm->is_log = $this->is_log;

      $new_orm->table_prefix = $this->table_prefix;
      $new_orm->conditions = $this->conditions;
      $new_orm->selector = $this->selector;
      $new_orm->table_name = $this->table_name;
      $new_orm->table_name_raw = $this->table_name_raw;
      $new_orm->is_simulate = $this->is_simulate;

      return $new_orm;
   }

   function from($table) {
      $this->conditions = '';
      $this->table_name_raw = $table;
      $this->table_name = $this->table_prefix . $table;
      return $this;
   }
   function table($table)
   {
      return $this->from($table);
   }

   function where($conditions) {
      $this->conditions = $conditions;
      return $this;
   }
   function where_id($id)
   {
      $this->conditions = "`id_{$this->table_name_raw}` = '$id'";
      return $this;
   }

   function close() {
      $this->db->close();
   }


   // QUERY TO DB
   function __invoke($fetch_type = MYSQLI_ASSOC)
   {
      $where_str = $this->gen_conditions_string();
      $sql = '';
      $assoc = $this->last_operation_args;

      switch ($this->last_operation) {
         case 'select':
            $sql = "SELECT {$this->selector} FROM `{$this->table_name}` WHERE {$where_str};";
            break;

         case 'update':
            $query_str = '';

            foreach ($assoc as $key => $val) {
               $val = $this->get_val($val);
               $query_str .= "`$key` = $val, ";
            }
            $query_str = mb_substr($query_str, 0, mb_strlen($query_str) - 2);

            $sql = "UPDATE `{$this->table_name}` SET {$query_str} WHERE {$where_str};";
            break;

         case 'insert':
            $keys = array_keys($assoc);
            $vals = array_values($assoc);

            $keys_str = '`' . implode('`, `', $keys) . '`';
            $vals_str = '';
            foreach ($vals as $val) {
               $val = $this->get_val($val);
               $vals_str .= "$val, ";
            }
            $vals_str = mb_substr($vals_str, 0, mb_strlen($vals_str) - 2);

            $sql = "INSERT INTO `{$this->table_name}` ({$keys_str}) VALUES ({$vals_str});";
            break;

         case 'delete':
            $sql = "DELETE FROM `{$this->table_name}` WHERE {$where_str};";
            break;

         default;
      };

      if (!$this->is_simulate)
         return $this->query($sql, $fetch_type);
      else
         $this->console_log($sql);
      return $sql;
   }

   function take($fetch_type = MYSQLI_ASSOC) {
      return $this->__invoke($fetch_type);
   }


   // Operations
   function select($selector)
   {
      $this->last_operation = 'select';
      $this->selector = $selector;
      return $this;
   }
   function update($assoc)
   {
      $this->last_operation = 'update';
      $this->last_operation_args = $assoc;
      return $this;
   }
   function insert($assoc)
   {
      $this->last_operation = 'insert';
      $this->last_operation_args = $assoc;
      return $this;
   }
   function delete()
   {
      $this->last_operation = 'delete';
      return $this;
   }


   // Private
   private function query($sql, $fetch_type = null)
   {
      $this->conditions = '';
      $this->last_operation = '';
      $this->last_operation_args = [];

      if ($this->is_log)
         $this->console_log('[ ORM SQL: (fetch_type: ' . $fetch_type.') ]\n' . $sql);
      $res = $this->db->query($sql);
      if ($fetch_type && !is_bool($res))
         return $res->fetch_all($fetch_type);
      else
         return $res;
   }

   private function gen_conditions_string()
   {
      return $this->conditions ? $this->conditions : '1';
   }

   private function console_log($message)
   {
      if ($this->is_log) {
         $message = str_replace('`', '\`', $message);
         echo "<script>console.log(`$message`);</script>";
      }
   }

   private function get_val($val) {
      if (is_string($val)) {
         $val = $this->db->escape_string($val);
         return "'$val'";
      } else {
         if ($val === null) return 'NULL';
         return $val;
      }
   }
}

require_once __DIR__ . '/../../db-connect-info.php';
$orm = new ORM(
   'localhost', 
   jf_DB_LOGIN, 
   jf_DB_PASSWORD, 
   jf_DB_DBNAME
);
$orm->table_prefix = jf_DB_TABLE_PREFIX;
$orm->is_log = jf_DB_IS_LOG;