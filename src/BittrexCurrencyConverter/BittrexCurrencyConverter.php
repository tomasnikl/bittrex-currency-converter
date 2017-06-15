<?php

/**
 * Class BittrexCurrencyConverter
 */
class BittrexCurrencyConverter
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var array
     */
    private $coins = [];

    /**
     * @var string
     */
    private $currency = 'USD';

    /**
     * @var array
     */
    private $rates = [];

    /**
     * @var array
     */
    private $results = [];


    /**
     * BittrexWatcher constructor.
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Create bittrex api request
     *
     * @param $url
     * @return mixed
     */
    private function apiRequest($url, $params = [])
    {
        $parameters = null;

        if(count($params)) $parameters = '&' . http_build_query($params);
        $uri = 'https://bittrex.com/api/v1.1/' . $url . '?apikey=' . $this->apiKey . '&nonce=' . time() . $parameters;
        $sign = hash_hmac('sha512', $uri, $this->apiSecret);
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:' . $sign));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $execResult = curl_exec($ch);

        return json_decode($execResult);
    }

    /**
     * Get yout coins from bittrex
     *
     * @return $this
     */
    public function fetchCoins()
    {
        foreach ($this->apiRequest('account/getbalances')->result as $t) {
            if ($t->Balance <= 0) continue;
            $this->addCoin($t->Currency, $t->Balance);
        }

        return $this;
    }

    /**
     * Add coin to array of coins
     *
     * @param $coinCode
     * @param int $balance
     * @return $this
     */
    public function addCoin($coinCode, $balance = 0)
    {
        if (array_key_exists($coinCode, $this->coins))
            $this->coins[$coinCode] += $balance;
        else
            $this->coins[$coinCode] = $balance;

        return $this;
    }

    private function setActualRates()
    {
        $uri = 'https://api.coinmarketcap.com/v1/ticker/?convert=' . $this->getCurrency();
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $execResult = curl_exec($ch);
        $obj = json_decode($execResult);

        foreach($obj as $item) {
            $this->rates[strtolower($item->symbol)] = $item;
        }

        return $this;
    }

    public function convert()
    {
        $this->setActualRates();

        foreach($this->coins as $code => $value) {
            $this->results[strtolower($code)] = [
                'symbol' => $code,
                'value' => $value,
                'valueInBtc' => $this->convertCoinToBtc($code, $value),
                'valueInUsd' => $this->convertBtcToCurrency('USD', $code, $value),
                'valueInMyCurrency' => $this->convertBtcToCurrency($this->currency, $code, $value),
            ];
        }

        return $this->results;
    }

    private function convertBtcToCurrency($moneySymbol, $cryptoSymbol, $balance = 0)
    {
        if(array_key_exists(strtolower($cryptoSymbol), $this->rates)) {
            $priceKey = 'price_' . strtolower($moneySymbol);
            if(!isset($this->rates[strtolower($cryptoSymbol)]->$priceKey)) throw new Exception('Currency code '. $cryptoSymbol .' doesn\'t exists.');
            return $this->rates[strtolower($cryptoSymbol)]->$priceKey * $balance;
        }else{
            throw new Exception('Crypto currency code doesn\'t exists.');
        }
    }

    private function convertCoinToBtc($symbol, $balance = 0)
    {
        if(strtolower($symbol) == 'btc') return $balance;
        $obj = $this->apiRequest('public/getmarketsummary', ['market' => 'btc-' . strtolower($symbol)]);
        return $obj->result[0]->Last * $balance;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}