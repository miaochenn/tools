<?php

class RedEnvelope
{
    private $amount;
    private $num;
    private $minPerAmount = 0.01; //RMB 精度
    private $items = [];

    public function __construct(int $coinAmount, $num = 1)
    {
        $this->amount = $coinAmount / 100; // 桌豆使用人民币精度
        $this->num = $num;
    }

    public function allocation()
    {
        if ($this->amount < $validAmount = $this->minPerAmount * $this->num) {
            throw new Exception('10001');
        }

        $this->apportion();

        return $this->items;
    }

    protected function apportion()
    {
        $num = $this->num;
        $amount = $this->amount;

        while ($num >= 1) {
            if ($num == 1) {
                $perAmount = $this->decimalNumber($amount);
            } else {
                $avgAmount = $this->decimalNumber($amount / $num);

                $perAmount = $this->decimalNumber($this->calcRedEnvelopeAmount($avgAmount, $amount, $num));
            }

            $this->items[] = (int) strval($perAmount * 100); // 人民币转化为桌豆精度

            $amount -= $perAmount;
            $num -= 1;
        }

        shuffle($this->items);
    }

    protected function calcRedEnvelopeAmount($avgAmount, $amount, $num)
    {
        if ($avgAmount <= $this->minPerAmount) {
            return $this->minPerAmount;
        }

        // 浮动计算
        $resultAmount = $this->decimalNumber($avgAmount * (1 + $this->apportionRandRatio()));

        // 如果低于最低金额或超过可领取的最大金额，则重新获取
        if ($resultAmount < $this->minPerAmount || $resultAmount > $this->calcRedEnvelopeAmountMax($amount, $num)) {
            return $this->calcRedEnvelopeAmount($avgAmount, $amount, $num);
        }

        return $resultAmount;
    }

    protected function calcRedEnvelopeAmountMax($amount, $num)
    {
        return $this->minPerAmount + $amount - $num * $this->minPerAmount;
    }

    protected function apportionRandRatio()
    {
        if (mt_rand(1, 100) <= 60) {
            return mt_rand(-70, 70) / 100;
        }

        return mt_rand(-30, 30) / 100;
    }

    protected function decimalNumber($amount)
    {
        return sprintf('%01.2f', round($amount, 2));
    }
}

$split = new RedEnvelope(6,3);
$items = $split->allocation();

for ($i=0; $i<6; $i++) {
    $items[] = 0;
}
shuffle($items);

print_r($items);