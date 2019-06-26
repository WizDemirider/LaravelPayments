<?php

Route::get('payments/pay/{txnid}/{amount}', '\Payments\PaymentsController@pay');

Route::any('payments/pay-response', '\Payments\PaymentsController@payResponse');

Route::get('payments/pay-status/{txnid}/{amount}/{date}', '\Payments\PaymentsController@payStatus');