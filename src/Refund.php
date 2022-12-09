<?php


namespace Ajian\WechatPay;

/**
 * 申请退款
 * @package Ajian\WechatPay
 */
class Refund extends BaseWechatPay
{
    /**
     * @var string 微信支付订单号
     */
    private $transaction_id;
    /**
     * @var string 商户订单号
     */
    private $out_trade_no;
    /**
     * @var string 商户退款单号
     */
    private $out_refund_no;
    /**
     * @var string 退款原因
     */
    private $reason;
    /**
     * @var string 退款结果回调url
     */
    private $notify_url = '';
    /**
     * @var string 退款资金来源 示例值：AVAILABLE
     */
    private $funds_account = '';
    /**
     * "amount": {
     * "refund": 888,退款金额
     * "from": [{退款出资账户及金额 - 退款需要从指定账户出资时
     * "account": "AVAILABLE", 出资账户类型
     * "amount": 444 出资金额
     * }],
     * "total": 888,原订单金额
     * "currency": "CNY"退款币种
     * }
     * @var object 金额信息
     */
    private $amount;
    /**
     * @var array 退款商品 - 具体参数查看文档
     */
    private $goods_detail;

    public function setParam($data){
        if (isset($data['transaction_id'])){
            $this->transaction_id = $data['transaction_id'];
        }
        if (isset($data['out_trade_no'])){
            $this->out_trade_no = $data['out_trade_no'];
        }
        if (isset($data['out_refund_no'])){
            $this->out_refund_no = $data['out_refund_no'];
        }
        if (isset($data['reason'])){
            $this->reason = $data['reason'];
        }
        if (isset($data['notify_url'])){
            $this->notify_url = $data['notify_url'];
        }
        if (isset($data['funds_account'])){
            $this->funds_account = $data['funds_account'];
        }
        if (isset($data['amount'])){
            $this->amount = $data['amount'];
        }
        if (isset($data['goods_detail'])){
            $this->goods_detail = $data['goods_detail'];
        }
    }

    public function request(){
        return self::$instance->chain('v3/refund/domestic/refunds')->post([
            'json' => [
                'transaction_id' => $this->transaction_id,
                'out_trade_no' => $this->out_trade_no,
                'out_refund_no' => $this->out_refund_no,
                'reason' => $this->reason,
                'notify_url' => $this->notify_url,
                'amount' => $this->amount
            ]
        ]);
    }
}