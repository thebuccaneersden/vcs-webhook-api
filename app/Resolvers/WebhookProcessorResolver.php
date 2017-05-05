<?php

namespace App\Resolvers;

use App\Interfaces\Resolvers\WebhookProcessorResolverInterface;

class WebhookProcessorResolver implements WebhookProcessorResolverInterface
{
	protected $webhookProcessors;

	public function __construct($webhookProcessors)
	{
		$this->webhookProcessors = $webhookProcessors;
	}

	public function resolve($name)
	{
		$compatibleProcessor = null;
		foreach ($this->webhookProcessors as $processor) {
			if($processor->name() == $name) {
				$compatibleProcessor = $processor;
			}
		}

		if(empty($compatibleProcessor)) {
			throw new \InvalidArgumentException("Webhook Processor '{$name}' not found");
		}

		return $compatibleProcessor;
	}
}
