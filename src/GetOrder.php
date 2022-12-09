<?php

namespace Ajian\WechatPay;

/**
 * 查询订单
 * @package Ajian\WechatPay
 */
class GetOrder extends BaseWechatPay
{
    /**
     * 根据商户订单号获取
     * @param $out_trade_no string
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function byOutTradeNo($out_trade_no)
    {
        return self::$instance->chain("v3/pay/transactions/out-trade-no/{$out_trade_no}")->get([
            'query' => [
                'mchid' => $this->mchid
            ]
        ]);
    }

    /**
     * 根据微信支付单号获取
     * @param $transaction_id string
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function byTransactionId($transaction_id)
    {
        return self::$instance->chain("v3/pay/transactions/id/{$transaction_id}")->get([
            'query' => [
                'mchid' => $this->mchid
            ]
        ]);
    }
}