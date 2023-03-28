<?php

namespace common\enums;

abstract class Enum
{
    static function getName($key, $default = "N/A"): string
    {
        $list = static::getList();
        if (!array_key_exists($key, $list))
            return $default;

        return $list[$key];
    }

    static function getNames($values, $glue = ',', $default = 'N/A'): array
    {
        $values = explode($glue, $values);
        $names = [];
        foreach ($values as $value) {
            $names[] = static::getName($value, $default);
        }
        return $names;
    }

    public static function getValues(): array
    {
        return array_keys(static::getList());
    }

    public static function getList() : array
    {
        $class = get_called_class();
        $oClass = new \ReflectionClass($class);
        $constants = $oClass->getConstants();
        return array_combine(array_values($constants), array_keys($constants));
    }

    public static function hasValue($value): bool
    {
        return in_array($value, static::getValues());
    }
}