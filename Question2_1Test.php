<?php 
require('Question2_1.php');
use Q2_1\Product;
use PHPUnit\Framework\TestCase;

class Question2_1Test extends TestCase
{
    public function test() 
    {
        $expected = "Pchome 已收到商品發佈通知\nYahoo 已收到商品發佈通知\nRuten 已收到商品發佈通知\n";
        $this->expectOutputString($expected);
        $product = new Product();
        $product->publish();
    }
}