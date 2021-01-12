
<?php
require_once __DIR__ . './../php/orm.config.php';

$unset_session_prop = function ($prop) { unset($_SESSION[$prop]); };

$global = [];
$link = './field';
$ver = '1.1';
$php = './../php';
$attach = './../Attach';
$assets = './../Assets';
$root = './..';
$mode = 'prod';

?>
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
$GLOBALS['__jpv_plus'] = function ($base) {
    foreach (array_slice(func_get_args(), 1) as $value) {
        $base = is_string($base) || is_string($value) ? $base . $value : $base + $value;
    }

    return $base;
};
$GLOBALS['__jpv_plus_with_ref'] = $GLOBALS['__jpv_plus'];
$GLOBALS['__jpv_or'] = function ($base) {
    foreach (array_slice(func_get_args(), 1) as $value) {
        if (!$base) {
            $base = $value();
        }
    }

    return $base;
};
$GLOBALS['__jpv_or_with_ref'] = function (&$base) {
    foreach (array_slice(func_get_args(), 1) as $value) {
        if (!$base) {
            $base = $value();
        }
    }

    return $base;
};
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
 ?><?php
$pug_vars = [];
foreach (array_keys(get_defined_vars()) as $__pug_key) {
    $pug_vars[$__pug_key] = &$$__pug_key;
}
?><?php $pugModule = [
  'Phug\\Formatter\\Format\\BasicFormat::dependencies_storage' => 'pugModule',
  'Phug\\Formatter\\Format\\BasicFormat::helper_prefix' => 'Phug\\Formatter\\Format\\BasicFormat::',
  'Phug\\Formatter\\Format\\BasicFormat::get_helper' => function ($name) use (&$pugModule) {
    $dependenciesStorage = $pugModule['Phug\\Formatter\\Format\\BasicFormat::dependencies_storage'];
    $prefix = $pugModule['Phug\\Formatter\\Format\\BasicFormat::helper_prefix'];
    $format = $pugModule['Phug\\Formatter\\Format\\BasicFormat::dependencies_storage'];

                            if (!isset($$dependenciesStorage)) {
                                return $format->getHelper($name);
                            }

                            $storage = $$dependenciesStorage;

                            if (!isset($storage[$prefix.$name]) &&
                                !(is_array($storage) && array_key_exists($prefix.$name, $storage))
                            ) {
                                throw new \Exception(
                                    var_export($name, true).
                                    ' dependency not found in the namespace: '.
                                    var_export($prefix, true)
                                );
                            }

                            return $storage[$prefix.$name];
                        },
  'Phug\\Formatter\\Format\\BasicFormat::pattern' => function ($pattern) use (&$pugModule) {

                    $args = func_get_args();
                    $function = 'sprintf';
                    if (is_callable($pattern)) {
                        $function = $pattern;
                        $args = array_slice($args, 1);
                    }

                    return call_user_func_array($function, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::patterns.html_text_escape' => 'htmlspecialchars',
  'Phug\\Formatter\\Format\\BasicFormat::pattern.html_text_escape' => function () use (&$pugModule) {
    $proceed = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::patterns.html_text_escape'];

                    $args = func_get_args();
                    array_unshift($args, $pattern);

                    return call_user_func_array($proceed, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::available_attribute_assignments' => array (
  0 => 'class',
  1 => 'style',
),
  'Phug\\Formatter\\Format\\BasicFormat::patterns.attribute_pattern' => ' %s="%s"',
  'Phug\\Formatter\\Format\\BasicFormat::pattern.attribute_pattern' => function () use (&$pugModule) {
    $proceed = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::patterns.attribute_pattern'];

                    $args = func_get_args();
                    array_unshift($args, $pattern);

                    return call_user_func_array($proceed, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::patterns.boolean_attribute_pattern' => ' %s="%s"',
  'Phug\\Formatter\\Format\\BasicFormat::pattern.boolean_attribute_pattern' => function () use (&$pugModule) {
    $proceed = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::patterns.boolean_attribute_pattern'];

                    $args = func_get_args();
                    array_unshift($args, $pattern);

                    return call_user_func_array($proceed, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::attribute_assignments' => function (&$attributes, $name, $value) use (&$pugModule) {
    $availableAssignments = $pugModule['Phug\\Formatter\\Format\\BasicFormat::available_attribute_assignments'];
    $getHelper = $pugModule['Phug\\Formatter\\Format\\BasicFormat::get_helper'];

                    if (!in_array($name, $availableAssignments)) {
                        return $value;
                    }

                    $helper = $getHelper($name.'_attribute_assignment');

                    return $helper($attributes, $value);
                },
  'Phug\\Formatter\\Format\\BasicFormat::attribute_assignment' => function (&$attributes, $name, $value) use (&$pugModule) {
    $attributeAssignments = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attribute_assignments'];

                    if (isset($name) && $name !== '') {
                        $result = $attributeAssignments($attributes, $name, $value);
                        if (($result !== null && $result !== false && ($result !== '' || $name !== 'class'))) {
                            $attributes[$name] = $result;
                        }
                    }
                },
  'Phug\\Formatter\\Format\\BasicFormat::merge_attributes' => function () use (&$pugModule) {
    $attributeAssignment = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attribute_assignment'];

                    $attributes = [];
                    foreach (array_filter(func_get_args(), 'is_array') as $input) {
                        foreach ($input as $name => $value) {
                            $attributeAssignment($attributes, $name, $value);
                        }
                    }

                    return $attributes;
                },
  'Phug\\Formatter\\Format\\BasicFormat::array_escape' => function ($name, $input) use (&$pugModule) {
    $arrayEscape = $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'];
    $escape = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern.html_text_escape'];

                        if (is_array($input) && in_array(strtolower($name), ['class', 'style'])) {
                            $result = [];
                            foreach ($input as $key => $value) {
                                $result[$escape($key)] = $arrayEscape($name, $value);
                            }

                            return $result;
                        }
                        if (is_array($input) || is_object($input) && !method_exists($input, '__toString')) {
                            return $escape(json_encode($input));
                        }
                        if (is_string($input)) {
                            return $escape($input);
                        }

                        return $input;
                    },
  'Phug\\Formatter\\Format\\BasicFormat::attributes_mapping' => array (
),
  'Phug\\Formatter\\Format\\BasicFormat::attributes_assignment' => function () use (&$pugModule) {
    $attrMapping = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_mapping'];
    $mergeAttr = $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $attr = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern.attribute_pattern'];
    $bool = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern.boolean_attribute_pattern'];

                        $attributes = call_user_func_array($mergeAttr, func_get_args());
                        $code = '';
                        foreach ($attributes as $originalName => $value) {
                            if ($value !== null && $value !== false && ($value !== '' || $originalName !== 'class')) {
                                $name = isset($attrMapping[$originalName])
                                    ? $attrMapping[$originalName]
                                    : $originalName;
                                if ($value === true) {
                                    $code .= $pattern($bool, $name, $name);

                                    continue;
                                }
                                if (is_array($value) || is_object($value) &&
                                    !method_exists($value, '__toString')) {
                                    $value = json_encode($value);
                                }

                                $code .= $pattern($attr, $name, $value);
                            }
                        }

                        return $code;
                    },
  'Phug\\Formatter\\Format\\BasicFormat::class_attribute_assignment' => function (&$attributes, $value) use (&$pugModule) {

            $split = function ($input) {
                return preg_split('/(?<![\[\{\<\=\%])\s+(?![\]\}\>\=\%])/', strval($input));
            };
            $classes = isset($attributes['class']) ? array_filter($split($attributes['class'])) : [];
            foreach ((array) $value as $key => $input) {
                if (!is_string($input) && is_string($key)) {
                    if (!$input) {
                        continue;
                    }

                    $input = $key;
                }
                foreach ($split($input) as $class) {
                    if (!in_array($class, $classes)) {
                        $classes[] = $class;
                    }
                }
            }

            return implode(' ', $classes);
        },
  'Phug\\Formatter\\Format\\BasicFormat::style_attribute_assignment' => function (&$attributes, $value) use (&$pugModule) {

            if (is_string($value) && mb_substr($value, 0, 7) === '{&quot;') {
                $value = json_decode(htmlspecialchars_decode($value));
            }
            $styles = isset($attributes['style']) ? array_filter(explode(';', $attributes['style'])) : [];
            foreach ((array) $value as $propertyName => $propertyValue) {
                if (!is_int($propertyName)) {
                    $propertyValue = $propertyName.':'.$propertyValue;
                }
                $styles[] = $propertyValue;
            }

            return implode(';', $styles);
        },
]; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['button'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'color', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'block';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes']($pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'button'], ['class' => 'tal'], ['class' => 'cup'], ['class' => 'brad0']), (isset($attributes) ? $attributes : null)), [[false, 'button'], [false, (isset($color) ? $color : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php if (method_exists($_pug_temp = (isset($block) ? $block : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php } ?><?php
}); ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['link'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'href', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($href) ? $href : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php if (method_exists($_pug_temp = (isset($block) ? $block : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php } ?></a><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['aside__item'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'name', null], [false, 'href', null], [false, 'current', false]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'block';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes']($pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($href) ? (isset($href) ? $href : null) : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($current) ? (isset($current) ? $current : null) : null) ? 'cud block_disabled' : ''))], ['class' => 'aside__item'], ['class' => 'w100'], ['class' => 'db'], ['class' => 'tdn']), (isset($attributes) ? $attributes : null)), [[false, 'a'], [false, ((isset($current) ? $current : null) ? 'light' : 'dark')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($name) ? $name : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php
}); ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['aside'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    global $glo; ?><?php $username = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'user', 'account_login') ?><aside<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'aside'], ['class' => 'rel'], ['style' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('style', 'width: ' . $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_COOKIE, '-jf_aside-width') . 'px;')])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'aside__content'], ['class' => 'col'], ['class' => 'jcsb'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'col'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'block';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'aside__logo'], ['class' => 'row'], ['class' => 'aic']), [[false, 'div'], [false, 'none']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'logo';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['style' => 'height: 1.75em; width: 1.75em;']), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><strong<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'plo75'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>Just Field CMS</strong><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'block';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'aside__logged-as']), [[false, 'div'], [false, 'none']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><span>Logged as </span><strong<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tdu'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = (isset($username) ? $username : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></strong><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'aside__item';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, 'Dashboard'], [false, './../main'], [false, ($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'page-name') == 'main')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'aside__item';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, 'Fields'], [false, './../field'], [false, ($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'page-name') == 'field')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'aside__item';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, 'Field types'], [false, './../field-type'], [false, ($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'page-name') == 'field-type')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'aside__item';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, 'Accounts'], [false, './../account'], [false, ($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'page-name') == 'account')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'aside__item';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, 'Backup / Migrate'], [false, './../backup'], [false, ($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'page-name') == 'backup')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></div><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'col'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'aside__item';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, 'Exit'], [false, './../scripts/?script=exit']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></div></div><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'aside__resizer'], ['class' => 'abs'], ['class' => 'h100'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div></aside><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['arrow'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'direction', null], [false, 'color', null], [false, 'size', '42'], [false, 'strokeSize', '1']];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'arrow'], ['class' => 'rel'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php $rotate = 0;
$tX = '50%';
$tY = '50%' ?><?php if (method_exists($_pug_temp = ((isset($direction) ? $direction : null) == 'up'), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $rotate = 180 ?><?php } elseif (method_exists($_pug_temp = ((isset($direction) ? $direction : null) == 'left'), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $rotate = 90 ?><?php } elseif (method_exists($_pug_temp = ((isset($direction) ? $direction : null) == 'right'), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $rotate = -90 ?><?php } else { ?><?php $tX = $GLOBALS['__jpv_plus']('-', $tX);
$tY = $GLOBALS['__jpv_plus']('-', $tY) ?><?php } $rotate = $GLOBALS['__jpv_plus']((function_exists('strval') ? strval($rotate) : $strval($rotate)), 'deg') ?><?php $toX = $size / 2;
$toY = $size * 14 / 42 / 2 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'abs'], ['width' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('width', (isset($size) ? $size : null))], ['viewBox' => '0 0 42 14'], ['fill' => 'none'], ['xmlns' => 'http://www.w3.org/2000/svg'], ['style' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('style', 'transform: rotate(' . (isset($rotate) ? $rotate : null) . '); transform-origin: ' . (isset($toX) ? $toX : null) . 'px ' . (isset($toY) ? $toY : null) . 'px;')])
) ? var_export($_pug_temp, true) : $_pug_temp) ?>><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M0.339661 1.05658L19.5 12.2918V12.2918C20.3281 12.7774 21.3532 12.7809 22.1846 12.3009L22.2003 12.2918L41.6603 1.05658'], ['stroke-width' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('stroke-width', (isset($strokeSize) ? $strokeSize : null))], ['stroke' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('stroke', ($GLOBALS['__jpv_or_with_ref']($color, function () { return "#EDA69C"; })))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path></svg></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['die-if-bad'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'php_folder', './']];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    (function_exists('session_start') ? session_start() : $session_start()) ?><?php if (method_exists($_pug_temp = (!isset($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_SESSION)['id'])), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php (function_exists('session_destroy') ? session_destroy() : $session_destroy()) ?><?php (function_exists('header') ? header('Location: ./../login') : $header('Location: ./../login')) ?><?php $die ?><?php };
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['block'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'tag', 'div'], [false, 'mode', 'dark']];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    ?><<?= (is_bool($_pug_temp = (isset($tag) ? $tag : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'block'], ['class' => 'p1'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', 'block_mode_' . (isset($mode) ? $mode : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (method_exists($_pug_temp = (isset($block) ? $block : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php } ?></<?= (is_bool($_pug_temp = (isset($tag) ? $tag : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['logo'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'shadow', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    if (!(isset($shadow) ? $shadow : null)) { ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'logo'], ['viewBox' => '0 0 50 50'], ['fill' => 'none'], ['xmlns' => 'http://www.w3.org/2000/svg'])
) ? var_export($_pug_temp, true) : $_pug_temp) ?>><g<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['clip-path' => 'url(#clip0)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M33.0447 9.87597C33.3487 9.01785 34.2907 8.5686 35.1489 8.87255L48.0542 13.4437L30.4171 63.2376C30.1131 64.0957 29.1711 64.5449 28.3129 64.241L15.4076 59.6698L33.0447 9.87597Z'], ['fill' => '#E6E6E6'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M16.1526 -5.10426C16.4565 -5.96238 17.3986 -6.41162 18.2567 -6.10767L30.696 -1.70163L15.9493 39.9315C15.6454 40.7897 14.7033 41.2389 13.8452 40.935L1.40596 36.5289L16.1526 -5.10426Z'], ['fill' => '#E6E6E6'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['fill-rule' => 'evenodd'], ['clip-rule' => 'evenodd'], ['d' => 'M25 9.67329C18.7414 9.63097 12.8629 13.5104 10.6556 19.7421C8.46611 25.9236 10.5403 32.5803 15.3466 36.5L25 9.67329ZM34.5 13.1146L25 39.9006C31.1824 39.8587 36.9579 35.9961 39.1413 29.8318C41.3233 23.6716 39.2709 17.0396 34.5 13.1146Z'], ['fill' => 'white'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M25.7996 4.68757L13.6919 38.8704L3.04983e-05 38.8704'], ['stroke' => 'black'], ['stroke-width' => '5.49451'], ['stroke-linejoin' => 'round'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M23.392 45.2206L29.4459 28.1292M50 11.0378L35.4997 11.0378L29.4459 28.1292M29.4459 28.1292L39.0763 21.9225'], ['stroke' => 'black'], ['stroke-width' => '5.49451'], ['stroke-linejoin' => 'round'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path></g><defs><clippath<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'clip0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><rect<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['width' => '50'], ['height' => '50'], ['fill' => 'white'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></rect></clippath></defs></svg><?php } else { ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'logo'], ['width' => '222'], ['height' => '245'], ['viewBox' => '0 0 222 245'], ['fill' => 'none'], ['xmlns' => 'http://www.w3.org/2000/svg'])
) ? var_export($_pug_temp, true) : $_pug_temp) ?>><g<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['filter' => 'url(#filter0_d)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M138.352 66.5782C139.386 63.6606 142.589 62.1331 145.506 63.1666L189.385 78.7084L145.36 203L90.0311 203L138.352 66.5782Z'], ['fill' => '#C4C4C4'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M80.228 168.767C79.1946 171.685 75.9917 173.212 73.074 172.179L30.7805 157.198L74.772 33L128.317 33L80.228 168.767Z'], ['fill' => '#C4C4C4'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['fill-rule' => 'evenodd'], ['clip-rule' => 'evenodd'], ['d' => 'M111 65.8891C89.7207 65.7452 69.7341 78.9351 62.2293 100.123C54.7849 121.14 61.8373 143.773 78.1786 157.1L111 65.8891ZM143.3 77.5896L111 168.662C132.02 168.52 151.657 155.387 159.081 134.428C166.499 113.483 159.521 90.9346 143.3 77.5896Z'], ['fill' => 'white'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M113.719 48.9377L72.5525 165.159L26.0001 165.159'], ['stroke' => 'black'], ['stroke-width' => '18.6813'], ['stroke-linejoin' => 'round'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path><path<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['d' => 'M105.533 186.75L126.116 128.639M196 70.5283L146.699 70.5285L126.116 128.639M126.116 128.639L158.859 107.536'], ['stroke' => 'black'], ['stroke-width' => '18.6813'], ['stroke-linejoin' => 'round'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></path></g><defs><filter<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'filter0_d'], ['x' => '0.505342'], ['y' => '0.891874'], ['width' => '220.989'], ['height' => '243.496'], ['filterUnits' => 'userSpaceOnUse'], ['color-interpolation-filters' => 'sRGB'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><feflood<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['flood-opacity' => '0'], ['result' => 'BackgroundImageFix'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></feflood><fecolormatrix<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['in' => 'SourceAlpha'], ['type' => 'matrix'], ['values' => '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></fecolormatrix><feoffset<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['dy' => '4.35897'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></feoffset><fegaussianblur<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['stdDeviation' => '9.80769'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></fegaussianblur><fecolormatrix<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'matrix'], ['values' => '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></fecolormatrix><feblend<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['mode' => 'normal'], ['in2' => 'BackgroundImageFix'], ['result' => 'effect1_dropShadow'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></feblend><feblend<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['mode' => 'normal'], ['in' => 'SourceGraphic'], ['in2' => 'effect1_dropShadow'], ['result' => 'shape'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></feblend></filter></defs></svg><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['favicon'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'root', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    ?><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '57x57'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-57x57.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '60x60'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-60x60.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '72x72'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-72x72.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '76x76'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-76x76.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '114x114'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-114x114.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '120x120'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-120x120.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '144x144'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-144x144.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '152x152'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-152x152.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'apple-touch-icon'], ['sizes' => '180x180'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/apple-icon-180x180.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'icon'], ['type' => 'image/png'], ['sizes' => '192x192'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/android-icon-192x192.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'icon'], ['type' => 'image/png'], ['sizes' => '32x32'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/favicon-32x32.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'icon'], ['type' => 'image/png'], ['sizes' => '96x96'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/favicon-96x96.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'icon'], ['type' => 'image/png'], ['sizes' => '16x16'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/favicon-16x16.png')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'manifest'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($root) ? $root : null) . '/manifest.json')])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><meta<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['name' => 'msapplication-TileColor'], ['content' => '#ffffff'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><meta<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['name' => 'msapplication-TileImage'], ['content' => '/ms-icon-144x144.png'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><meta<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['name' => 'theme-color'], ['content' => '#ffffff'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['get-user-info'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'global', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    global $glo; ?><?php $user_info = $GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype']($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($global, 'orm', 'from')('account'), 'select')('*'), 'where')('id_account = \'' . $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_SESSION, 'id') . '\'')(), 0) ?><?php $global = $GLOBALS['__jpv_set_with_ref']($global, 'user', '=', $user_info) ?><?php $glo = $GLOBALS['__jpv_set_with_ref']($glo, 'user', '=', $user_info);
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['item_T_object'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'child', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    global $glo; ?><?php $path = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path') ?><?php $path_parts = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path_parts') ?><?php $attach = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'attach') ?><?php if (method_exists($_pug_temp = (isset($child) ? $child : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-id', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'id'))], ['data-item-type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-type', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name'))], ['class' => 'item_T_object'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'name'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php $path_i = $GLOBALS['__jpv_plus']((function_exists('count') ? count($path_parts) : $count($path_parts)), 1) ?><?php $loc_path = null ?><?php if (method_exists($_pug_temp = (isset($path) ? $path : null) == '', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $loc_path = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key') ?><?php } else { ?><?php $loc_path = '' . $path . '/' . $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key') ?><?php } ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'link';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'p1'], ['class' => 'db']), [[false, 'Open'], [false, './../field/?view=tree&path=' . (isset($loc_path) ? $loc_path : null) . '&curr_path_i=' . (isset($path_i) ? $path_i : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>edit</td></tr><?php } else { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => '{id}'], ['data-item-type' => '{type}'], ['class' => 'item_T_object'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => '{key}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => '{name}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php $path_i = $GLOBALS['__jpv_plus']((function_exists('count') ? count($path_parts) : $count($path_parts)), 1) ?><?php $loc_path = null ?><?php if (method_exists($_pug_temp = (isset($path) ? $path : null) == '', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $loc_path = '{key}' ?><?php } else { ?><?php $loc_path = '' . $path . '/{key}' ?><?php } ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'link';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'p1'], ['class' => 'db']), [[false, 'Open'], [false, './../field/?view=tree&path=' . (isset($loc_path) ? $loc_path : null) . '&curr_path_i=' . (isset($path_i) ? $path_i : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{type}</td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{permission}</td></tr><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['item_T_field'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'child', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    global $glo; ?><?php $path = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path') ?><?php $path_parts = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path_parts') ?><?php $attach = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'attach') ?><?php if (method_exists($_pug_temp = (isset($child) ? $child : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-id', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'id'))], ['data-item-type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-type', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name'))], ['class' => 'item_T_field'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'name'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input value...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'value'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>edit</td></tr><?php } else { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => '{id}'], ['data-item-type' => '{type}'], ['class' => 'item_T_field'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => '{key}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => '{name}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input value...'], ['value' => '{value}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{type}</td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{permission}</td></tr><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['item_T_list'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'child', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    global $glo; ?><?php $path = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path') ?><?php $path_parts = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path_parts') ?><?php $attach = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'attach') ?><?php if (method_exists($_pug_temp = (isset($child) ? $child : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-id', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'id'))], ['data-item-type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-type', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name'))], ['class' => 'item_T_list'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'name'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php $path_i = $GLOBALS['__jpv_plus']((function_exists('count') ? count($path_parts) : $count($path_parts)), 1) ?><?php $loc_path = null ?><?php if (method_exists($_pug_temp = (isset($path) ? $path : null) == '', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $loc_path = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key') ?><?php } else { ?><?php $loc_path = '' . $path . '/' . $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key') ?><?php } ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'link';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'p1'], ['class' => 'db']), [[false, 'Open'], [false, './../field/?view=tree&path=' . (isset($loc_path) ? $loc_path : null) . '&curr_path_i=' . (isset($path_i) ? $path_i : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '1'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'subtype'], ['colspan' => '1'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'subtype', 'name')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>edit</td></tr><?php } else { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => '{id}'], ['data-item-type' => '{type}'], ['class' => 'item_T_list'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => '{key}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => '{name}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php $path_i = $GLOBALS['__jpv_plus']((function_exists('count') ? count($path_parts) : $count($path_parts)), 1) ?><?php $loc_path = null ?><?php if (method_exists($_pug_temp = (isset($path) ? $path : null) == '', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $loc_path = '{key}' ?><?php } else { ?><?php $loc_path = '' . $path . '/{key}' ?><?php } ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'link';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'p1'], ['class' => 'db']), [[false, 'Open'], [false, './../field/?view=tree&path=' . (isset($loc_path) ? $loc_path : null) . '&curr_path_i=' . (isset($path_i) ? $path_i : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '1'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{type}</td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'subtype'], ['colspan' => '1'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{subtype}</td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{permission}</td></tr><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['item_T_image'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'child', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    global $glo; ?><?php $path = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path') ?><?php $path_parts = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path_parts') ?><?php $attach = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'attach') ?><?php if (method_exists($_pug_temp = (isset($child) ? $child : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-id', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'id'))], ['data-item-type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-type', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name'))], ['class' => 'item_T_image'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'key'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'name'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'row'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'value', 'src'), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'item_T_image__thumbnail'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'value', 'src'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['data-mfp-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-mfp-src', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'value', 'src'))], ['class' => 'item_T_image__show-button']), [[false, 'Show']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'item_T_image__thumbnail'], ['class' => 'item_T_image__thumbnail_free'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => ''], ['class' => 'dn'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['data-mfp-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-mfp-src', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'value'))], ['disabled' => 'disabled'], ['class' => 'item_T_image__show-button']), [[false, 'Show']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'item_T_image__upload-button']), [[false, 'Upload'], [false, 'dark']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><form<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'dn'], ['class' => 'item_T_image__file-form'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'file'], ['name' => 'image'], ['accept' => 'image/*'], ['class' => 'item_T_image__file'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></form></div></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>edit</td></tr><?php } else { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => '{id}'], ['data-item-type' => '{type}'], ['class' => 'item_T_image'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input key...'], ['value' => '{key}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['placeholder' => 'Input name...'], ['value' => '{name}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'], ['class' => 'p0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'row'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'item_T_image__thumbnail'], ['class' => 'item_T_image__thumbnail_free'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => ''], ['class' => 'dn'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['href' => '{value}'], ['disabled' => 'disabled'], ['class' => 'item_T_image__show-button']), [[false, 'Show']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'item_T_image__upload-button']), [[false, 'Upload'], [false, 'dark']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><form<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'dn'], ['class' => 'item_T_image__file-form'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'file'], ['name' => 'image'], ['accept' => 'image/*'], ['class' => 'item_T_image__file'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></form></div></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>{type}</td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>edit</td></tr><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['item_T_space'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'child', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    global $glo; ?><?php $path = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path') ?><?php $path_parts = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'path_parts') ?><?php $attach = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($glo, 'attach') ?><?php if (method_exists($_pug_temp = (isset($child) ? $child : null), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-id', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'id'))], ['data-item-type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-type', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name'))], ['class' => 'item_T_space'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td></tr><?php } else { ?><tr<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['data-item-id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-id', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'id'))], ['data-item-type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-item-type', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name'))], ['class' => 'item_T_space'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'order'], ['class' => 'page_table-order'], ['class' => 'row'], ['class' => 'jcc'], ['class' => 'aic'], ['class' => 'cup'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($attach) ? $attach : null) . '/Images/up-down.svg')], ['draggable' => 'false'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'key'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'name'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'value'], ['class' => 'w100'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colname' => 'type'], ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['colname' => 'permission'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></td></tr><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'die-if-bad';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php $global = array( 'page-name' => 'field', 'orm' => $orm, 'user' => null, 'attach' => $attach ) ?><?php global $glo; ?><?php $glo = $global ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'get-user-info';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($global) ? $global : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php if (!$GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'view')) { ?><?php (function_exists('header') ? header('Location: ./../field/?view=tree') : $header('Location: ./../field/?view=tree')) ?><?php } ?><?php require_once $php . '/JustField.php'; ?>
<?php $db = new JustField\DB($orm, ['assets' => $assets]); ?>

<?php $query_update = function ($key, $value) { if (!isset($_GET[$key])) return; return './?' . str_replace("$key=".$_GET[$key], "$key=$value", $_SERVER['QUERY_STRING']); }; ?>

<!DOCTYPE html><html<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['lang' => 'en'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><head><meta<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['charset' => 'UTF-8'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><meta<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['name' => 'viewport'], ['content' => 'width=device-width, initial-scale=1.0'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><meta<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['http-equiv' => 'X-UA-Compatible'], ['content' => 'ie=edge'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><title>Fields | Just Field</title><link<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['rel' => 'stylesheet'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', '' . (isset($link) ? $link : null) . '.css?ver=' . (isset($ver) ? $ver : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'favicon';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($root) ? $root : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></head><body<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'row'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'aside';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><main<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['style' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('style', 'width: calc(100% - ' . $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_COOKIE, '-jf_aside-width') . 'px);')])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'row'], ['class' => 'page_tabs'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'block';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', ((function_exists('query_update') ? query_update('view', 'tree') : (isset($query_update) ? (isset($query_update) ? $query_update : null) : null)('view', 'tree'))))], ['class' => 'tdn']), [[false, 'a'], [false, ($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'view') == 'tree' ? 'light' : 'dark')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?>Tree View<?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'block';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', ((function_exists('query_update') ? query_update('view', 'type') : (isset($query_update) ? (isset($query_update) ? $query_update : null) : null)('view', 'type'))))], ['class' => 'tdn']), [[false, 'a'], [false, ($GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'view') == 'type' ? 'light' : 'dark')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?>Type View<?php
}); ?></div><?php if (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'view') == 'tree', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'page_path'], ['class' => 'row'], ['class' => 'aic'], ['class' => 'w100'], ['class' => 'pl1'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php $full_path = ((function_exists('array_key_exists') ? array_key_exists('path', $_GET) : $array_key_exists('path', $_GET)) ? $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'path') : '') ?><?php $curr_path_i = 0 ?><?php if (method_exists($_pug_temp = (function_exists('array_key_exists') ? array_key_exists('curr_path_i', (isset($_GET) ? $_GET : null)) : (isset($array_key_exists) ? $array_key_exists : null)('curr_path_i', (isset($_GET) ? $_GET : null))), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $curr_path_i = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'curr_path_i') ?><?php } $curr_path_i = (function_exists('intval') ? intval($curr_path_i) : $intval($curr_path_i)) ?><?php $parts = (function_exists('explode') ? explode('/', $full_path) : $explode('/', $full_path)) ?><?php $path_parts = array(  ) ?><?php for ($i = 0; $i < $curr_path_i; $i++) { ?><?php (function_exists('array_push') ? array_push($path_parts, $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($parts, $i)) : $array_push($path_parts, $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($parts, $i))) ?><?php } $path = (function_exists('implode') ? implode('/', $path_parts) : $implode('/', $path_parts)) ?><?php $glo = $GLOBALS['__jpv_set_with_ref']($glo, 'path', '=', $path) ?><?php $glo = $GLOBALS['__jpv_set_with_ref']($glo, 'path_parts', '=', $path_parts) ?><script>var state = {};</script><script><?= htmlspecialchars((is_bool($_pug_temp = 'state.path = \'' . (isset($path) ? $path : null) . '\';') ? var_export($_pug_temp, true) : $_pug_temp)) ?></script><?php if (method_exists($_pug_temp = (isset($curr_path_i) ? $curr_path_i : null) - 1 < (function_exists('count') ? count((isset($parts) ? $parts : null)) : (isset($count) ? $count : null)((isset($parts) ? $parts : null))), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><script><?= htmlspecialchars((is_bool($_pug_temp = 'state.pathNext = \'' . $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($parts, (isset($curr_path_i) ? $curr_path_i : null)) . '\';') ? var_export($_pug_temp, true) : $_pug_temp)) ?></script><?php } else { ?><script><?= htmlspecialchars((is_bool($_pug_temp = 'state.pathNext = \'\';') ? var_export($_pug_temp, true) : $_pug_temp)) ?></script><?php } if (method_exists($_pug_temp = (function_exists('count') ? count((isset($parts) ? $parts : null)) : (isset($count) ? $count : null)((isset($parts) ? $parts : null))) == $GLOBALS['__jpv_and'](1, function () use (&$parts) { return $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($parts, 0) == ''; }), "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $parts = array(  ) ?><?php } (function_exists('array_unshift') ? array_unshift($parts, '/') : $array_unshift($parts, '/')) ?><?php $i = 0 ?><?php $__eachScopeVariables = ['part' => isset($part) ? $part : null];foreach ($parts as $part) { ?><?php $is_curr = ($i == $curr_path_i) ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', ((function_exists('query_update') ? query_update('curr_path_i', (isset($i) ? $i : null)) : (isset($query_update) ? $query_update : null)('curr_path_i', (isset($i) ? $i : null)))))], ['class' => 'page_path__part'], ['class' => 'tdn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($is_curr) ? $is_curr : null) ? 'page_path__part_curr' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= htmlspecialchars((is_bool($_pug_temp = (isset($part) ? $part : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></a><?php $i++ ?><?php }extract($__eachScopeVariables); ?></div><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'page_content'], ['class' => 'ova'], ['class' => 'w100'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><template<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'template_T_field'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_field';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></template><template<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'template_T_object'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_object';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></template><template<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'template_T_list'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_list';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></template><template<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'template_T_image'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_image';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></template><template<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'template_T_space'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_space';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></template><?php $is_data = true ?><table<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-update-link' => './../scripts/?script=field-update'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><thead><tr><td>Order</td><td>Key</td><td>Name</td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'w100'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>Value</td><td<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['colspan' => '2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>Type</td><td>Permission</td></tr></thead><tbody><?php $children = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($db, 'at_path')($path) ?><?php $children = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($children, 'get_children')() ?><?php if (method_exists($_pug_temp = (isset($children) ? $children : null) == null, "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php $is_data = false ?><?php } else { ?><?php $__eachScopeVariables = ['child' => isset($child) ? $child : null];foreach ($children as $child) { ?><?php if (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name') == 'field', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_field';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($child) ? $child : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } elseif (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name') == 'image', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_image';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($child) ? $child : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } elseif (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name') == 'object', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_object';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($child) ? $child : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } elseif (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name') == 'list', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_list';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($child) ? $child : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } elseif (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($child, 'type', 'name') == 'space', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'item_T_space';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($child) ? $child : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } ?><?php }extract($__eachScopeVariables); ?><?php } ?></tbody></table><h2<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tac'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($is_data) ? $is_data : null) ? 'dn' : ''))], ['id' => 'title_no-data'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>No data</h2></div><?php } elseif (method_exists($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($_GET, 'view') == 'type', "__toBoolean")
        ? $_pug_temp->__toBoolean()
        : $_pug_temp) { ?>type<?php } ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'page_foot-panel'], ['class' => 'w100'], ['class' => 'row'], ['class' => 'jcsb'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'row'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'page_button-add'], ['class' => 'rel'], ['data-add-link' => './../scripts/?script=field-add']), [[false, 'Add'], [false, 'dark']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'page_button-add__content'], ['class' => 'abs'], ['class' => 'col'], ['class' => 'top0'], ['class' => 'left0'], ['class' => 'dn'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php $types = $GLOBALS['orm']->table('type')->select('*')(); ?><?php $__eachScopeVariables = ['curr_type' => isset($curr_type) ? $curr_type : null];foreach ($types as $curr_type) { ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'block';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'page_button-add__type'], ['data-id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-id', $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($curr_type, 'id_type'))]), [[false, 'div'], [false, 'dark']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?= htmlspecialchars((is_bool($_pug_temp = $GLOBALS['__jpv_dotWithArrayPrototype_with_ref']($curr_type, 'type_name')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php
}); ?><?php }extract($__eachScopeVariables); ?></div><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'page_button-delete'], ['data-delete-link' => './../scripts/?script=field-delete']), [[false, 'Delete'], [false, 'dark']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['style' => 'color: #6CF6FF88'], ['class' => 'dn'], ['id' => 'button-delete-count'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>> (<span>0</span>)</span><?php
}); ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'button';
isset($__pug_mixins[$__pug_mixin_name]) && 
$__pug_mixins[$__pug_mixin_name](true, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['class' => 'page_button-duplicate'], ['data-duplicate-link' => './../scripts/?script=field-duplicate']), [[false, 'Duplicate'], [false, 'dark']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['style' => 'color: #6CF6FF88'], ['class' => 'dn'], ['id' => 'button-duplicate-count'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>> (<span>0</span>)</span><?php
}); ?></div><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'row'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['id' => 'statusbar'], ['class' => 'p1'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>>Ready</div></div></div></main><script<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', '' . (isset($link) ? $link : null) . '.bundle.js?ver=' . (isset($ver) ? $ver : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></script></body></html>