<?php

include __DIR__ . '/../src/BittrexCurrencyConverter/BittrexCurrencyConverter.php';
$bittrex = new BittrexCurrencyConverter('YOUR_BITTREX_API_KEY', 'YOUR_BITTREX_API_SECRET');
$currency = 'CZK';

$items = $bittrex
    ->fetchCoins()
    ->setCurrency($currency)
    ->convert();
?>
<html>
<head>
    <title><?php echo $items['total']['valueInMyCurrency'] .' '.$currency; ?> - Bittrex crypto converter</title>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi, user-scalable=no">
    <style>
        body {
            line-height: 1.4;
            background: #f1f4f8;
            color: #4c5462;
            font-size: 16px;
            font-family: "Helvetica Neue Light", "HelveticaNeue-Light", "Helvetica Neue", Calibri, Helvetica, Arial, sans-serif;
            padding: 15px;
        }

        hr {
            border: none;
            border-top: 1px solid #d2d5d9;
            width: 50%;
            display: block;
            margin: 30px auto 30px auto;
        }

        .wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        .item {
            background: #fff;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            margin: 0 0 15px 0;
        }

        .item strong small {
            font-weight: 300;
            font-size: 10px;
            opacity: 0.6;
        }

        h2 {
            font-size: 16px;
            margin: 0;
            padding: 0;
            color: #4B77BE;
        }

        .clearfix {
            clear: both;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
            text-align: right;
        }

        .info {
            font-size: 14px;
        }

        .error {
            color: #F04903;
        }

        .success {
            color: #71BA51;
        }
    </style>
</head>

<body>
<div class="wrapper">
    <div class="item">
        <h2 class="name">Total:</h2>
        <div>
            <span>BTC:</span>
            <strong><?php echo number_format($items['total']['valueInBtc'], 8, ',', ' ') ?></strong>
        </div>
        <div>
            <span>USD:</span>
            <strong><?php echo number_format($items['total']['valueInUsd'], 2, ',', ' ') ?></strong>
        </div>
        <div>
            <span><?php echo $currency ?>:</span>
            <strong><?php echo number_format($items['total']['valueInMyCurrency'], 2, ',', ' ') ?></strong>
        </div>
    </div>

</div>


<div class="wrapper">
    <hr>
    <?php foreach($items as $key => $item): ?>
        <?php if($key == 'total') continue; ?>
        <div class="item">
            <h2 class="name"><?php echo strtoupper($key) ?></h2>
            <div class="left">
                <div>
                    <span>BTC:</span>
                    <strong><?php echo number_format($item['valueInBtc'], 8, ',', ' ') ?></strong>
                </div>
                <div>
                    <span>USD:</span>
                    <strong><?php echo number_format($item['valueInUsd'], 2, ',', ' ') ?></strong>
                </div>
                <div>
                    <span><?php echo $currency ?>:</span>
                    <strong><?php echo number_format($item['valueInMyCurrency'], 2, ',', ' ') ?></strong>
                </div>
            </div>
            <div class="right">
                <div class="info">
                    <span>1H:</span>
                    <span class="<?php echo $item['progress']['1h'] == 0 ? '' : ($item['progress']['1h'] > 0 ? 'success' : 'error') ?>">
                        <?php echo $item['progress']['1h'] < 0 ? '' : '+' ?><?php echo number_format($item['progress']['1h'], 2, ',', ' ') ?>%
                    </span>
                </div>
                <div class="info">
                    <span>24H:</span>
                    <span class="<?php echo $item['progress']['24h'] == 0 ? '' : ($item['progress']['24h'] > 0 ? 'success' : 'error') ?>">
                        <?php echo $item['progress']['24h'] < 0 ? '' : '+' ?><?php echo number_format($item['progress']['24h'], 2, ',', ' ') ?>%
                    </span>
                </div>
                <div class="info">
                    <span>7D:</span>
                    <span class="<?php echo $item['progress']['7d'] == 0 ? '' : ($item['progress']['7d'] > 0 ? 'success' : 'error') ?>">
                        <?php echo $item['progress']['7d'] < 0 ? '' : '+' ?><?php echo number_format($item['progress']['7d'], 2, ',', ' ') ?>%
                    </span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endforeach ?>
</div>
</body>
</html>