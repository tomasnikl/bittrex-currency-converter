<?php

include __DIR__ . '/../src/BittrexCurrencyConverter/BittrexCurrencyConverter.php';

$bittrex = new BittrexCurrencyConverter('a09fd0857fc242b0b3e6a4bbc1cfd849', 'a22fa927595c4fc39af32c79faaaf8c8');

$items = $bittrex
    ->fetchCoins()
    ->setCurrency('USD')
//    ->addCoin('SC', 2403.48379412)
//    ->addCoin('DGB', 2403.48379412)
    ->addCoin('BTC', 1)
    ->convert();

print_r($items);