<?php

namespace App\Console\Commands\Youtube;

use App\Services\YoutubeService\YoutubeService;
use App\Services\YoutubeService\YoutubeServiceInterface;
use App\Video;
use DB;

class YoutubeDeleteVideoCommand extends YoutubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:deletevideo {youtube_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a video from the database via a Youtube URL';

    /**
     * @var YoutubeServiceInterface
     */
    protected $serviceClient;

    /**
     * YoutubeDeleteVideoCommand constructor.
     * @param YoutubeServiceInterface $youtubeService
     */
    public function __construct(YoutubeServiceInterface $youtubeService)
    {
        parent::__construct();
        $this->serviceClient = $youtubeService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            /**
             * If no video was found
             */
            if(!$this->serviceClient->checkIfVideoExistsByUrl($this->argument('youtube_url'))){
                $this->info("There doesn't exist a video with the specified URL");
                return ;
            }

            $this->info('-----------------------------------> VIDEO <-----------------------------------');

            $video = $this->serviceClient->getVideoByHash($this->argument('youtube_url'), $this->fields);
            $this->table($this->headers, $video);
            $this->info('The following video will be deleted.');
            if($this->confirm('Are you sure you want to delete?')){
                $this->serviceClient->deleteVideoByHash($this->argument('youtube_url'));
                $this->info('The video was deleted');
            }else{
                $this->info('The video was not deleted.');
            }

        }catch (\Exception $exception){
            $this->info($exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return [
            ['youtube_url', InputArgument::REQUIRED, 'The Youtube video URL']
        ];
    }
}
