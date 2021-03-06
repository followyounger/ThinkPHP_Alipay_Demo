<?php
namespace Org;
class Alipay{
    public function go_pay($total_fee,$out_trade_no){
        require_once dirname(__FILE__).'/config.php';
        require_once dirname(__FILE__).'/pagepay/service/AlipayTradeService.php';
        require_once dirname(__FILE__).'/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

        //商户订单号，商户网站订单系统中唯一订单号，必填 该订单使用传递进来的参数

        //订单名称，必填
        $subject = "在线充值";

        //付款金额，必填
        $total_amount = trim($total_fee);

        //商品描述，可空
        $body = "在线充值";

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService($config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        //输出表单
        return $response;exit;
    }

    //对回调的数据进行校验
    public function check_sign($data){
        require_once dirname(__FILE__).'/config.php';
        require_once dirname(__FILE__).'/pagepay/service/AlipayTradeService.php';
        require_once dirname(__FILE__).'/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

        $aop = new \AlipayTradeService($config);
        $result = $aop->check($data);

        return $result;
    }
}