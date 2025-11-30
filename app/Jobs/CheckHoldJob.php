<?php

namespace App\Jobs;

use App\Models\Hold;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckHoldJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      $holds=Hold::where('expires_at','<',now())->where('status','available')->get();
      foreach($holds as $hold){
        $hold->update(['status'=>'expired']);
        $hold->product->increment('available_stock', $hold->stock);
      }

    }
}
