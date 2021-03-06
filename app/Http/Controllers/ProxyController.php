<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller as BaseController;

class ProxyController extends BaseController
{
    public function __construct()
    {
        $this->host = getQuintypeAPIHost(Request()->getHost());
    }

    function getRoute($request) {
        $baseUrl = $this->host . "/" . $request->path();
        $queryString = $request->getQueryString();

        if($queryString && $queryString != "")
            return $baseUrl . '?' . $queryString;
        else
            return $baseUrl;
    }

    public function proxyGet(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $this->getRoute($request));
        return response($res->getBody(), $res->getStatusCode())->withHeaders($res->getHeaders());
    }

    public function proxyPost(Request $request, Response $response)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $this->getRoute($request), ['body' => $request->getContent()]);
        $headers = $res->getHeaders();
        unset($headers['Transfer-Encoding']);
        return response($res->getBody(), $res->getStatusCode())->withHeaders($headers);
    }
}
