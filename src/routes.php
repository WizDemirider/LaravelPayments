<?php

Route::get('pay/{txnid}/{amount}', '\Ankitgupta\Payments\PaymentsController@pay');

Route::any('pay-response', '\Ankitgupta\Payments\PaymentsController@payResponse');

Route::get('pay-status/{txnid}/{amount}/{date}', '\Ankitgupta\Payments\PaymentsController@payStatus');