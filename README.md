# LaravelPayments

simply do composer require ankitgupta/payments in a command line or terminal to get this package.
There are 2 routes that you can call, one to make a payment and second to check the status of a transaction.

Set the config in vendor/payments/config/config.php

Redirect to {SITE_URL}/payments/pay/{transactionID}/{amount} with optional get parameters for currency, scamt, clientcode, custacc, to make a payment.

Make a get request to {SITE_URL}/payments/pay-status/{transactionID}/{amount}/{transactionDate in YYYY-MM-DD format} to get the status of the transaction.
