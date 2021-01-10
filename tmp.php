<?php
function gen_from_get($prefix)
{
   return function (&$variable, $get_key, $fallback_message) use ($prefix) {
      if (isset($_GET[$get_key])) {
         $variable = $_GET[$get_key];
      } else {
         die($prefix . $fallback_message);
      }
   };
}
