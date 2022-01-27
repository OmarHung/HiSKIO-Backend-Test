<?php
namespace Q2_2;
 /**
  * 2.2 承上題,當小明完成這個功能時,主管又希望加上 Shopee 的通路,並且拿掉 Yahoo ,對於主
  * 管陰晴不定的心情,隨時都有可能增加、拿掉某個平台通路,請你幫幫小明設計出一個可以按需求
  * 隨時增加、減少通路的架構,並且對於原本檔案更改的幅度是最小的!
  */

interface IObserver {
    public function update();
}

interface ISubject {
    public function attach(IObserver $observer);
    public function detach(IObserver $observer);
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

class Shopee extends Platform implements IObserver
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
        echo "Shopee 已收到商品發佈通知\n";
    }
}

class Product implements ISubject 
{
    /**
     * @var \SplObjectStorage
     */
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(IObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(IObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function publish()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
}

// $pchome = new Pchome();
// $yahoo = new Yahoo();
// $ruten = new Ruten();
// $shopee = new Shopee();

// $product = new Product();

// // 原本的
// $product->attach($pchome);
// $product->attach($yahoo);
// $product->attach($ruten);

// // 主管的需求
// $product->attach($shopee);
// $product->detach($yahoo);

// $product->publish();
