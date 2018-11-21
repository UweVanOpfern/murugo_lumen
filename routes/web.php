<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get("/payment", function () use ($router){
   return "Payment";
});
$router->post('/payment_api', function () use ($router){
    $request = \Illuminate\Support\Facades\Input::all();
   return "payment api end point " . $request;
});
$router->post('/ussd_gateway', function (\Illuminate\Http\Request $request) use ($router){
    $all = json_encode($request->json()->all());
    $request_data = $request->json()->all();
    $employee_contact = "N/A";
    $amount = 0;
    $telephone = "";
    $service_name = $request_data['service'];
    $id_number = 'N/A';
    if($service_name == 'join_contacts'){
        $id_number = $request_data['id_number'];
        $employee_contact = $request_data['Empoyee_contact'];
        $amount = $request_data['amount'];
        $telephone = $request_data['msisdn'];
    }
    if($service_name == 'behaviors'){
        $id_number = $request_data['id_number'];
        $amount = $request_data['amount'];
        $telephone = $request_data['msisdn'];
    }
    if($service_name == 'Purchase_card'){
        $id_number = $request_data['id_number'];
        $amount = $request_data['amount'];
        $telephone = $request_data['msisdn'];
    }
    if($service_name == 'employee_profile'){
        $id_number = $request_data['id_number'];
        $amount = $request_data['amount'];
        $telephone = $request_data['msisdn'];
    }

    $serverResponse = "";
    try{
        $date = Date("Y-m-d h:i:s");
        app('db')->insert("INSERT INTO service_request VALUES (null, '$service_name', '$telephone', $amount, '$id_number', '$employee_contact', '$date', 'Pending', '$date', '$date')");
        $serverResponse = "Murakoze, murabona uburyo bwo kwishyura mu kanya gato. serivisi murugo";
    }catch (Exception $ex){
        $serverResponse = "Habaye ikibazo, mwongere mugerageze mu kanya";
    }
    echo $serverResponse;

});

