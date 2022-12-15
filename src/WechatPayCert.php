<?php

namespace Ajian\WechatPay;

use Ajian\WechatPay\Util\AesUtil;
use GuzzleHttp\Client;
use WeChatPay\Crypto\Rsa;

/**
 * 获取微信支付证书
 * @package Ajian\WechatPay
 */
class WechatPayCert extends BaseWechatPay
{
    public $body = "";
    public $url = "/v3/certificates";

    /**
     * 获取证书字符串 - 自行保存成.pem的文件
     * @return bool|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCert()
    {
        $token = $this->generateToken();
        $client = new Client();
        try {
            $response = $client->request('GET', 'https://api.mch.weixin.qq.com/v3/certificates', [
                'headers' => [
                    'Authorization' => "$this->schema $token",
                    'Accept' => 'application/json',
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $content = json_decode($response->getBody()->getContents(), true);
                $serial_no = $content['data'][0]['serial_no'];
                $ciphertext = $content['data']['0']['encrypt_certificate']['ciphertext'];
                $associated_data = $content['data']['0']['encrypt_certificate']['associated_data'];
                $nonceStr = $content['data']['0']['encrypt_certificate']['nonce'];
                $decrypt = AesUtil::decryptToString($associated_data, $nonceStr, $ciphertext,$this->v3Api_key);
                return $decrypt;
            } else {
                throw new Exception('请求证书失败');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTrace();
        }
    }

    private function generateToken()
    {
        $message = "GET\n$this->url\n$this->timestamp\n$this->nonceStr\n$this->body\n";
        $signature = Rsa::sign($message,$this->private_key);
        # 字段顺序不固定
        return sprintf(
            'mchid="%s",nonce_str="%s",timestamp="%d",serial_no="%s",signature="%s"',
            $this->mchid, $this->nonceStr, $this->timestamp, $this->serial_no, $signature
        );
    }
}