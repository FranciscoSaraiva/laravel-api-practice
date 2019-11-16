<?php

namespace App\Console\Commands\Youtube;

use App\Services\YoutubeService\YoutubeServiceInterface;

class YoutubeGetAllVideosCommand extends YoutubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:getvideos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all videos in the database';

    /** @var YoutubeServiceInterface $youtubeService */
    protected $youtubeService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(YoutubeServiceInterface $youtubeService)
    {
        $this->youtubeService = $youtubeService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * If there are no videos
         */
        $videos = $this->youtubeService->getAllVideos($this->fields)->toArray();

        if (empty($videos)) {
            $this->info("No videos exist on the database");
            return;
        }
        $this->info('-----------------------------------> VIDEOS <-----------------------------------');
        $this->table($this->headers, $videos);
        $this->info('Returned '.$this->youtubeService->countVideos().' video(s)');
    }
}
