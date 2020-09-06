<?php

namespace Chriscreates\Helpers\Tests;

use Chriscreates\Helpers\Str;
use Orchestra\Testbench\TestCase;

class StringTest extends TestCase
{
    private $string;

    public function setUp(): void
    {
        parent::setUp();

        $this->string = 'This is a Test';
    }

    /** @test */
    public function is_string_transformable_to_ant_case()
    {
        $helper = Str::ant($this->string);

        $this->assertSame('this.is.a.test', $helper);

        $this->assertFalse($this->string === $helper);

        $this->assertStringContainsString('.', $helper);

        $this->assertSame(14, Str::length($helper));

        $this->assertTrue(14 === Str::length($helper));
    }

    /** @test */
    public function is_string_transformable_to_train_case()
    {
        $helper = Str::train($this->string);

        $this->assertSame('This-Is-A-Test', $helper);

        $this->assertFalse($this->string === $helper);

        $this->assertStringContainsString('-', $helper);

        $this->assertSame(14, Str::length($helper));

        $this->assertTrue(14 === Str::length($helper));
    }

    /** @test */
    public function is_string_transformable_to_unicase_case()
    {
        $helper = Str::unicase($this->string);

        $this->assertSame('this-is-a-test', $helper);

        $this->assertFalse($this->string === $helper);

        $this->assertStringContainsString('-', $helper);

        $this->assertSame(14, Str::length($helper));

        $this->assertTrue(14 === Str::length($helper));
    }

    /** @test */
    public function is_string_transformable_to_append_another_case()
    {
        $string = Str::ant($this->string);

        $helper = Str::appendCase($string, 'With Extra Content', 'ant');

        $this->assertSame('this.is.a.test.with.extra.content', $helper);

        $this->assertFalse($this->string === $helper);

        $this->assertStringContainsString('.', $helper);

        $this->assertSame(33, Str::length($helper));

        $this->assertTrue(33 === Str::length($helper));
    }

    /** @test */
    public function is_string_between()
    {
        $string = "I think this between helper method is great. Wouldn't you agree?";

        $helper = Str::betweenIncluding($string, 'this', 'great');

        $this->assertSame('this between helper method is great', $helper);

        $this->assertFalse($string === $helper);

        $this->assertStringContainsString('between', $helper);

        $this->assertSame(35, Str::length($helper));

        $this->assertTrue(35 === Str::length($helper));
    }

    /** @test */
    public function is_all_string_instances_removed()
    {
        $string = 'This is amazing, cool and fun to use. This is amazing, cool and fun to use.';

        $helper = Str::removeIncluding($string, ', cool', 'use');

        $this->assertSame('This is amazing. This is amazing.', $helper);

        $this->assertFalse($string === $helper);

        $this->assertStringContainsString('This is amazing', $helper);

        $this->assertSame(33, Str::length($helper));

        $this->assertTrue(33 === Str::length($helper));
    }

    /** @test */
    public function can_limit_the_amount_of_words()
    {
        $string = "I think you'll find this rather helpful and that it works really well.";

        $helper = Str::limitWords($string, 7, '...');

        $this->assertSame("I think you'll find this rather helpful...", $helper);
    }
}
