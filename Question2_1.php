<?php
namespace Q2_1;
/**
 * 2.1 小明任職於一家做電商的新創公司,銷售的商品會上架於 Pchome, Yahoo, Ruten(露天)三大拍
 * 賣平台,公司內部有建立一個管理後台,小明的任務是當一個產品發佈(publish)的時候,能夠馬上
 * 通知三大平台產品已經發布,當平台收到通知後就會回傳「Pchome 已收到商品發佈通知」字樣,
 * Yahoo, Ruten 以此類推,請您設計出一個優良的程式碼架構,幫助小明達到此功能!
 */

interface IObserver {
    public function update();
}

interface ISubject {
    public function publish();
}

abstract class Platform {
    /**
     * 通知平台產品發佈，各個平台可能有不同通知方式，
     * 所以給個抽象方法讓各個平台類別去實作
     */
    abstract public function publish();
}

class Pchome extends Platform implements IObserver
{
    /**
     * 接收通知
     */
    public function update()
    {
        $this->publish();
    }

    public function publish()
    {
        echo "Pchome 已收到商品發佈通知\n";
    }
}

class Yahoo extends Platform implements IObserver
{
    /**
     * 接收通知
     */
    public function update()
    {
        $this->publish();
    }

    public function publish()
    {
        echo "Yahoo 已收到商品發佈通知\n";
    }
}

class Ruten extends Platform implements IObserver
{
    /**
     * 接收通知
     */
    public function update()
    {
        $this->publish();
    }

    public function publish()
    {
        echo "Ruten 已收到商品發佈通知\n";
    }
}

class Product implements ISubject 
{
    private $observers = [];

    public function __construct()
    {
        $this->observers[] = new Pchome();
        $this->observers[] = new Yahoo();
        $this->observers[] = new Ruten();
    }

    public function publish()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
}

// $product = new Product();
// $product->publish();