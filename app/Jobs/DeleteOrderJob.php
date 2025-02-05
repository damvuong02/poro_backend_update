<?php

namespace App\Jobs;

use App\Events\DeleteOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteOrderJob implements ShouldQueue
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
        event(new DeleteOrder($this->value));
    }
}
