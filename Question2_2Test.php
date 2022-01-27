<?php 
require('Question2_2.php');
use Q2_2\Pchome;
use Q2_2\Yahoo;
use Q2_2\Ruten;
use Q2_2\Shopee;
use Q2_2\Product;
use PHPUnit\Framework\TestCase;

class Question2_2Test extends TestCase
{
    public function test() 
    {
        $expected = "Pchome 已收到商品發佈通知\nRuten 已收到商品發佈通知\nShopee 已收到商品發佈通知\n";
        $this->expectOutputString($expected);
        $pchome = new Pchome();
        $yahoo = new Yahoo();
        $ruten = new Ruten();
        $shopee = new Shopee();

        $product = new Product();

        // 原本的
        $product->attach($pchome);
        $product->attach($yahoo);
        $product->attach($ruten);

        // 主管的需求
        $product->attach($shopee);
        $product->detach($yahoo);

        $product->publish();
    }
}