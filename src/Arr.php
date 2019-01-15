<?php

namespace OpxCore\Arr;

class Arr
{
    /**
     * Returns value or result of closure.
     *
     * @param  mixed|\Closure $value
     *
     * @return  mixed
     */
    protected static function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }

     /**
     * Make dot notation for multi-dimensional associative array.
     *
     * @param  array $array
     *
     * @return  array
     */
    public static function dot($array): ?array
    {
        if (!is_array($array)) {
            return null;
        }

        return static::makeDotArray($array, '');
    }

    /**
     * Dot notation for multi-dimensional array recursion.
     *
     * @param  array $array
     * @param  string $prepend
     *
     * @return  array
     */
    protected static function makeDotArray($array, $prepend): array
    {
        $results = [[]];

        foreach ($array as $key => $value) {
            if (!empty($value) && is_array($value)) {
                $results[] = static::makeDotArray($value, $prepend . $key . '.');
            } else {
                $results[][$prepend . $key] = $value;
            }
        }

        return array_merge(...$results);
    }

    /**
     * Set a value to array using dot notation.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $value
     *
     * @return  array
     */
    public static function set(&$array, $key, $value): array
    {
        if (!is_string($key) || $key === '') {
            throw new \InvalidArgumentException('Given key is empty or not a string.');
        }

        $link = &$array;

        foreach (explode('.', $key) as $iterationKey) {
            if (!isset($link[$iterationKey]) || !is_array($link[$iterationKey])) {
                $link[$iterationKey] = [];
            }
            $link = &$link[$iterationKey];
        }

        $link = $value;

        return $array;
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array $array
     * @param  string $key
     * @param  \Closure|mixed $default
     *
     * @return  mixed
     */
    public static function get($array, $key, $default = null)
    {
        if (!is_array($array)) {
            return static::value($default);
        }

        if ($key === null) {
            return $array;
        }

        $link = &$array;

        foreach (explode('.', $key) as $iterationKey) {
            if (isset($link[$iterationKey]) || array_key_exists($iterationKey, $link)) {
                $link = &$link[$iterationKey];
            } else {
                return static::value($default);
            }
        }

        return $link;
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param  array $array
     * @param  array|string $keys
     *
     * @return  array
     */
    public static function only($array, $keys): array
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }
}
