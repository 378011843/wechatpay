<?php

namespace Ajian\WechatPay;

class BaseWechatPay
{
    /**
     * @var \WeChatPay\BuilderChainable
     */
    protected static $instance;
    /**
     * @var string 商户appid
     */
    protected $appid;
    /**
     * @var string 商户API证书序列号
     */
    protected $serial_no;
    /**
     * @var string 商户号
     */
    protected $mchid;
    /**
     * @var string v3API密钥
     */
    protected $v3Api_key;
    /**
     * @var false|string 商户API私钥 - 传入证书路径
     */
    protected $private_key;
    /**
     * @var false|string 平台证书 - 微信支付负责证书 - 调用"获取平台证书接口"获取
     * 传入证书路径
     */
    protected $certificate;
    /**
     * 平台证书序列号
     * @var string
     */
    protected $certificate_serial;
    /**
     * @var string 认证类型
     */
    public $schema = "WECHATPAY2-SHA256-RSA2048";
    /**
     * @var string 随机字符串
     */
    public $nonceStr;
    /**
     * @var int 当前时间戳
     */
    public $timestamp;

    /**
     * 初始化所需数据
     */
    public function __construct($config=null)
    {
        $this->nonceStr = \Ajian\Helper\Util::createNonceStr();
        $this->timestamp = time();
        if (isset($config['appid'])){
            $this->appid = $config['appid'];
        }
        if (isset($config['mchid'])){
            $this->mchid = $config['mchid'];
        }
        if (isset($config['v3Api_key'])){
            $this->v3Api_key = $config['v3Api_key'];
        }
        if (isset($config['serial_no'])){
            $this->serial_no = $config['serial_no'];
        }
        if (isset($config['private_key']) && file_exists($config['private_key'])){
            $this->private_key = file_get_contents($config['private_key']);
        }
        if (isset($config['certificate_serial'])){
            $this->certificate_serial = $config['certificate_serial'];
        }
        if (isset($config['certificate']) && file_exists($config['certificate'])){
            $this->certificate = file_get_contents($config['certificate']);
        }
        if (self::$instance == null) {
            self::$instance = \WeChatPay\Builder::factory([
                'mchid' => $this->mchid,
                'serial' => $this->serial_no,
                'privateKey' => $this->private_key,
                'certs' => [
                    $this->certificate_serial => $this->certificate
                ],
            ]);
        }
    }

    public function GetAppid(){
        return $this->appid;
    }

    public function GetNonceStr(){
        return $this->nonceStr;
    }

    public function GetTimestamp(){
        return $this->timestamp;
    }
}