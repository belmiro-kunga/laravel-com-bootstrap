<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\AuditService;
use App\Models\User;

class LogLoginJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $ipAddress;
    protected $userAgent;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $ipAddress, $userAgent)
    {
        $this->userId = $userId;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);
        if ($user) {
            AuditService::logLoginAsync($user, $this->ipAddress, $this->userAgent);
        }
    }
}