<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function ProductHasAName()
    {
    	$product = new Product('iphone 7',5000);
        $this->assertEquals('iphone 7',$product->name());
    }
    /** @test */
    public function ProductHasPrice()
    {
    	$product = new Product('Macbook',10000);
    	$this->assertEquals(10000, $product->price());
    }
}
