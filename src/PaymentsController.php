<?php

namespace Ankitgupta\Payments;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function pay() {
        $client = new \GuzzleHttp\Client();
        $res = $client->get('https://api.github.com/user', ['auth' =>  ['Wizdemirider', '']]);
        echo $res->getStatusCode(); // 200
        echo $res->getBody(); // { "type": "User", ....
    }

    public function payResponse() {

    }
}
