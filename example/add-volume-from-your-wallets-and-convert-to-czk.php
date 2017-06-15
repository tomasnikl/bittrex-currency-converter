<?php

include __DIR__ . '/../src/BittrexCurrencyConverter/BittrexCurrencyConverter.php';

$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');

$items = $bittrex
    ->fetchCoins()
    ->setCurrency('CZK')
    ->addCoin('XZC', 3000)
    ->addCoin('GNT', 5200)
    ->convert();

echo '<pre>';
print_r($items);
echo '</pre>';