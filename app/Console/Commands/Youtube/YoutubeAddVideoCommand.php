<?php

namespace App\Console\Commands\Youtube;

use App\Services\YoutubeClient\YoutubeClientInterface;
use App\Services\YoutubeService\YoutubeService;
use App\Services\YoutubeService\YoutubeServiceInterface;


class YoutubeAddVideoCommand extends YoutubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:addvideo {youtube_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new Youtube video to the database';

    /**
     * @var YoutubeServiceInterface
     */
    protected $serviceClient;


    /**
     * YoutubeAddVideoCommand constructor.
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
        try {
            $this->info('Checking video...');

            /**
             * If the video already exists
             */
            if ($this->serviceClient->checkIfVideoExistsByUrl($this->argument('youtube_url'))) {
                $this->info("Error: Video already exists");
                return;
            }

            /**
             * We add the video to the database
             */
            $this->serviceClient->addVideoByHash($this->argument('youtube_url'), $this->fields);

            /**
             * If there was a problem with the API and the video wasn't added
             */
            if (!$this->serviceClient->checkIfVideoExistsByUrl($this->argument('youtube_url'))) {
                $this->info("An error occurred adding the video to the database");
                return;
            }

            /**
             * Confirmation message
             */
            $this->info('Video has been added successfully!');
            $video = $this->serviceClient->getVideoByHash($this->argument('youtube_url'), $this->fields);
            $this->table($this->headers, $video);

        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['youtube_url', InputArgument::REQUIRED, 'The Youtube video URL']
        ];
    }
}
