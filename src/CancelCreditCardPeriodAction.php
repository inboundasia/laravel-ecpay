<?php

namespace TsaiYiHua\ECPay;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CancelCreditCardPeriodAction
{
    use ECPayTrait;

    protected $apiUrl;
    protected $postData;
    protected $merchantId;
    protected $hashKey;
    protected $hashIv;
    protected $encryptType='sha256';

    protected $client;

    const ACTION_ReAuth = 'ReAuth';
    const ACTION_Cancel = 'Cancel';

    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->apiUrl = 'https://payment.ecpay.com.tw/Cashier/CreditCardPeriodAction';
        } else {
            $this->apiUrl = 'https://payment-stage.ecpay.com.tw/Cashier/CreditCardPeriodAction';
        }
        $this->postData = new Collection();

        $this->merchantId = config('ecpay.MerchantId');
        $this->hashKey = config('ecpay.HashKey');
        $this->hashIv = config('ecpay.HashIV');
    }

    public function getData($orderId, $action)
    {
        if (!in_array($action, [
            self::ACTION_ReAuth,
            self::ACTION_Cancel
        ])) {
            throw new \Exception('invalid action type');
        }

        $this->postData->put('MerchantID', $this->merchantId);
        $this->postData->put('MerchantTradeNo', $orderId);
        $this->postData->put('Action', $action);
        $this->postData->put('TimeStamp', Carbon::now()->timestamp);
        return $this;
    }
}
