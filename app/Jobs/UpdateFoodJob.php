<?php

namespace App\Jobs;

use App\Events\UpdateFood;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFoodJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $value;
    
    public function __construct( $value)
    {
        $this->value = $value;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Log giá trị $value để kiểm tra dữ liệu
   

        // Khởi tạo và dispatch sự kiện với dữ liệu
        event(new UpdateFood($this->value));
    }
}
