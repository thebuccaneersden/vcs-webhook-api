<?php

namespace App\Processors\Webhooks;

use App\Interfaces\Processors\WebhookProcessorStrategyInterface;

class GogsWebhookProcessor implements WebhookProcessorStrategyInterface
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
