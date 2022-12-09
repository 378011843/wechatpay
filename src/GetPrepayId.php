<?php


namespace Ajian\WechatPay;

/**
 * JSAPI下单 获取prepay_id
 * @package Ajian\WechatPay
 */
class GetPrepayId extends BaseWechatPay
{
    /**
     * @var string 商户订单号
     */
    private $out_trade_no;
    /**
     * @var string 商品描述
     */
    private $description;
    /**
     * @var string 通知地址
     */
    private $notify_url;
    /**
     * @var object 订单金额 [total,currency='CNY']
     */
    private $amount;
    /**
     * @var object 支付者 [openid]
     */
    private $payer;
    /**
     * @var string 附加数据
     */
    private $attach = '';

    public function setParam($data){
        if (isset($data['out_trade_no'])){
            $this->out_trade_no = $data['out_trade_no'];
        }
        if (isset($data['description'])){
            $this->description = $data['description'];
        }
        if (isset($data['notify_url'])){
            $this->notify_url = $data['notify_url'];
        }
        if (isset($data['amount'])){
            $this->amount = $data['amount'];
        }
        if (isset($data['payer'])){
            $this->payer = $data['payer'];
        }
        if (isset($data['attach'])){
            $this->attach = $data['attach'];
        }
    }

    public function request(){
        return self::$instance->chain('v3/pay/transactions/jsapi')->post([
            'json' => [
                'appid' => $this->appid,
                'mchid' => $this->mchid,
                'out_trade_no' => $this->out_trade_no,
                'description' => $this->description,
                'notify_url' => $this->notify_url,
                'amount' => $this->amount,
                'payer' => $this->payer,
                'attach' => $this->attach
            ]
        ]);
    }
}