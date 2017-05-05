<?php

namespace App\Processors\Webhooks;

use App\Interfaces\Processors\WebhookProcessorStrategyInterface;

class GithubWebhookProcessor implements WebhookProcessorStrategyInterface
{
    public function __construct() {}

    public function name()
    {
        return "github";
    }

    public function process($body, $headers)
    {
        return "GithubWebhookProcessor";
    }

}
