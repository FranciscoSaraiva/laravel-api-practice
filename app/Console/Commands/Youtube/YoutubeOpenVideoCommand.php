<?php

namespace App\Console\Commands\Youtube;

use App\Services\YoutubeService\YoutubeServiceInterface;

class YoutubeOpenVideoCommand extends YoutubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:openvideo {youtube_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $video = $this->youtubeService->getVideoByHash($this->argument('youtube_url'));
        if(empty($video)){
            $this->info('No video was found with this hash.');
            return ;
        }

        $this->info('-----------------------------------> VIDEO <-----------------------------------');
        $this->table($this->headers, $video);
        $this->info("\n");
        $this->info('Description');
        $description = $this->youtubeService->getVideoDescriptionByHash($this->argument('youtube_url'))->toArray();
        $this->line($description['description']."\n");
        //-


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
