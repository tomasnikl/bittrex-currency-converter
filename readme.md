# Bittrex currency converter

very simple php class to transfer your crypto currencies on Bittrex to your currency (USD, EUR, CZK, GBP....)

![Image of Example](https://raw.githubusercontent.com/tomasnikl/bittrex-currency-converter/master/screenshot.png)

## Installation

### Download sources from github or use composer to install: 
```sh
composer require tomasnikl/bittrex-currency-converter
```


### Include to your site/project and initialize BittrexCurrencyConverter class
```php
$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');
```


### Run the magic :)
```php
$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');

$items = $bittrex
    ->fetchCoins()
    ->convert();
```

## Options:

Examples are located in example folder.

### Default

code:

```php
$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');

$items = $bittrex
    ->fetchCoins()
    ->convert();
```

returns:

```php
// your crypto currencies in your Bittrex account
Array
(
    [btc] => Array
        (
            [symbol] => BTC // crypto currency code
            [value] => 2.27690484 // volume in crypto currency code (BTC for this example)
            [valueInBtc] => 2.27690484 // volume in BTC
            [valueInUsd] => 5282.76076453 // volume in USD
            [valueInMyCurrency] => 5282.76076453 // volume in your custom currency (default USD)
            [progress] => Array
                (
                    [1h] => -2.03 // change in percents in last 1 hour
                    [24h] => -14.16 // change in percents in last 24 hour
                    [7d] => -13.41 // change in percents in last 7 days
                )
        )

    [sc] => Array
        (
            [symbol] => SC
            [value] => 19500.4837941
            [valueInBtc] => 0.101597520567
            [valueInUsd] => 251.039478124
            [valueInMyCurrency] => 251.039478124
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [dgb] => Array
        (
            [symbol] => DGB
            [value] => 23800.4837941
            [valueInBtc] => 0.265137389466
            [valueInUsd] => 606.91233675
            [valueInMyCurrency] => 606.91233675
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [total] => Array
        (
            [valueInBtc] => 2.64835684679
            [valueInUsd] => 6126.84997092
            [valueInMyCurrency] => 6126.84997092
        )
)
```

### Convert to your custom currency (GBP, CZK, PLN, EUR....)

code:

```php
$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');

$items = $bittrex
    ->fetchCoins()
    ->setCurrency('CZK')
    ->convert();
```

returns:

```php
// your crypto currencies in your Bittrex account
Array
(
    [btc] => Array
        (
            [symbol] => BTC // crypto currency code
            [value] => 2.27690484 // volume in crypto currency code (BTC for this example)
            [valueInBtc] => 2.27690484 // volume in BTC
            [valueInUsd] => 5282.76076453 // volume in USD
            [valueInMyCurrency] => 122752.31856 // volume in CZK
            [progress] => Array
                (
                    [1h] => -2.03 // change in percents in last 1 hour
                    [24h] => -14.16 // change in percents in last 24 hour
                    [7d] => -13.41 // change in percents in last 7 days
                )
        )

    [sc] => Array
        (
            [symbol] => SC
            [value] => 19500.4837941
            [valueInBtc] => 0.101597520567
            [valueInUsd] => 251.039478124
            [valueInMyCurrency] => 5875.73868665
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [dgb] => Array
        (
            [symbol] => DGB
            [value] => 23800.4837941
            [valueInBtc] => 0.265137389466
            [valueInUsd] => 606.91233675
            [valueInMyCurrency] => 14336.3552649
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [total] => Array
        (
            [valueInBtc] => 2.64835684679
            [valueInUsd] => 6126.84997092
            [valueInMyCurrency] => 142964.412512
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )
)
```

### Add more volume from your wallets
If you have crypto in your wallets, you can add to code too.

code:

```php
$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');

$items = $bittrex
    ->fetchCoins()
    ->addCoin('XZC', 3000)
    ->addCoin('GNT', 5200)
    ->setCurrency('CZK')
    ->convert();
```

returns:

```php
// your crypto currencies in your Bittrex account
Array
(
    [btc] => Array // this is currency volume from Bittrex
        (
            [symbol] => BTC // crypto currency code
            [value] => 2.27690484 // volume in crypto currency code (BTC for this example)
            [valueInBtc] => 2.27690484 // volume in BTC
            [valueInUsd] => 5282.76076453 // volume in USD
            [valueInMyCurrency] => 122752.31856 // volume in CZK
            [progress] => Array
                (
                    [1h] => -2.03 // change in percents in last 1 hour
                    [24h] => -14.16 // change in percents in last 24 hour
                    [7d] => -13.41 // change in percents in last 7 days
                )
        )

    [sc] => Array // this is currency volume from Bittrex
        (
            [symbol] => SC
            [value] => 19500.4837941
            [valueInBtc] => 0.101597520567
            [valueInUsd] => 251.039478124
            [valueInMyCurrency] => 5875.73868665
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [dgb] => Array // this is currency volume from Bittrex
        (
            [symbol] => DGB
            [value] => 23800.4837941
            [valueInBtc] => 0.265137389466
            [valueInUsd] => 606.91233675
            [valueInMyCurrency] => 14336.3552649
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [xzc] => Array // this is currency added in code
        (
            [symbol] => XZC
            [value] => 3000
            [valueInBtc] => 15.34824
            [valueInUsd] => 37446.9
            [valueInMyCurrency] => 876877.206195
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [gnt] => Array // this is currency added in code
        (
            [symbol] => GNT
            [value] => 5200
            [valueInBtc] => 1.0348
            [valueInUsd] => 2382.3956
            [valueInMyCurrency] => 55787.4856874
            [progress] => Array
                (
                    [1h] => -5.03
                    [24h] => 14.16
                    [7d] => 12.41
                )
        )

    [total] => Array
        (
            [valueInBtc] => 2.64835684679
            [valueInUsd] => 6126.84997092
            [valueInMyCurrency] => 142964.412512
        )
)
```

## Buy me a beer
You can buy me a beer via BTC. My BTC wallet address is:
```
14KBa1cBzQg5gEce2Pnu9Wtrqs4sPAAakp
```
