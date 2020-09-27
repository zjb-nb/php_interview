<?php
class Solution
{

    /**
     * 第一种是采用递归的方式，时间复杂度为O(log2n)
     * @param Integer $N
     * @return Integer
     */
    function fib1($N)
    {
        return $N < 2 ? $N : ($this->fib1($N - 2) + $this->fib1($N - 1));
    }

    /**
     *第二种和第三种都是寻找最长子序列，即fn=(fn-1)+(fn-2)
     *两种存中间值方式不同，前者临时变量，后者DB table
     */
    function fib2($N)
    {
      if($N<2) return $N;
      $f1=0;$f2=1;$i=2;
      while($i<=$N){
          $tmp=$f1+$f2;
          $f1=$f2;$f2=$tmp;
          $i++;
      }
      return $f2;
    }
    function fib3($N)
    {
      if($N<2) return $N;
      $tmp=[0,1];$i=2;
      while($i<=$N){
          $tmp[$i]=$tmp[$i-1]+$tmp[$i-2];
          $i++;
      }
      return $tmp[$N];
    }
}
