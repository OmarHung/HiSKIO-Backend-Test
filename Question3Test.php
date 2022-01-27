<?php 
require('Question3.php');
use PHPUnit\Framework\TestCase;

class Question3Test extends TestCase
{
    /**
     * @dataProvider addProductProvider
     */  
    public function testAddProduct($pid, $qty, $expected) 
    {
        $shoppingCart = new ShoppingCart(true);
        $result = $shoppingCart->addProduct($pid, $qty);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider removeProductProvider
     */  
    public function testRemoveProduct($pid, $qty, $pid2, $expected) 
    {
        $shoppingCart = new ShoppingCart(true);
        $shoppingCart->addProduct($pid, $qty);
        $result = $shoppingCart->removeProduct($pid2);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider updateQtyProvider
     */  
    public function testUpdateQty($pid, $qty, $pid2, $qty2, $expected) 
    {
        $shoppingCart = new ShoppingCart(true);
        $shoppingCart->addProduct($pid, $qty);
        $result = $shoppingCart->updateProductQty($pid2, $qty2);
        $this->assertEquals($expected, $result);
    }

    public function testGetTotalPrice1() 
    {
        $shoppingCart = new ShoppingCart(true);
        $shoppingCart->addProduct(0, 1);
        $shoppingCart->addProduct(1, 2);
        $shoppingCart->addProduct(2, 3);
        $result = $shoppingCart->getTotalPrice();
        $this->assertEquals(1400, $result);
    }

    public function testGetTotalPrice2() 
    {
        $shoppingCart = new ShoppingCart(true);
        $shoppingCart->addProduct(0, 1);
        $shoppingCart->addProduct(1, 2);
        $shoppingCart->addProduct(2, 3);
        $shoppingCart->removeProduct(0);
        $result = $shoppingCart->getTotalPrice();
        $this->assertEquals(1300, $result);
    }

    public function testGetTotalPrice3() 
    {
        $shoppingCart = new ShoppingCart(true);
        $shoppingCart->addProduct(0, 1);
        $shoppingCart->removeProduct(0);
        $shoppingCart->addProduct(1, 2);
        $shoppingCart->addProduct(2, 3);
        $shoppingCart->updateProductQty(2, 0);
        $result = $shoppingCart->getTotalPrice();
        $this->assertEquals(400, $result);
    }

    public function testShowProductList1() 
    {
        $shoppingCart = new ShoppingCart(true);
        $shoppingCart->addProduct(0, 1);
        $shoppingCart->addProduct(1, 2);
        $shoppingCart->addProduct(2, 3);
        $result = $shoppingCart->showProductList();
        $this->assertEquals([
            [
                "name" => "P1",
                "qty" => 1,
                "price" => 100,
                "subTotal" => 100
            ],
            [
                "name" => "P2",
                "qty" => 2,
                "price" => 200,
                "subTotal" => 400
            ],
            [
                "name" => "P3",
                "qty" => 3,
                "price" => 300,
                "subTotal" => 900
            ]
        ], $result);
    }

    public function testShowProductList2() 
    {
        $shoppingCart = new ShoppingCart(true);
        $shoppingCart->addProduct(0, 1);
        $shoppingCart->addProduct(0, 2);
        $shoppingCart->addProduct(3, 8);
        $shoppingCart->addProduct(2, 3);
        $result = $shoppingCart->showProductList();
        $this->assertEquals([
            [
                "name" => "P1",
                "qty" => 3,
                "price" => 100,
                "subTotal" => 300
            ],
            [
                "name" => "P4",
                "qty" => 8,
                "price" => 400,
                "subTotal" => 3200
            ],
            [
                "name" => "P3",
                "qty" => 3,
                "price" => 300,
                "subTotal" => 900
            ]
        ], $result);
    }

    public function testShowProductList3() 
    {
        $shoppingCart = new ShoppingCart(true);
        // 加1個P1
        $shoppingCart->addProduct(0, 1);

        // 加2個P1
        $shoppingCart->addProduct(0, 2);

        // 加3個P2
        $shoppingCart->addProduct(1, 3);

        // 加8個P4
        $shoppingCart->addProduct(3, 8);

        // 加3個P3
        $shoppingCart->addProduct(2, 3);

        // 移除全部P1
        $shoppingCart->removeProduct(0);

        // 移除全部P3
        $shoppingCart->updateProductQty(2, 0);
        $result = $shoppingCart->showProductList();
        $this->assertEquals([
            [
                "name" => "P2",
                "qty" => 3,
                "price" => 200,
                "subTotal" => 600
            ],
            [
                "name" => "P4",
                "qty" => 8,
                "price" => 400,
                "subTotal" => 3200
            ]
        ], $result);
    }
 
    public function addProductProvider()
    {
        return [
            "data1"=> [ 0 , 1 , [
                "status" => TRUE,
                "message" => "新增商品成功"
            ]],
            "data2"=> [ -1 , 1 , [
                "status" => FALSE,
                "message" => "商品ID請輸入大於等於0的整數"
            ]],
            "data3"=> [ 5 , 1 , [
                "status" => FALSE,
                "message" => "查無該商品"
            ]],
            "data4"=> [ 1 , 0.25 , [
                "status" => FALSE,
                "message" => "商品數量請輸入正整數"
            ]],
            "data5"=> [ 1 , -0.25 , [
                "status" => FALSE,
                "message" => "商品數量請輸入正整數"
            ]],
            "data6"=> [ 1 , -3 , [
                "status" => FALSE,
                "message" => "商品數量請輸入正整數"
            ]],
            "data6"=> [ 0.1 , 3 , [
                "status" => FALSE,
                "message" => "商品ID請輸入大於等於0的整數"
            ]]
        ];
    }
 
    public function removeProductProvider()
    {
        return [
            "data1"=> [ 0 , 1 , 0, [
                "status" => TRUE,
                "message" => "移除商品成功"
            ]],
            "data2"=> [ 0 , 1 , 1, [
                "status" => FALSE,
                "message" => "購物車內無此商品"
            ]],
            "data3"=> [ 0 , 1 , -1, [
                "status" => FALSE,
                "message" => "商品ID請輸入大於等於0的整數"
            ]],
            "data4"=> [ 0 , 1 , -0.1, [
                "status" => FALSE,
                "message" => "商品ID請輸入大於等於0的整數"
            ]]
        ];
    }
 
    public function updateQtyProvider()
    {
        return [
            "data1"=> [ 0 , 1 , 0, 5, [
                "status" => TRUE,
                "message" => "更新商品數量成功"
            ]],
            "data2"=> [ 0 , 1 , 1, 5, [
                "status" => FALSE,
                "message" => "購物車內無此商品"
            ]],
            "data3"=> [ 0 , 1 , -1, 5, [
                "status" => FALSE,
                "message" => "商品ID請輸入大於等於0的整數"
            ]],
            "data4"=> [ 0 , 1 , -0.1, 5, [
                "status" => FALSE,
                "message" => "商品ID請輸入大於等於0的整數"
            ]],
            "data5"=> [ 0 , 1 , 0, 0, [
                "status" => TRUE,
                "message" => "移除商品成功"
            ]],
            "data6"=> [ 0 , 1 , 0, -5, [
                "status" => FALSE,
                "message" => "商品數量請輸入大於等於0的整數"
            ]],
            "data7"=> [ 0 , 1 , 0, 0.5, [
                "status" => FALSE,
                "message" => "商品數量請輸入大於等於0的整數"
            ]]
        ];
    }
}