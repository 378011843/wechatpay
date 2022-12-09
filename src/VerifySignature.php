<?php

namespace Ajian\WechatPay;

/**
 * 验证回调签名
 */
class VerifySignature extends BaseWechatPay
{
    public function verify($headers, $content): bool
    {
        $serial_no = $headers['Wechatpay-Serial'][0];
        $nonceStr = $headers['Wechatpay-Nonce'][0];
        $timestamp = $headers['Wechatpay-Timestamp'][0];
        $signature = $headers['Wechatpay-Signature'][0];
        if ($serial_no != $this->certificate_serial) {
            throw new Exception('序列号验证失败');
        }
        $sign = base64_decode($signature);
        $message = $timestamp . "\n" . $nonceStr . "\n" . $content . "\n";
        return openssl_verify($message, $sign, $this->certificate, OPENSSL_ALGO_SHA256);
    }
}