<?php

namespace App\Interfaces\Processors;

interface WebhookProcessorStrategyInterface {
	public function name();
    public function process($body, $headers);
}