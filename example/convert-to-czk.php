<?php

include __DIR__ . '/../src/BittrexCurrencyConverter/BittrexCurrencyConverter.php';

$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');

$items = $bittrex
    ->fetchCoins()
    ->setCurrency('CZK')
    ->convert();

echo '<pre>';
print_r($items);
echo '</pre>';