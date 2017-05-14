<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

App::bind('App\Resolvers\WebhookProcessorResolver', function() {
	return new \App\Resolvers\WebhookProcessorResolver([
		new \App\Processors\Webhooks\GithubWebhookProcessor(),
		new \App\Processors\Webhooks\GogsWebhookProcessor(),
		new \App\Processors\Webhooks\BitbucketWebhookProcessor()
	]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'webhooks', 'namespace' => 'Webhooks'], function () {
	Route::post('/provider/{provider}', 'ProviderController@post');
});