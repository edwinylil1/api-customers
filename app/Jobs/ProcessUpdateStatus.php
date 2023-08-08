<?php

namespace App\Jobs;

use App\Actions\System\cache\UseCache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessUpdateStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $table, $status, $id_column, $id, $input, $delete_cache;

    /**
     * Create a new job instance.
     */
    public function __construct(string $table, string $status, string $id_column, string $id, string $delete_cache)
    {
        $this->table = $table;
        $this->id_column = $id_column;
        $this->status = $status;
        $this->id = $id;
        $this->delete_cache = $delete_cache;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->update($this->selectStatus($this->status), $this->delete_cache);
    }

    protected function update($status, $delete_cache)
    {
        try {
            DB::update('update ' . $this->table .' set api_status = ' . $status . ' where ' . $this->id_column . '= ?', [$this->id]);
        } catch (\Throwable $th) {
            //throw $th;
           sleep(2); 
        }

        UseCache::cacheKeyExist($delete_cache) ? UseCache::deleteKey($delete_cache) : '';
    }

    protected function selectStatus(string $status) : string
    {
        switch ($status) {
            case '1':
                return '10';
                break;
            case '2':
                return '20';
                break;
            case '4':
                return '40';
                break;
            case '5':
                return '50';
                break;
        }
    }
}
