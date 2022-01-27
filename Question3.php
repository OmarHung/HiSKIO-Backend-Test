<?php
/**
 * 請你設計出一個 PHP 物件,使用 Session 作為儲存方式,至少達到以下功能
 * 1. 新增商品
 * 2. 移除商品
 * 3. 更新商品數量
 * 4. 取得購物車總共價格
 * 5. 取得購物車內項目清單列表(顯示品名、數量、單價、總價格)
 */

class ShoppingCart 
{
    // 模擬可購買商品
    private $products = [[
        "id" => 0,
        "name" => "P1",
        "price" => 100
    ],[
        "id" => 1,
        "name" => "P2",
        "price" => 200
    ],[
        "id" => 2,
        "name" => "P3",
        "price" => 300
    ],[
        "id" => 3,
        "name" => "P4",
        "price" => 400
    ]];

    public function __construct($isTest = false)
    {
        @session_start();
        if(!isset($_SESSION['products'])) $_SESSION['products'] = [];
        if($isTest) $_SESSION['products'] = [];
    }

    private function getProduct($pid)
    {
        $index = array_search($pid, array_column($this->products, 'id')); 
        if($index === FALSE)
            return NULL;
        
        return $this->products[$index];
    }

    private function getCartProductIndex($pid)
    {
        return array_search($pid, array_column($_SESSION['products'], 'id')); 
    }

    private function shoppingCartValidation($pid)
    {
        return $this->getCartProductIndex($pid) !== FALSE;
    }

    private function productValidation($pid)
    {
        return !is_null($this->getProduct($pid));
    }

    private function pidValidation($pid)
    {
        return $pid >= 0 && is_integer($pid);
    }

    private function qtyValidation($min, $qty)
    {
        return $qty >= $min && is_integer($qty);
    }

    public function addProduct($pid, $qty)
    {      
        try{
            if(!$this->pidValidation($pid)) {
                throw new Exception("商品ID請輸入大於等於0的整數");
            }

            if(!$this->qtyValidation(1, $qty)) {
                throw new Exception("商品數量請輸入正整數");
            }

            if(!$this->productValidation($pid)) {
                throw new Exception("查無該商品");
            }

            $cartProductIndex = $this->getCartProductIndex($pid);
            if($cartProductIndex === FALSE) {
                $_SESSION['products'][] = [
                    "id" => $pid,
                    "qty" => $qty
                ];
            }else {
                $_SESSION['products'][$cartProductIndex]["qty"] += $qty;
            }

            return [
                "status" => TRUE,
                "message" => "新增商品成功"
            ];
        }catch(Exception $e) {
            return [
                "status" => FALSE,
                "message" => $e->getMessage()
            ];
        }
    }

    public function removeProduct($pid)
    {
        try{
            if(!$this->pidValidation($pid)) {
                throw new Exception("商品ID請輸入大於等於0的整數");
            }

            $cartProductIndex = $this->getCartProductIndex($pid);
            if($cartProductIndex === FALSE) {
                throw new Exception("購物車內無此商品");
            }

            array_splice($_SESSION['products'], $cartProductIndex, 1);

            return [
                "status" => TRUE,
                "message" => "移除商品成功"
            ];
        }catch(Exception $e) {
            return [
                "status" => FALSE,
                "message" => $e->getMessage()
            ];
        }
    }

    public function updateProductQty($pid, $qty)
    {    
        try{
            $message = "";

            if(!$this->pidValidation($pid)) {
                throw new Exception("商品ID請輸入大於等於0的整數");
            }

            if(!$this->qtyValidation(0, $qty)) {
                throw new Exception("商品數量請輸入大於等於0的整數");
            }

            if(!$this->productValidation($pid)) {
                throw new Exception("查無該商品");
            }

            $cartProductIndex = $this->getCartProductIndex($pid);
            if($cartProductIndex === FALSE) {
                throw new Exception("購物車內無此商品");
            }
    
            if($qty == 0) {
                array_splice($_SESSION['products'], $cartProductIndex, 1);
                $message = "移除商品成功";
            }else {
                $_SESSION['products'][$cartProductIndex]["qty"] = $qty;
                $message = "更新商品數量成功";
            }

            return [
                "status" => TRUE,
                "message" => $message
            ];
        }catch(Exception $e) {
            return [
                "status" => FALSE,
                "message" => $e->getMessage()
            ];
        }
    }

    public function getTotalPrice()
    {
        $totalPrice = 0;

        foreach($_SESSION['products'] as $item) {
            $product = $this->getProduct($item["id"]);
            if(!is_null($product))
                $totalPrice += $product["price"] * $item["qty"];
        }

        return $totalPrice;
    }

    public function showProductList()
    {
        $productList = [];
        foreach($_SESSION['products'] as $item) {
            $product = $this->getProduct($item["id"]);
            if(!is_null($product))
                $productList[] = [
                    "name" => $product["name"],
                    "qty" => $item["qty"],
                    "price" => $product["price"],
                    "subTotal" => $product["price"] * $item["qty"]
                ];
        }

        return $productList;
    }
}

// $shoppingCart = new ShoppingCart();
// echo json_encode($shoppingCart->addProduct(0.1, 1), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->addProduct(0, 2), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->addProduct(1, 3), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->addProduct(2, 4), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->addProduct(3, 1), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->getTotalPrice(), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->showProductList(), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->removeProduct(1), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->removeProduct(3), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->getTotalPrice(), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->showProductList(), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->updateProductQty(0, 10), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->updateProductQty(1, 5), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->updateProductQty(3, 5), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->getTotalPrice(), JSON_UNESCAPED_UNICODE)."\n";
// echo json_encode($shoppingCart->showProductList(), JSON_UNESCAPED_UNICODE)."\n";