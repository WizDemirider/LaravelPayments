<?php

Route::get('pay', '\Ankitgupta\Payments\PaymentsController@pay');

Route::post('pay-response', '\Ankitgupta\Payments\PaymentsController@payResponse');