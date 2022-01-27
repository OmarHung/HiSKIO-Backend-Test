<?php
/**
 * 您正在爬樓梯,樓梯具有 n 層階梯,您可以一次爬 1 層階梯,或是一次爬 2 層階梯,請問 n 層階
 * 梯有多少種方法可以登頂?
 */

// function climbStair1($n)
// {
//     if($n <= 1) {
//         return 1;
//     }
    
//     return climbStair1($n - 1) + climbStair1($n - 2);
// }

// echo climbStair1(1)."\n";
// echo climbStair1(2)."\n";
// echo climbStair1(3)."\n";
// echo climbStair1(4)."\n";
// echo climbStair1(5)."\n";
// echo climbStair1(6)."\n";
// echo climbStair1(66)."\n";
// echo climbStair1(666)."\n";
// echo climbStair1(6666)."\n";
// echo climbStair1(66666)."\n";
// echo "=====================\n";

function climbStair2($n)
{
    if($n < 1) {
        return 0;
    }

    $result = 1;
    $basic = [1, 1];
    for($i=1; $i<$n; $i++) {
        $result = $basic[0] + $basic[1];
        $basic[0] = $basic[1];
        $basic[1] = $result;
    }

    return $result;
}

// echo climbStair2(-1)."\n";
// echo climbStair2(0)."\n";
// echo climbStair2(1)."\n";
// echo climbStair2(2)."\n";
// echo climbStair2(3)."\n";
// echo climbStair2(4)."\n";
// echo climbStair2(5)."\n";
// echo climbStair2(6)."\n";
// echo climbStair2(20)."\n";
// echo climbStair2(40)."\n";
// echo climbStair2(66)."\n";