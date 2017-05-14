<?php

namespace App\Processors\Webhooks;

class BitbucketWebhookProcessor extends WebhookProcessor
{
    public function __construct() {}

    public function name()
    {
        return "bitbucket";
    }

    public function process($body, $headers)
    {
        return "BitbucketWebhookProcessor";
    }

}
