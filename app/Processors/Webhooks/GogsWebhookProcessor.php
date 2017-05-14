<?php

namespace App\Processors\Webhooks;

class GogsWebhookProcessor extends WebhookProcessor
{
    public function __construct() {}

    public function name()
    {
        return "gogs";
    }

    public function process($body, $headers)
    {
        return "GogsWebhookProcessor";
    }

}
