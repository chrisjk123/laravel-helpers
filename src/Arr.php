<?php

namespace Chriscreates\Helpers;

use Illuminate\Support\Arr as BaseArr;

class Arr extends BaseArr
{
    /**
     * Check if an item value is equal to the key in an array
     * using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int|null  $key
     * @param  string|int|null  $value
     * @return bool
     */
    public static function contains(&$array, $key, $value) : bool
    {
        if (is_null(static::get($array, $key))) {
            return false;
        }

        return $value == static::get($array, $key);
    }

    /**
     * Check if any item values are equal to the key in an array
     * using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int|null  $key
     * @param  string|int|array  $value
     * @return bool
     */
    public static function containsAny(&$array, $key, $value) : bool
    {
        foreach (static::wrap($value) as $value) {
            if (static::contains($array, $key, $value)) {
                return true;
            }

            continue;
        }

        return false;
    }

    /**
     * Check if any item values are strictly equal to the key in an array
     * using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int|null  $key
     * @param  string|int|array  $value
     * @return bool
     */
    public static function containsAnyStrict(&$array, $key, $value) : bool
    {
        foreach (static::wrap($value) as $value) {
            if (static::containsStrict($array, $key, $value)) {
                return true;
            }

            continue;
        }

        return false;
    }

    /**
     * Check if an item value is strictly equal to the key in an array
     * using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int|null  $key
     * @param  string|int|null  $value
     * @return bool
     */
    public static function containsStrict(&$array, $key, $value) : bool
    {
        if ( ! static::contains($array, $key, $value)) {
            return false;
        }

        return $value === static::get($array, $key);
    }

    /**
     * Map the given array using a callback.
     *
     * @param  \ArrayAccess|array  $array
     * @param  callable  $callback
     * @return array
     */
    public static function map(&$array, callable $callback) : array
    {
        return array_map($callback, $array);
    }

    /**
     * Replace the given key name with a new key using the "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int|null  $old_key
     * @param  string|int|null  $new_key
     * @return array
     */
    public static function replaceKey(&$array, $old_key, $new_key) : array
    {
        if (is_null(static::get($array, $old_key)) || empty($array)) {
            return $array;
        }

        // Set new key with value
        static::set($array, $new_key, static::get($array, $old_key));

        // Forget old key with value
        static::forget($array, $old_key);

        return $array;
    }

    /**
     * Get the next key within the rotation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  mixed  $key
     * @return array
     */
    public static function nextKey(&$array, $key)
    {
        $keys = array_keys($array);

        $position = array_search($key, $keys);

        if (isset($keys[$position + 1])) {
            $next_key = $keys[$position + 1];
        }

        return $next_key;
    }
}
