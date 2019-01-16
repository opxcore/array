<?php

namespace OpxCore\Arr;

class Arr
{
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
     * @param  array|null $array
     * @param  string $key
     * @param  mixed $value
     *
     * @return  array
     */
    public static function set(&$array, $key, $value): array
    {
        if ($array === null) {
            $array = [];
        } elseif (!is_array($array)) {
            throw new \InvalidArgumentException(sprintf('Array expected, got %s', gettype($array)));
        }

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
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  array $array
     * @param  string|array $keys
     *
     * @return  bool
     */
    public static function has($array, $keys): bool
    {
        if (!is_array($array) || $keys === null || $keys === '' || $keys === []) {
            return false;
        }

        $keys = (array)$keys;

        foreach ($keys as $keyToSearch) {
            $link = &$array;

            foreach (explode('.', $keyToSearch) as $iterationKey) {
                if (isset($link[$iterationKey]) || array_key_exists($iterationKey, $link)) {
                    $link = &$link[$iterationKey];
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param  array $array
     * @param  array|string $keys
     *
     * @return  array
     */
    public static function only(array $array, $keys): array
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }

    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param  array $array
     * @param  \Closure|null $callback
     * @param  \Closure|mixed $default
     *
     * @return  mixed
     */
    public static function last($array, \Closure $callback = null, $default = null)
    {
        if ($array === null || $array === []) {
            return static::value($default);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    }

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
     * Return the first element in an array passing a given truth test.
     *
     * @param  array $array
     * @param  \Closure|null $callback
     * @param  \Closure|mixed $default
     *
     * @return  mixed
     */
    public static function first($array, \Closure $callback = null, $default = null)
    {
        if ($array === null || $array === []) {
            return static::value($default);
        }

        if ($callback === null) {
            return reset($array);
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return static::value($default);
    }

    /**
     * Get a value from the array, and remove it.
     *
     * @param  array $array
     * @param  string $key
     * @param  \Closure|mixed $default
     *
     * @return  mixed
     */
    public static function pull(&$array, $key, $default = null)
    {
        $value = static::get($array, $key, $default);

        static::forget($array, $key);

        return $value;
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

        if ($key === null || $key === '' | !is_string($key)) {
            return static::value($default);
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
     * Remove one or many items from the array using dot notation.
     *
     * @param  array $array
     * @param  array|string $keys
     *
     * @return  array
     */
    public static function forget(&$array, $keys): array
    {
        if ($keys === null || $keys === '' || $keys === []) {
            return $array;
        }

        $keys = (array)$keys;

        foreach ($keys as $keyToSearch) {
            $link = &$array;

            $keysToSearch = explode('.', $keyToSearch);

            $lastKey = end($keysToSearch);

            foreach ($keysToSearch as $iterationKey) {
                if ($iterationKey === $lastKey) {
                    unset($link[$lastKey]);
                } elseif (isset($link[$iterationKey]) || array_key_exists($iterationKey, $link)) {
                    $link = &$link[$iterationKey];
                } else {
                    continue 2;
                }
            }
        }

        return $array;
    }
}
