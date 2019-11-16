<?php



namespace App\Services\YoutubeService;

use App\Http\Requests\API\v1\GetVideoQuery;
use App\Services\YoutubeClient\YoutubeClientInterface;
use DB;
use App\Video;
use App\Services\YoutubeService\Exceptions\VideoNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class YoutubeService implements YoutubeServiceInterface {


    /**
     * @var array
     */
    protected $fields = ['id', 'hash', 'video_embed', 'title', 'description'];

    /**
     * @var
     */
    protected $serviceAPI;

    /** @var YoutubeClientInterface $youtubeClient */
    protected $youtubeClient;

    protected $defaultNumberVideos = 10;

    /**
     * YoutubeService constructor.
     * @param YoutubeClientInterface $youtubeClient
     */
    function __construct(YoutubeClientInterface $youtubeClient)
    {
        $this->youtubeClient = $youtubeClient;
    }

    /**
     * @return int
     */
    public function countVideos(): int
    {
        return Video::count();
    }

    /**
     * @return Collection
     */
    public function getVideosWithThumbnail(): Collection
    {
        return Video::with('thumbnail')->take($this->defaultNumberVideos)->get();
    }

    /**
     * @param string $hash
     * @param array|null $fields
     * @return Collection
     * @throws VideoNotFoundException
     */
    public function getVideoByHash(string $hash, array $fields = null): Collection
    {
        $video = Video::where(DB::raw('BINARY `hash`'), '=', $hash)->get(is_null($fields) ? $this->fields : $fields);
        if (is_null($video)) {
            throw new VideoNotFoundException($hash);
        }
        return $video;
    }

    /**
     * @param int $id
     * @return Video
     * @throws VideoNotFoundException
     */
    public function getVideoById(int $id): Video
    {
        $video = Video::with('thumbnail')->find($id);
        if (is_null($video)) {
            throw new VideoNotFoundException($id);
        }

        return $video;
    }


    /**
     * @param string $hash
     */
    public function addVideoByHash(string $hash)
    {
        //$response = $this->serviceAPI->getVideoFromYoutube($hash);
        $video = $this->youtubeClient->getVideoAsModel($hash);
        $video->save();
        /*
        try {

            $valuesArray = json_decode($response->getBody(), true);

            if (empty($valuesArray['items'][0])) {
                return;
            }

            $items = $valuesArray['items'][0];
            $snippet = $items['snippet'];
            $thumbnails = $snippet['thumbnails'];

            DB::beginTransaction();

            $video = new Video();
            $video->title = $snippet['title'];
            $video->description = $snippet['description'];
            $video->hash = $items['id'];
            $video->video_embed = '//www.youtube.com/embed/' . $items['id'];

            if (!$video->save()) {
                DB::rollBack();
                throw new \Exception('Error saving video');
            }

            foreach ($thumbnails as $key => $thumb) {
                $thumbnail = new Thumbnail();
                if(!is_null(ThumbnailType::where('thumbnail_type_name', '=', $key)->first(['id'])))
                    $typeId = ThumbnailType::where('thumbnail_type_name', '=', $key)->first(['id'])->toArray();
                switch ($key) {
                    case 'default':
                        $thumbnail->thumbnail_type_id = $typeId['id'];
                        break;
                    case 'medium':
                        $thumbnail->thumbnail_type_id = $typeId['id'];
                        break;
                    case 'high':
                        $thumbnail->thumbnail_type_id = $typeId['id'];
                        break;
                    default:
                        continue 2;
                        break;
                }

                $thumbnail->url = $thumb['url'];
                $thumbnail->video_id = $video->id;

                if (!$thumbnail->save()) {
                    DB::rollBack();
                    throw new \Exception('Error saving thumbnail');
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
        */
    }

    /**
     * @param int $id
     * @param string $hash
     * @return Video
     */
    public function editVideoById(int $id, string $hash): Video
    {
        $video = $this->getVideoById($id);
        $video->hash = $hash;
        $video->video_embed = '//www.youtube.com/embed/'.$hash;
        $video->save();
        return $video;
    }

    /**
     * @param string $hash
     * @return array
     */
    public function deleteVideoByHash(string $hash): array
    {
        $video = $this->getVideoByHash($hash);
        Video::destroy($video->id);
        return $video->toArray();
    }

    /**
     * @param int $id
     * @return Video
     */
    public function deleteVideoById(int $id): Video
    {
        $video = $this->getVideoById($id);
        Video::destroy($id);
        return $video;
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function checkIfVideoExistsByUrl(string $hash): bool
    {
        $video = Video::where(DB::raw('BINARY `hash`'), $hash)->first();
        if (is_null($video)) { //if it's empty, it doesn't exist
            return false;
        }
        return true;
    }

    /**
     * @param string $hash
     * @return Video
     */
    public function getVideoDescriptionByHash(string $hash): Video
    {
        $description = Video::where(DB::raw('BINARY `hash`'), $hash)->first(['description']);
        return $description;
    }

    /**
     * @param array|null $fields
     * @return Collection
     */
    public function getAllVideos(array $fields = null): Collection
    {
        return Video::all(is_null($fields) ? $this->fields : $fields);
    }

    /**
     * @param \stdClass|null $request
     * @return Builder
     */
    public function getVideosByTitleOrDescription(\stdClass $request = null): Builder
    {
        if(!property_exists($request, 'text'))
        {
            $request->text = '';
        }
        return Video::where('title', 'LIKE', '%'.$request->text.'%')
            ->orWhere('description', 'LIKE', '%'.$request->text.'%');
    }

    /**
     * @param \stdClass|null $request
     * @return Collection
     */
    public function getVideosOnParameters(\stdClass $request = null): Collection
    {
        return $this->getVideosByTitleOrDescription($request)
                    ->take(property_exists($request, 'limit') ? $request->limit : 10)
                    ->offset(property_exists($request, 'offset') ? $request->offset : 0)
                    ->with('thumbnail')
                    ->get();
    }
}