<?php
/**
 * 给定不同面额的硬币 coins 和一个总金额 amount。
 * 编写一个函数来计算可以凑成总金额所需的最少的硬币个数。
 * 如果没有任何一种硬币组合能组成总金额，返回 -1。
 * 
 * 1.目标：总金额amount目标为0，即硬币组合刚好达到总金额的值，没有剩余
 * 2.原问题和子问题中的变化量:amount
 * 3.什么原因导致amout变化 :  硬币的数量
 * 4.状态方程 dp(n) : 输入一个金额，算出凑成金额的最小硬币数量
 *           dp(n) = 1 （当前硬币的面值） + dp(n-当前硬币的面值) 比如 11 可以是面值为1的1枚硬币+金额10的最小硬币数
 * 框架初步为
 *  dp结果为最小硬币数量  
 * dp(n){
 *    foreach( coins as coin ){
 *       res = min ( res ,1+dp(n-coin) )
 *    }
 *    return res
 * } 
 * 
 */

//先给出优化后

class Solution {

    /**
     * @param Integer[] $coins
     * @param Integer $amount
     * @return Integer
     */
    function coinChange($coins, $amount) {
        $dp = array_fill(0,$amount+1,$amount+1);//$dp数组下标为金额，值为每种金额对应的最小硬币,先初始化给一个不可能的值
        $dp[0]=0;//目标是金额为0
        for($i=0;$i<=$amount;$i++  )  //尝试计算每种金额的最小硬币
        {
            foreach($coins as $coin){
                if( $i-$coin<0 ) continue; //当前金额没有满足条件的硬币能凑齐该数字
                $dp[$i] = min( $dp[$i], $dp[$i-$coin]+1 );  //该为状态方程
            }
        }
        return  $dp[$amount]===$amount+1? -1 : $dp[$amount]; 
    }
}

//优化前
class Solutions {
    private $memo=[];//记录每种金额对应的最小的硬币数
    private $tmp=null;
    /**
     * @param Integer[] $coins
     * @param Integer $amount
     * @return Integer
     */
    function coinChange($coins, $amount) {
        $this->tmp=$amount+1;
        return $this->dp($amount,$coins);
    }
    function dp($n,$coin){
        if( isset($this->memo[$n])  ) return $this->memo[$n];
        if($n===0) return 0;
        if($n<0) return -1;
        $res = $this->tmp;
        foreach( $coin as $coins  ){
            //当前金额的最小硬币数 等于 前一种金额的最小硬币数+1
            $subproblem =$this->dp($n-$coins,$coin);
            if( $subproblem===-1  ) continue;
            $res = min($res,1+$subproblem); 
        }
        $this->memo[$n] = ($res === $this->tmp )?-1:$res;
        return $this->memo[$n];
    }
}