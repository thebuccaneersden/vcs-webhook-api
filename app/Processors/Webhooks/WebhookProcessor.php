<?php

namespace App\Processors\Webhooks;

use App\Interfaces\Processors\WebhookProcessorStrategyInterface;

use Illuminate\Support\Facades\Log;

abstract class WebhookProcessor implements WebhookProcessorStrategyInterface
{
}
