<?php

namespace Payments;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Config;
use Redirect;
use Storage;
use Illuminate\Support\Facades\Input;

class PaymentsController extends Controller
{
    public function pay($txnid, $amount) { // Args: Merchant’s Transaction ID (Unique Transaction ID generated by the Merchant) and amount to pay

        //................................................
        //payment config defined in PaymentServiceProvider
        //................................................

        $login = config('payment-config.LOGIN'); //login ID of merchant
        $pass = config('payment-config.PASS'); //merchant password
        $productid = config('payment-config.PRODID'); //product ID

        $currency = Input::get('currency') ?? 'INR'; // transaction currency
        $transactionType = 'NBFundTransfer'; // CCFundTransfer if CC details collected by merchant. Not supported by this package yet
        $serviceCharge = Input::get('scamt') ?? '0'; //  Charged by the merchant
        $clientCode = Input::get('clientcode') ?? 'dummy'; // customer identification from merchant side
        $customerAccount = Input::get('custacc') ?? '12345678';

        date_default_timezone_set("Asia/Kolkata");
        $date = date('d/m/Y').'%20'.date('H:i:s');

        $signature_string = $login.$pass.$transactionType.$productid.$txnid.$amount.$currency;
        $signature = hash_hmac('sha512', $signature_string, 'KEY123657234');

        $returnURL = config('payment-config.SITE_URL').'/payments/pay-response';
        $url = 'https://paynetzuat.atomtech.in/paynetz/epi/fts?login='.$login.'&pass='.$pass.'&prodid='.$productid.'&txnid='.$txnid.'&amt='.$amount.'&txncurr='.$currency.'&ttype='.$transactionType.'&clientcode='.$clientCode.'&date='.$date.'&txnscamt='.$serviceCharge.'&custacc='.$customerAccount.'&signature='.$signature.'&ru='.$returnURL;
        return Redirect::to($url);
    }

    public function payResponse() {
        // verify response
        if($_REQUEST['f_code']=="Ok")
        {
            $signature_string = $_REQUEST['mmp_txn'].$_REQUEST['mer_txn'].$_REQUEST['f_code'].$_REQUEST['prod'].$_REQUEST['discriminator'].$_REQUEST['amt'].$_REQUEST['bank_txn'];
            $signature = hash_hmac('sha512', $signature_string, 'KEYRESP123657234');
            if($signature==$_REQUEST['signature'])
            {
                return Redirect::to(config('payment-config.RETURN_TRUE_URL'));
            }
        }
        return Redirect::to(config('payment-config.RETURN_FALSE_URL'));
    }

    public function payStatus($txnid, $amount, $date) {
        $merchantid = config('payment-config.LOGIN');

        $url = 'https://paynetzuat.atomtech.in/paynetz/vfts?merchantid='.$merchantid.'&merchanttxnid='.$txnid.'&amt='.$amount.'&tdate='.$date;

        $client = new \GuzzleHttp\Client();
        $res = $client->get($url);

        $xml = simplexml_load_string($res->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);

        return $xml;
    }
}
