<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ProcessWebhook;
use Illuminate\Support\Facades\Log;

class ProviderController extends Controller
{
    protected function post(Request $request, $provider)
    {
    	Log::debug('Received webhook. Dispatching to queue.');

    	$body = $request->getContent();
    	$headers = $request->headers->all();

 		dispatch(new ProcessWebhook($provider, $body, $headers));
    }
}
