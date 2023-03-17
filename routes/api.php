<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Add Http client to use for making requests
use Illuminate\Support\Facades\Http;

Route::get('/proxy/{method}', function($method = 'anything', Request $request) {

    $allowedMethods = [
        'anything', 'get', 'headers', 'ip', 'user-agent', 'cache', 'etag',
        'response-headers', 'html', 'json', 'robots.txt', 'xml', 'uuid', 'image'
    ];

    if (!in_array($method, $allowedMethods)) {
        return response("The {$method} method is not allowed", 405);
    }

    $reqParams = $request->all();

    // Send the request parameters along to the upstream server
    $response  = Http::get("http://httpbin.org/{$method}", $reqParams);

    // Return JSON
    $body = (($response->header('Content-Type') == 'application/json') ? $response->json() : $response->body());

    return [
        'params' => $reqParams,
        'method' => $request->method(),
        'headers' => $response->headers(),
        'response' => $body
    ];
});


Route::post('/proxy/{method}', function($method = 'POST', Request $request){
    $reqParams = $request->all();

    $response = Http::post("http://httpbin.org/{$method}", $reqParams);

    // Return JSON
    $body = (($response->header('Content-Type') == 'application/json') ? $response->json() : $response->body());

    return [
        'params' => $reqParams,
        'method' => $request->method(),
        'headers' => $response->headers(),
        'response' => $body
    ];
});

Route::get('/proxy', function (Request $request) {
    return redirect('/api/proxy/anything');
});

Route::post('/proxy', function (Request $request) {
    return redirect('/api/proxy/anything');
});


Route::get('/', function(Request $request) {
    return redirect('/api/proxy/anything');
});
