<?php
/*
 * This file is part of the OpxCore.
 *
 * Copyright (c) Lozovoy Vyacheslav <opxcore@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpxCore\Arr;

use ArrayAccess;
use InvalidArgumentException;

class Arr
{
    /**
     * Make dot notation for multi-dimensional associative array.
     *
     * @param array $array
     *
     * @return  array
     */
    public static function dot(array $array): ?array
    {
        return static::makeDotArray($array, '');
    }

    /**
     * Dot notation for multi-dimensional array recursion.
     *
     * @param array $array
     * @param string $prepend
     *
     * @return  array
     */
    protected static function makeDotArray(array $array, string $prepend): array
    {
        $results = [[]];

        foreach ($array as $key => $value) {
            // If one of keys is numeric we have an unassociated array and we do not
            // need to iterate it. Just return this array as result for given key.
            if (is_numeric($key)) {
                return [rtrim($prepend, '.') => $array];
            }

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
     * @param array|null $array
     * @param string $key
     * @param mixed $value
     *
     * @return  array
     */
    public static function set(?array &$array, string $key, $value): array
    {
        if ($array === null) {
            $array = [];
        }

        if (!is_string($key) || $key === '') {
            throw new InvalidArgumentException('Given key is empty or not a string.');
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
     * @param array $array
     * @param string|array $keys
     *
     * @return  bool
     */
    public static function has(array $array, $keys): bool
    {
        if (!is_array($array) || $keys === null || $keys === '' || $keys === []) {
            return false;
        }

        $keys = (array)$keys;

        foreach ($keys as $keyToSearch) {

            $link = &$array;

            $keyStack = explode('.', $keyToSearch);

            $lastKey = end($keyStack);

            foreach ($keyStack as $iterationKey) {
                if (isset($link[$iterationKey]) || array_key_exists($iterationKey, $link)) {
                    $link = &$link[$iterationKey];
                    if (!is_array($link) && ($iterationKey !== $lastKey)) {
                        return false;
                    }
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
     * @param array $array
     * @param array|string $keys
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
     * @param array $array
     * @param callable|null $callback
     * @param callable|mixed $default
     *
     * @return  mixed
     */
    public static function last(array $array, callable $callback = null, $default = null)
    {
        if ($array === null || $array === []) {
            return static::value($default);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    }

    /**
     * Returns value or result of closure.
     *
     * @param mixed $value
     *
     * @return  mixed
     */
    protected static function value($value)
    {
        if (is_callable($value)) {
            $evaluated = $value();
        } else {
            $evaluated = $value;
        }

        return $evaluated;
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param array $array
     * @param callable|null $callback
     * @param callable|mixed $default
     *
     * @return  mixed
     */
    public static function first(array $array, callable $callback = null, $default = null)
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
     * @param array $array
     * @param string $key
     * @param callable|mixed $default
     *
     * @return  mixed
     */
    public static function pull(array &$array, string $key, $default = null)
    {
        $value = static::get($array, $key, $default);

        static::forget($array, $key);

        return $value;
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param ArrayAccess|array $array
     * @param string|null $key
     * @param callable|mixed $default
     *
     * @return  mixed
     */
    public static function get($array, ?string $key, $default = null)
    {
        if (!is_array($array)) {
            return static::value($default);
        }

        if ($key === null || $key === '' | !is_string($key)) {
            return static::value($default);
        }

        $link = &$array;

        $keyStack = explode('.', $key);

        $lastKey = end($keyStack);

        foreach ($keyStack as $iterationKey) {
            if (isset($link[$iterationKey]) || array_key_exists($iterationKey, $link)) {
                $link = &$link[$iterationKey];
                if (!is_array($link) && ($iterationKey !== $lastKey)) {
                    return static::value($default);
                }
            } else {
                return static::value($default);
            }
        }

        return $link;
    }

    /**
     * Remove one or many items from the array using dot notation.
     *
     * @param array $array
     * @param array|string $keys
     *
     * @return  array
     */
    public static function forget(array &$array, $keys): array
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
                    if (!is_array($link) && ($iterationKey !== $lastKey)) {
                        continue 2;
                    }
                }
            }
        }

        return $array;
    }

    /**
     * Push value into the array.
     *
     * @param array $array
     * @param string $key
     * @param mixed $value
     *
     * @return  array
     */
    public static function push(array &$array, string $key, $value): array
    {
        $arr = (array)static::get($array, $key, []);

        $arr[] = $value;

        return static::set($array, $key, $arr);
    }
}
