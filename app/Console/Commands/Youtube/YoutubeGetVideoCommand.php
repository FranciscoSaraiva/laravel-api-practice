<?php

namespace App\Console\Commands\Youtube;

use App\Services\YoutubeClient\YoutubeClientInterface;
use App\Services\YoutubeService\YoutubeServiceInterface;

class YoutubeGetVideoCommand extends YoutubeCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:getvideo {youtube_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get video information from a Youtube URL';

    /** @var YoutubeServiceInterface $youtubeService */
    protected $youtubeService;

    /**
     * Create a new command instance.
     *
     * @param YoutubeClientInterface $youtubeClient
     * @internal param YoutubeServiceInterface $youtubeService
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

        try {
            /**
             * If no video was found
             */

            $video = $this->youtubeService->getVideoByHash($this->argument('youtube_url'), $this->fields)->toArray();
            if(empty($video)){
                $this->info("There doesn't exist a video with the specified URL");
                return ;
            }

            $this->info('-----------------------------------> VIDEO <-----------------------------------');
            $this->table($this->headers, $video);
            $this->info("\n");
            $this->info('Description');
            $description = $this->youtubeService->getVideoDescriptionByHash($this->argument('youtube_url'))->toArray();
            $this->line($description['description']."\n");

        } catch (\Exception $exception) {
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
