<?php 
require('Question1.php');
use PHPUnit\Framework\TestCase;

class Question1Test extends TestCase
{
    public function test() 
    {
        $this->assertEquals(0, climbStair2(-1));
        $this->assertEquals(0, climbStair2(0));
        $this->assertEquals(1, climbStair2(1));
        $this->assertEquals(2, climbStair2(2));
        $this->assertEquals(3, climbStair2(3));
        $this->assertEquals(5, climbStair2(4));
        $this->assertEquals(8, climbStair2(5));
        $this->assertEquals(13, climbStair2(6));
        $this->assertEquals(10946, climbStair2(20));
        $this->assertEquals(165580141, climbStair2(40));
        $this->assertEquals(44945570212853, climbStair2(66));
    }
}