<?php

namespace Chriscreates\Helpers\Tests;

use Chriscreates\Helpers\Arr;
use Orchestra\Testbench\TestCase;

class ArrTest extends TestCase
{
    private $string;

    public function setUp(): void
    {
        parent::setUp();

        $this->array = ['product1' => ['name' => 'Desk', 'price' => ['first' => 100]], 'product2' => ['test' => 'Desk', 'price' => 400]];
    }

    /** @test */
    public function is_array_queryable_to_contain_key_by_value()
    {
        $helper = Arr::contains($this->array, 'product1.price.first', 100);

        $this->assertTrue($helper);

        $this->assertNotSame($this->array, $helper);
    }

    /** @test */
    public function is_array_queryable_to_contain_any_key_by_value()
    {
        $helper = Arr::containsAny($this->array, 'product1.price.first', 100);

        $this->assertTrue($helper);

        $helper = Arr::containsAny($this->array, 'product1.price.first', [250, 200, 100, 150]);

        $this->assertTrue($helper);

        $helper = Arr::containsAny($this->array, 'product1.price.first', [250, 200, 600, 150]);

        $this->assertFalse($helper);

        $this->assertNotSame($this->array, $helper);
    }

    /** @test */
    public function is_array_queryable_to_contain_any_strict_key_by_value()
    {
        $helper = Arr::containsAnyStrict($this->array, 'product1.price.first', 100);

        $this->assertTrue($helper);

        $helper = Arr::containsAnyStrict($this->array, 'product1.price.first', [250, 200, 100, 150]);

        $this->assertTrue($helper);

        $helper = Arr::containsAnyStrict($this->array, 'product1.price.first', [250, 200, 600, 150]);

        $this->assertFalse($helper);

        $helper = Arr::containsAnyStrict($this->array, 'product1.price.first', [250, 200, '100', 150]);

        $this->assertFalse($helper);

        $this->assertNotSame($this->array, $helper);
    }

    /** @test */
    public function is_array_queryable_to_contain_strict_key_by_value()
    {
        $helper = Arr::containsStrict($this->array, 'product1.price.first', '100');

        $this->assertFalse($helper);

        $helper = Arr::containsStrict($this->array, 'product1.price.first', 100);

        $this->assertTrue($helper);

        $this->assertNotSame($this->array, $helper);
    }

    /** @test */
    public function is_array_key_replacable()
    {
        $helper = Arr::replaceKey($this->array, 'product1.price.first', 'product1.price.second');

        $this->assertEquals([
            'product1' => [
                'name' => 'Desk',
                'price' => [
                    'second' => 100,
                ],
            ],
            'product2' => [
                'test' => 'Desk',
                'price' => 400,
            ],
        ], $helper);

        $this->assertNotSame([
            'product1' => [
                'name' => 'Desk',
                'price' => [
                    'first' => 100,
                ],
            ],
            'product2' => [
                'test' => 'Desk',
                'price' => 400,
            ],
        ], $helper);
    }

    /** @test */
    public function the_next_key_after_not_knowing_the_key_before()
    {
        $array = [
            0 => 1,
            5 => 5,
            8 => 8,
            13 => 13,
            20 => 20,
            55 => 55,
        ];

        $helper = Arr::nextKey($array, 13);

        $this->assertEquals($helper, 20);
    }

    /** @test */
    public function an_array_can_be_mapped_and_muliplied_against_the_another_array()
    {
        $array = [
            [1, 2, 3],
            [1, 2, 3],
            [1, 2, 3],
        ];

        $multiplyAgainst = [
            [4, 5, 6],
            [4, 5, 6],
            [4, 5, 6],
        ];

        $helper = Arr::arrayMapMultiply($array, $multiplyAgainst);

        $this->assertCount(9, $helper);

        $this->assertSame(reset($helper), [
            1, 2, 3,
            4, 5, 6,
        ]);

        $this->assertSame(end($helper), [
            1, 2, 3,
            4, 5, 6,
        ]);
    }
}
