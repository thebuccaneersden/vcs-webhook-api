<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

use App\Resolvers\WebhookProcessorResolver;
use App\Processors\Webhooks\GithubWebhookProcessor;
use App\Processors\Webhooks\GogsWebhookProcessor;

class ProcessWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $provider;
    protected $body;
    protected $headers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($provider, $body, $headers)
    {
        $this->provider = $provider;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Handling dispatched webhook from provider: ' . $this->provider);
        Log::debug($this->body);
        Log::debug($this->headers);

        // 
        // Grab resolver:
        // TODO: This needs to be dealt with slightly differently later, so we
        // don't set our dependencies here
        $processors = [];
        $processors[] = new GithubWebhookProcessor();
        $processors[] = new GogsWebhookProcessor();

        $resolver = new WebhookProcessorResolver($processors);
        try {
            $processor = $resolver->resolve($this->provider);
            $result = $processor->process($this->body, $this->headers);
            Log::debug("Completed job!");
            Log::debug($result);
        } catch(\InvalidArgumentException $iae) {
            Log::debug($iae->getMessage());
        } catch( \Exception $e ) {
            Log::debug($e->getMessage());
        }
    }
}
