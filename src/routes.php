<?php

Route::get('pay', '\Ankitgupta\Payments\PaymentsController@pay');

Route::get('pay-response', '\Ankitgupta\Payments\PaymentsController@payResponse');