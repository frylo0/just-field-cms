<?php $GLOBALS['__jpv_dotWithArrayPrototype'] = function ($base) {
    $arrayPrototype = function ($base, $key) {
        if ($key === 'length') {
            return count($base);
        }
        if ($key === 'forEach') {
            return function ($callback, $userData = null) use (&$base) {
                return array_walk($base, $callback, $userData);
            };
        }
        if ($key === 'map') {
            return function ($callback) use (&$base) {
                return array_map($callback, $base);
            };
        }
        if ($key === 'filter') {
            return function ($callback, $flag = 0) use ($base) {
                return func_num_args() === 1 ? array_filter($base, $callback) : array_filter($base, $callback, $flag);
            };
        }
        if ($key === 'pop') {
            return function () use (&$base) {
                return array_pop($base);
            };
        }
        if ($key === 'shift') {
            return function () use (&$base) {
                return array_shift($base);
            };
        }
        if ($key === 'push') {
            return function ($item) use (&$base) {
                return array_push($base, $item);
            };
        }
        if ($key === 'unshift') {
            return function ($item) use (&$base) {
                return array_unshift($base, $item);
            };
        }
        if ($key === 'indexOf') {
            return function ($item) use (&$base) {
                $search = array_search($item, $base);

                return $search === false ? -1 : $search;
            };
        }
        if ($key === 'slice') {
            return function ($offset, $length = null, $preserveKeys = false) use (&$base) {
                return array_slice($base, $offset, $length, $preserveKeys);
            };
        }
        if ($key === 'splice') {
            return function ($offset, $length = null, $replacements = array()) use (&$base) {
                return array_splice($base, $offset, $length, $replacements);
            };
        }
        if ($key === 'reverse') {
            return function () use (&$base) {
                return array_reverse($base);
            };
        }
        if ($key === 'reduce') {
            return function ($callback, $initial = null) use (&$base) {
                return array_reduce($base, $callback, $initial);
            };
        }
        if ($key === 'join') {
            return function ($glue) use (&$base) {
                return implode($glue, $base);
            };
        }
        if ($key === 'sort') {
            return function ($callback = null) use (&$base) {
                return $callback ? usort($base, $callback) : sort($base);
            };
        }

        return null;
    };

    $getFromArray = function ($base, $key) use ($arrayPrototype) {
        return isset($base[$key])
            ? $base[$key]
            : $arrayPrototype($base, $key);
    };

    $getCallable = function ($base, $key) use ($getFromArray) {
        if (is_callable(array($base, $key))) {
            return new class(array($base, $key)) extends \ArrayObject
            {
                public function getValue()
                {
                    if ($this->isArrayAccessible()) {
                        return $this[0][$this[1]];
                    }

                    return $this[0]->{$this[1]} ?? null;
                }

                public function setValue($value)
                {
                    if ($this->isArrayAccessible()) {
                        $this[0][$this[1]] = $value;

                        return;
                    }

                    $this[0]->{$this[1]} = $value;
                }

                public function getCallable()
                {
                    return $this->getArrayCopy();
                }

                public function __isset($name)
                {
                    $value = $this->getValue();

                    if ((is_array($value) || $value instanceof ArrayAccess) && isset($value[$name])) {
                        return true;
                    }

                    return is_object($value) && isset($value->$name);
                }

                public function __get($name)
                {
                    return new self(array($this->getValue(), $name));
                }

                public function __set($name, $value)
                {
                    $value = $this->getValue();

                    if (is_array($value)) {
                        $value[$name] = $value;
                        $this->setValue($value);

                        return;
                    }

                    $value->$name = $value;
                }

                public function __toString()
                {
                    return (string) $this->getValue();
                }

                public function __toBoolean()
                {
                    $value = $this->getValue();

                    if (method_exists($value, '__toBoolean')) {
                        return $value->__toBoolean();
                    }

                    return !!$value;
                }

                public function __invoke(...$arguments)
                {
                    return call_user_func_array($this->getCallable(), $arguments);
                }

                private function isArrayAccessible()
                {
                    return is_array($this[0]) || $this[0] instanceof ArrayAccess && !isset($this[0]->{$this[1]});
                }
            };
        }
        if ($base instanceof \ArrayAccess) {
            return $getFromArray($base, $key);
        }
    };

    $getRegExp = function ($value) {
        return is_object($value) && isset($value->isRegularExpression) && $value->isRegularExpression ? $value->regExp . $value->flags : null;
    };

    $fallbackDot = function ($base, $key) use ($getCallable, $getRegExp) {
        if (is_string($base)) {
            if (preg_match('/^[-+]?\d+$/', strval($key))) {
                return substr($base, intval($key), 1);
            }
            if ($key === 'length') {
                return strlen($base);
            }
            if ($key === 'substr' || $key === 'slice') {
                return function ($start, $length = null) use ($base) {
                    return func_num_args() === 1 ? substr($base, $start) : substr($base, $start, $length);
                };
            }
            if ($key === 'charAt') {
                return function ($pos) use ($base) {
                    return substr($base, $pos, 1);
                };
            }
            if ($key === 'indexOf') {
                return function ($needle) use ($base) {
                    $pos = strpos($base, $needle);

                    return $pos === false ? -1 : $pos;
                };
            }
            if ($key === 'toUpperCase') {
                return function () use ($base) {
                    return strtoupper($base);
                };
            }
            if ($key === 'toLowerCase') {
                return function () use ($base) {
                    return strtolower($base);
                };
            }
            if ($key === 'match') {
                return function ($search) use ($base, $getRegExp) {
                    $regExp = $getRegExp($search);
                    $search = $regExp ? $regExp : (is_string($search) ? '/' . preg_quote($search, '/') . '/' : strval($search));

                    return preg_match($search, $base);
                };
            }
            if ($key === 'split') {
                return function ($delimiter) use ($base, $getRegExp) {
                    if ($regExp = $getRegExp($delimiter)) {
                        return preg_split($regExp, $base);
                    }

                    return explode($delimiter, $base);
                };
            }
            if ($key === 'replace') {
                return function ($from, $to) use ($base, $getRegExp) {
                    if ($regExp = $getRegExp($from)) {
                        return preg_replace($regExp, $to, $base);
                    }

                    return str_replace($from, $to, $base);
                };
            }
        }

        return $getCallable($base, $key);
    };

    foreach (array_slice(func_get_args(), 1) as $key) {
        $base = is_array($base)
            ? $getFromArray($base, $key)
            : (is_object($base)
                ? (isset($base->$key)
                    ? $base->$key
                    : (method_exists($base, $method = "get" . ucfirst($key))
                        ? $base->$method()
                        : (method_exists($base, $key)
                            ? array($base, $key)
                            : $getCallable($base, $key)
                        )
                    )
                )
                : $fallbackDot($base, $key)
            );
    }

    return $base;
};;
$GLOBALS['__jpv_dotWithArrayPrototype_with_ref'] = function (&$base) {
    $arrayPrototype = function (&$base, $key) {
        if ($key === 'length') {
            return count($base);
        }
        if ($key === 'forEach') {
            return function ($callback, $userData = null) use (&$base) {
                return array_walk($base, $callback, $userData);
            };
        }
        if ($key === 'map') {
            return function ($callback) use (&$base) {
                return array_map($callback, $base);
            };
        }
        if ($key === 'filter') {
            return function ($callback, $flag = 0) use ($base) {
                return func_num_args() === 1 ? array_filter($base, $callback) : array_filter($base, $callback, $flag);
            };
        }
        if ($key === 'pop') {
            return function () use (&$base) {
                return array_pop($base);
            };
        }
        if ($key === 'shift') {
            return function () use (&$base) {
                return array_shift($base);
            };
        }
        if ($key === 'push') {
            return function ($item) use (&$base) {
                return array_push($base, $item);
            };
        }
        if ($key === 'unshift') {
            return function ($item) use (&$base) {
                return array_unshift($base, $item);
            };
        }
        if ($key === 'indexOf') {
            return function ($item) use (&$base) {
                $search = array_search($item, $base);

                return $search === false ? -1 : $search;
            };
        }
        if ($key === 'slice') {
            return function ($offset, $length = null, $preserveKeys = false) use (&$base) {
                return array_slice($base, $offset, $length, $preserveKeys);
            };
        }
        if ($key === 'splice') {
            return function ($offset, $length = null, $replacements = array()) use (&$base) {
                return array_splice($base, $offset, $length, $replacements);
            };
        }
        if ($key === 'reverse') {
            return function () use (&$base) {
                return array_reverse($base);
            };
        }
        if ($key === 'reduce') {
            return function ($callback, $initial = null) use (&$base) {
                return array_reduce($base, $callback, $initial);
            };
        }
        if ($key === 'join') {
            return function ($glue) use (&$base) {
                return implode($glue, $base);
            };
        }
        if ($key === 'sort') {
            return function ($callback = null) use (&$base) {
                return $callback ? usort($base, $callback) : sort($base);
            };
        }

        return null;
    };

    $getFromArray = function (&$base, $key) use ($arrayPrototype) {
        return isset($base[$key])
            ? $base[$key]
            : $arrayPrototype($base, $key);
    };

    $getCallable = function (&$base, $key) use ($getFromArray) {
        if (is_callable(array($base, $key))) {
            return new class(array($base, $key)) extends \ArrayObject
            {
                public function getValue()
                {
                    if ($this->isArrayAccessible()) {
                        return $this[0][$this[1]];
                    }

                    return $this[0]->{$this[1]} ?? null;
                }

                public function setValue($value)
                {
                    if ($this->isArrayAccessible()) {
                        $this[0][$this[1]] = $value;

                        return;
                    }

                    $this[0]->{$this[1]} = $value;
                }

                public function getCallable()
                {
                    return $this->getArrayCopy();
                }

                public function __isset($name)
                {
                    $value = $this->getValue();

                    if ((is_array($value) || $value instanceof ArrayAccess) && isset($value[$name])) {
                        return true;
                    }

                    return is_object($value) && isset($value->$name);
                }

                public function __get($name)
                {
                    return new self(array($this->getValue(), $name));
                }

                public function __set($name, $value)
                {
                    $value = $this->getValue();

                    if (is_array($value)) {
                        $value[$name] = $value;
                        $this->setValue($value);

                        return;
                    }

                    $value->$name = $value;
                }

                public function __toString()
                {
                    return (string) $this->getValue();
                }

                public function __toBoolean()
                {
                    $value = $this->getValue();

                    if (method_exists($value, '__toBoolean')) {
                        return $value->__toBoolean();
                    }

                    return !!$value;
                }

                public function __invoke(...$arguments)
                {
                    return call_user_func_array($this->getCallable(), $arguments);
                }

                private function isArrayAccessible()
                {
                    return is_array($this[0]) || $this[0] instanceof ArrayAccess && !isset($this[0]->{$this[1]});
                }
            };
        }
        if ($base instanceof \ArrayAccess) {
            return $getFromArray($base, $key);
        }
    };

    $getRegExp = function ($value) {
        return is_object($value) && isset($value->isRegularExpression) && $value->isRegularExpression ? $value->regExp . $value->flags : null;
    };

    $fallbackDot = function (&$base, $key) use ($getCallable, $getRegExp) {
        if (is_string($base)) {
            if (preg_match('/^[-+]?\d+$/', strval($key))) {
                return substr($base, intval($key), 1);
            }
            if ($key === 'length') {
                return strlen($base);
            }
            if ($key === 'substr' || $key === 'slice') {
                return function ($start, $length = null) use ($base) {
                    return func_num_args() === 1 ? substr($base, $start) : substr($base, $start, $length);
                };
            }
            if ($key === 'charAt') {
                return function ($pos) use ($base) {
                    return substr($base, $pos, 1);
                };
            }
            if ($key === 'indexOf') {
                return function ($needle) use ($base) {
                    $pos = strpos($base, $needle);

                    return $pos === false ? -1 : $pos;
                };
            }
            if ($key === 'toUpperCase') {
                return function () use ($base) {
                    return strtoupper($base);
                };
            }
            if ($key === 'toLowerCase') {
                return function () use ($base) {
                    return strtolower($base);
                };
            }
            if ($key === 'match') {
                return function ($search) use ($base, $getRegExp) {
                    $regExp = $getRegExp($search);
                    $search = $regExp ? $regExp : (is_string($search) ? '/' . preg_quote($search, '/') . '/' : strval($search));

                    return preg_match($search, $base);
                };
            }
            if ($key === 'split') {
                return function ($delimiter) use ($base, $getRegExp) {
                    if ($regExp = $getRegExp($delimiter)) {
                        return preg_split($regExp, $base);
                    }

                    return explode($delimiter, $base);
                };
            }
            if ($key === 'replace') {
                return function ($from, $to) use ($base, $getRegExp) {
                    if ($regExp = $getRegExp($from)) {
                        return preg_replace($regExp, $to, $base);
                    }

                    return str_replace($from, $to, $base);
                };
            }
        }

        return $getCallable($base, $key);
    };

    $crawler = &$base;
    $result = $base;
    foreach (array_slice(func_get_args(), 1) as $key) {
        $result = is_array($crawler)
            ? $getFromArray($crawler, $key)
            : (is_object($crawler)
                ? (isset($crawler->$key)
                    ? $crawler->$key
                    : (method_exists($crawler, $method = "get" . ucfirst($key))
                        ? $crawler->$method()
                        : (method_exists($crawler, $key)
                            ? array($crawler, $key)
                            : $getCallable($crawler, $key)
                        )
                    )
                )
                : $fallbackDot($crawler, $key)
            );
        $crawler = &$result;
    }

    return $result;
};;
$GLOBALS['__jpv_and'] = function ($base) {
    foreach (array_slice(func_get_args(), 1) as $value) {
        if ($base) {
            $base = $value();
        }
    }

    return $base;
};
$GLOBALS['__jpv_and_with_ref'] = $GLOBALS['__jpv_and'];
$GLOBALS['__jpv_set'] = function ($base, $key, $operator, $value) {
    switch ($operator) {
        case '=':
            if (is_array($base)) {
                $base[$key] = $value;
                break;
            }
            if (method_exists($base, $method = "set" . ucfirst($key))) {
                $base->$method($value);
                break;
            }
            $base->$key = $value;
            break;
        case '+=':
            if (is_array($base)) {
                if ((isset($base[$key]) && is_string($base[$key])) || is_string($value)) {
                    $base[$key] .= $value;
                    break;
                }
                $base[$key] += $value;
                break;
            }
            if ((isset($base->$key) && is_string($base->$key)) || is_string($value)) {
                $base->$key .= $value;
                break;
            }
            $base->$key += $value;
            break;
        case '-=':
            if (is_array($base)) {
                $base[$key] -= $value;
                break;
            }
            $base->$key -= $value;
            break;
        case '*=':
            if (is_array($base)) {
                $base[$key] *= $value;
                break;
            }
            $base->$key *= $value;
            break;
        case '/=':
            if (is_array($base)) {
                $base[$key] /= $value;
                break;
            }
            $base->$key /= $value;
            break;
        case '%=':
            if (is_array($base)) {
                $base[$key] %= $value;
                break;
            }
            $base->$key %= $value;
            break;
        case '|=':
            if (is_array($base)) {
                $base[$key] |= $value;
                break;
            }
            $base->$key |= $value;
            break;
        case '&=':
            if (is_array($base)) {
                $base[$key] &= $value;
                break;
            }
            $base->$key &= $value;
            break;
        case '&&=':
            if (is_array($base)) {
                $base[$key] = $base[$key] ? $value : $base[$key];
                break;
            }
            $base->$key = $base->$key ? $value : $base->$key;
            break;
        case '||=':
            if (is_array($base)) {
                $base[$key] = $base[$key] ? $base[$key] : $value;
                break;
            }
            $base->$key = $base->$key ? $base->$key : $value;
            break;
    }

    return $base;
};
$GLOBALS['__jpv_set_with_ref'] = $GLOBALS['__jpv_set'];
$GLOBALS['__jpv_plus'] = function ($base) {
    foreach (array_slice(func_get_args(), 1) as $value) {
        $base = is_string($base) || is_string($value) ? $base . $value : $base + $value;
    }

    return $base;
};
$GLOBALS['__jpv_plus_with_ref'] = $GLOBALS['__jpv_plus'];
require_once $php . '/JustField.php'; ?>
<?php $db = new JustField\DB($orm, ['assets' => $assets]); ?>

<?php function gen_from_get($prefix) { ?>
<?php    return function (&$variable, $get_key, $is_echo = true) use ($prefix) { ?>
<?php       if (isset($_GET[$get_key])) { ?>
<?php          $variable = $_GET[$get_key]; ?>
<?php       } else if ($is_echo) { ?>
<?php          echo($prefix . ': ' . "no \"$get_key\" in \$_GET" . '<br>'); ?>
<?php       } else { ?>
<?php          $variable = null; ?>
<?php       } ?>
<?php    }; ?>
<?php } ?>

<?php function gen_from_post($prefix) { ?>
<?php    return function (&$variable, $get_key, $is_echo = true) use ($prefix) { ?>
<?php       if (isset($_POST[$get_key])) { ?>
<?php          $variable = $_POST[$get_key]; ?>
<?php       } else if ($is_echo) { ?>
<?php          echo($prefix . ': ' . "no \"$get_key\" in \$_POST" . '<br>'); ?>
<?php       } else { ?>
<?php          $variable = null; ?>
<?php       } ?>
<?php    }; ?>
<?php } ?>

<?php if (method_exists($_pug_temp = isset($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET)['script']), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $script = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'script') ?><?php if (method_exists($_pug_temp = (isset($script) ? $script : null) == 'exit', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php (function_exists('session_start') ? session_start() : $session_start()) ?><?php (function_exists('unset_session_prop') ? unset_session_prop('id') : $unset_session_prop('id')) ?><?php (function_exists('session_destroy') ? session_destroy() : $session_destroy()) ?><?php (function_exists('header') ? header("Location: ./dev.php?page=login") : $header("Location: ./dev.php?page=login")) ?><?php $die ?><?php } elseif (method_exists($_pug_temp = (isset($script) ? $script : null) == 'login', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php if (method_exists($_pug_temp = $GLOBALS['__jpv_and'](isset($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_POST)['login']), function () { return isset($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_POST)['password']); }), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php (function_exists('session_start') ? session_start() : $session_start()) ?><?php $login = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_POST, 'login') ?><?php $password = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_POST, 'password') ?><?php $orm = $GLOBALS['__jpv_set_with_ref']($orm, 'is_log', '=', true) ?><?php $id = $GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($orm, 'from')('account'), 'select')('id_account'), 'where')('account_login = \'' . $login . '\' AND account_password = \'' . $password . '\'')() ?><?php if (method_exists($_pug_temp = (!(isset($id) ? $id : null)), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $_SESSION = $GLOBALS['__jpv_set_with_ref']($_SESSION, 'login_error', '=', 'uncorrect login or password') ?><?php (function_exists('header') ? header('Location: ./dev.php?page=login') : $header('Location: ./dev.php?page=login')) ?><?php } else { ?><?php $id = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($id, 0, 'id_account') ?><?php $_SESSION = $GLOBALS['__jpv_set_with_ref']($_SESSION, 'id', '=', $id) ?><?php (function_exists('unset_session_prop') ? unset_session_prop('login_error') : $unset_session_prop('login_error')) ?><?php (function_exists('header') ? header('Location: ./dev.php?page=main') : $header('Location: ./dev.php?page=main')) ?><?php } ?><?php } else { ?><?php echo('NO POST') ?><?php } ?><?php } elseif (method_exists($_pug_temp = (isset($script) ? $script : null) == 'field-add', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $from_get = (function_exists('gen_from_get') ? gen_from_get('field-add') : $gen_from_get('field-add')) ?><?php (function_exists('from_get') ? from_get($field_type_id, 'type-id') : $from_get($field_type_id, 'type-id')) ?><?php (function_exists('from_get') ? from_get($path, 'path') : $from_get($path, 'path')) ?><?php $db = $GLOBALS['__jpv_set_with_ref']($db, 'orm', '=', $GLOBALS['__jpv_set']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'orm'), 'is_log', '=', false)) ?><?php $new_field_id = $GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'at_path')($path), 'add_field')($field_type_id) ?><?php echo('{ "status": "OK", "id": "' . $new_field_id . '"}') ?><?php } elseif (method_exists($_pug_temp = (isset($script) ? $script : null) == 'field-update', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $from_post = (function_exists('gen_from_post') ? gen_from_post('field-update') : $gen_from_post('field-update')) ?><?php (function_exists('from_post') ? from_post($item_id, 'item_id') : $from_post($item_id, 'item_id')) ?><?php (function_exists('from_post') ? from_post($colname, 'colname') : $from_post($colname, 'colname')) ?><?php (function_exists('from_post') ? from_post($value, 'value', false) : $from_post($value, 'value', false)) ?><?php $db = $GLOBALS['__jpv_set_with_ref']($db, 'orm', '=', $GLOBALS['__jpv_set']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'orm'), 'is_log', '=', false)) ?><?php $res = $GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'at_id')($item_id), 'update')($colname, $value) ?><?php echo($GLOBALS['__jpv_plus']('{ "status": "OK", "data": "', $res, '" }')) ?><?php } elseif (method_exists($_pug_temp = (isset($script) ? $script : null) == 'field-delete', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $from_get = (function_exists('gen_from_get') ? gen_from_get('field-delete') : $gen_from_get('field-delete')) ?><?php (function_exists('from_get') ? from_get($item_id, 'item_id') : $from_get($item_id, 'item_id')) ?><?php $db = $GLOBALS['__jpv_set_with_ref']($db, 'orm', '=', $GLOBALS['__jpv_set']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'orm'), 'is_log', '=', false)) ?><?php $GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'at_id')($item_id), 'remove')() ?><?php echo('{ "status": "OK" }') ?><?php } elseif (method_exists($_pug_temp = (isset($script) ? $script : null) == 'field-duplicate', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $from_get = (function_exists('gen_from_get') ? gen_from_get('field-duplicate') : $gen_from_get('field-duplicate')) ?><?php (function_exists('from_get') ? from_get($item_id, 'item_id') : $from_get($item_id, 'item_id')) ?><?php $db = $GLOBALS['__jpv_set_with_ref']($db, 'orm', '=', $GLOBALS['__jpv_set']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'orm'), 'is_log', '=', false)) ?><?php $new_id = $GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'at_id')($item_id), 'duplicate')() ?><?php echo($GLOBALS['__jpv_plus']('{ "status": "OK", "id": ', $new_id, ' }')) ?><?php } elseif (method_exists($_pug_temp = (isset($script) ? $script : null) == 'info', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php (function_exists('phpinfo') ? phpinfo() : $phpinfo()) ?><?php } ?><?php } else { ?>Error: no or unexpected script in $_GET<?php } ?>