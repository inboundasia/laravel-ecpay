<?php

namespace TsaiYiHua\ECPay;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class QueryCreditCardPeriodInfo
{
    use ECPayTrait;

    protected $apiUrl;
    protected $postData;
    protected $merchantId;
    protected $hashKey;
    protected $hashIv;
    protected $encryptType='md5';

    protected $client;

    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->apiUrl = 'https://payment.ecpay.com.tw/Cashier/QueryCreditCardPeriodInfo';
        } else {
            $this->apiUrl = 'https://payment-stage.ecpay.com.tw/Cashier/QueryCreditCardPeriodInfo';
        }
        $this->postData = new Collection();

        $this->merchantId = config('ecpay.MerchantId');
        $this->hashKey = config('ecpay.InvoiceHashKey');
        $this->hashIv = config('ecpay.InvoiceHashIV');
    }

    public function getData($orderId)
    {
        $this->postData->put('MerchantID', $this->merchantId);
        $this->postData->put('MerchantTradeNo', $orderId);
        $this->postData->put('TimeStamp', Carbon::now()->timestamp);
        return $this;
    }
}