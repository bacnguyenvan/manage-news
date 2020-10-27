<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\WiseBook\WAccessRaw;
use App\Http\Services\ArticleAccessService;
use App\Http\Services\ArticleService;
use Log;

class WisebookAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:WisebookAccess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        Log::info( date('Y-m-d H:i:s')." run crontab command:AccessWisebook success");
        $articleAccessService = new ArticleAccessService();

        // remove record
        // $this->removeRecordInAccessService($articleAccessService);
       
        // new data into article_access
        // $this->createDataFromWisebook($articleAccessService);

        // count and Update access_count
        // $this->updateAccessWisebook($articleAccessService);

    }

    public function removeRecordInAccessService($articleAccessService)
    {
        $now = date('Y-m-d');
        $todayBeforeOneDay = date('Y-m-d',strtotime('-1 day',strtotime($now)));

        $condistons = [
            'access_date' => $todayBeforeOneDay
        ];
        $articleAccessService->repository()->deleteByConditions($condistons);
    }

    public function createDataFromWisebook($articleAccessService)
    {
        $wAccessRaw = new WAccessRaw();
        $list = $wAccessRaw->getList();

        $now = date('Y-m-d');
        $todayBeforeOneDay = date('Y-m-d',strtotime('-1 day',strtotime($now)));

        foreach($list as $item)
        {
            $articleAccessService->repository()->create([
                'wb_book_seq' => $item->book_seq,
                'access_date' => $todayBeforeOneDay,
                'access_count' => $item->totalAccess
            ]) ;
        }
    }

    public function updateAccessWisebook($articleAccessService)
    {
        $articleService = new ArticleService();

        $totalAccessWisebook = $articleAccessService->countAccessWisebook();

        foreach($totalAccessWisebook as $item){
            $articleService->repository()->updateByConditions([
                'wb_book_seq' => $item->wb_book_seq,
            ],[
                'access_count_1' => $item->access_count_1,
                'access_count_2' => $item->access_count_2,
                'access_count_3' => $item->access_count_3,
            ]);
        }
    }
}
