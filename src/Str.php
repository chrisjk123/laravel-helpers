<?php

namespace Chriscreates\Helpers;

use BadMethodCallException;
use Illuminate\Support\Str as BaseStr;

class Str extends BaseStr
{
    /**
     * @var array
     */
    protected static $cases_delimiters = [
        'camel' => '',
        'kebab' => '-',
        'lower' => '',
        'snake' => '_',
        'studly' => '',
        'title' => ' ',
        'upper' => '',
        'ant' => '.',
        'unicase' => '',
    ];

    /**
     * Convert a value to an ant-like case.
     *
     * @param  string                  $string
     * @return string
     */
    public static function ant(string $string) : string
    {
        $string = preg_replace('/[^a-zA-Z0-9]+/', ' ', $string);

        $string = str_replace(' ', '.', $string);

        $string = trim($string, '.');

        return static::length($string) !== 0 ? static::lower($string) : '';
    }

    /**
     * Convert a value to train case.
     *
     * @param  string                  $string
     * @return string
     */
    public static function train(string $string) : string
    {
        return static::title(static::kebab($string));
    }

    /**
     * Append one case to another, default $delimiter is 'ant'.
     *
     * @param  string                  $string
     * @param  string                  $append
     * @return string
     */
    public static function appendCase(string $string, string $append, string $case = 'ant') : string
    {
        $case = static::lower($case);

        if ( ! method_exists(__CLASS__, $case)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.',
                __CLASS__,
                $case
            ));
        }

        $append = static::$case($append);

        $delimiter = static::$cases_delimiters[$case];

        return static::finish(static::finish($string, $delimiter), $append);
    }

    /**
     * Everything lower case with no spaces.
     *
     * @param  string                  $string
     * @return string
     */
    public static function unicase(string $string) : string
    {
        return static::lower(static::kebab($string));
    }

    /**
     * Retrieve first instance of string in between $start and $end parameters.
     *
     * @param  string                  $string
     * @param  string                  $start
     * @param  string                  $end
     * @return string
     */
    public static function betweenIncluding(string $string, string $start, string $end) : string
    {
        if ($start === '' && $end === '') {
            return '';
        }

        $sub = substr($string, strpos($string, $start) + strlen($start), strlen($string));

        $between = substr($sub, 0, strpos($sub, $end));

        // Return the substring from the index $substring_start of length size.
        return $start.$between.$end;
    }

    /**
     * Remove all occurances of string containing in between and including $start
     * and $end parameters.
     *
     * @param  string                  $string
     * @param  string                  $start
     * @param  string                  $end
     * @return string
     */
    public static function removeIncluding(string $string, string $start, string $end) : string
    {
        // Between and including starting string and ending string.
        $between = static::betweenIncluding($string, $start, $end);

        // Replace all occurances if exists.
        $string = str_replace($between, '', $string);

        return $string;
    }

    /**
     * Get a new stringable object from the given string.
     *
     * @param  string  $string
     * @return \Chriscreates\Projects\Helpers\Stringable
     */
    public static function of($string)
    {
        return new Stringable($string);
    }
}
