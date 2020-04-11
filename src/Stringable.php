<?php

namespace Chriscreates\Helpers;

use Illuminate\Support\Stringable as BaseStringableSupport;

class Stringable extends BaseStringableSupport
{
    /**
     * Convert a string to ant-like case.
     *
     * @return static
     */
    public function ant()
    {
        return new static(Str::ant($this->value));
    }

    /**
     * Convert a string to train case.
     *
     * @return static
     */
    public function train()
    {
        return new static(Str::train($this->value));
    }

    /**
     * Convert a string to unicase case.
     *
     * @return static
     */
    public function unicase()
    {
        return new static(Str::unicase($this->value));
    }

    /**
     * @return static
     */
    public function betweenIncluding($start, $end)
    {
        return new static(Str::betweenIncluding($this->value, $start, $end));
    }

    /**
     * @return static
     */
    public function removeIncluding($start, $end)
    {
        return new static(Str::removeIncluding($this->value, $start, $end));
    }
}
