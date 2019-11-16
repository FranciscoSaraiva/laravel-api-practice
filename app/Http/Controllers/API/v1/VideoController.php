<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 10-07-2017
 * Time: 13:54
 */

namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use App\Http\Response\API\v1\ResponseVideo;
use App\Services\YoutubeClient\YoutubeClientInterface;
use App\Services\YoutubeService\Exceptions\VideoNotFoundException;
use App\Services\YoutubeService\YoutubeService;
use App\Services\YoutubeService\YoutubeServiceInterface;
use App\Http\Requests\API\v1\StoreVideoPost;
use App\Http\Requests\API\v1\UpdateVideoPut;
use App\Http\Requests\API\v1\GetVideoQuery;


/**
 * @SWG\Swagger(
 *   basePath="/",
 *   host="projetotest.app",
 *   schemes={"http"},
 *
 *   @SWG\Info(
 *     title="Video API",
 *     description="API to manage local and Youtube videos.",
 *     version="1.0.0"
 *   ),
 * )
 */
class VideoController extends Controller
{
    /** @var YoutubeService $youtubeService  */
    protected $youtubeService;

    /** @var YoutubeClientInterface  */
    protected $youtubeClient;

    /**
     * VideoController constructor.
     * @param YoutubeServiceInterface $youtubeService
     * @param YoutubeClientInterface $youtubeClient
     */
    function __construct(YoutubeServiceInterface $youtubeService, YoutubeClientInterface $youtubeClient)
    {
        $this->youtubeService = $youtubeService;
        $this->youtubeClient = $youtubeClient;

        $this->middleware('video');
    }

    /**
     * @SWG\Get(
     *   path="/videos",
     *   operationId="getVideos",
     *   summary="List 10 videos in the database.",
     *   @SWG\Response(response=200, description="Videos Retrieved Successfully."),
     *   @SWG\Response(response=500, description="Internal Server Error.",)
     * )
     *
     */
    public function index()
    {
        $response = new ResponseVideo();

        $response
            ->setVideos($this->youtubeService->getVideosWithThumbnail())
            ->setTotal($this->youtubeService->countVideos())
            ->message('fetch video list');

        return $response->makeToJson();
    }

    /**
     * @SWG\Get(
     *   path="/videos/{videoId}",
     *   summary="List information of a video with the specified id.",
     *   operationId="getVideo",
     *
     *   @SWG\Parameter(
     *     name="videoId",
     *     in="path",
     *     description="Id of a video in the database.",
     *     required=true,
     *     type="integer",
     *     default=37,
     *   ),
     *   @SWG\Response(response=200, description="Video Retrieved Successfully."),
     *   @SWG\Response(response=404, description="Video Not Found on Youtube."),
     *   @SWG\Response(response=500, description="Internal Server Error.")
     * )
     *
     */
    public function show($id)
    {
        $response = new ResponseVideo();
        try {
            $response
                ->setVideos($this->youtubeService->getVideoById($id))
                ->message('fetch video by id');

            return $response->makeToJson();
        } catch (VideoNotFoundException $vexp) {
            return $response
                ->makeException($vexp);
        } catch (\Exception $exp) {
            return $response
                ->message("internal error")
                ->makeException($exp);
        }
    }

    /**
     * @SWG\Post(
     *   path="/videos",
     *   summary="Post a new video from a youtube hash",
     *   operationId="postVideo",
     *
     *   @SWG\Parameter(
     *     name="Video Hash",
     *     in="body",
     *     description="Hash of a Youtube video to add.",
     *     required=true,
     *     type="string",
     *     default="{""hash"":""pwkeSXa3qvc""}",
     *     @SWG\Schema(ref="#/definitions/Video"),
     *   ),
     *
     *   @SWG\Response(response=200, description="Video Successfully Added to Database."),
     *   @SWG\Response(response=500, description="Internal Server Error.")
     * )
     *
     */
   public function store(StoreVideoPost $request)
   {
        $response = new ResponseVideo();
        try{
            if(!$this->youtubeService->checkIfVideoExistsByUrl($request->hash)){
                $video = $this->youtubeClient->getVideoAsModel($request->hash);
                $response
                    ->setVideos($video)
                    ->message('Added new video');

                return $response->makeToJson();
            }
            $response
                ->setVideos([])
                ->message('Video already exists');
            return $response->makeToJson();

        }catch (VideoNotFoundException $vexp) {
            return $response
                ->makeException($vexp);
        } catch (\Exception $exp) {
            return $response
                ->message("internal error")
                ->makeException($exp);
        }
   }

    /**
     * @SWG\Put(
     *   path="/videos/{videoId}",
     *   summary="Update the hash of an existing video by its id.",
     *   operationId="putVideo",
     *
     *   @SWG\Parameter(
     *     name="videoId",
     *     in="path",
     *     description="Id of a video in the database.",
     *     required=true,
     *     type="integer",
     *     default=50
     *   ),
     *
     *   @SWG\Parameter(
     *     name="Video Hash",
     *     in="body",
     *     description="Hash of a Youtube video to edit.",
     *     required=true,
     *     type="string",
     *     default="{ ""hash"" : ""B7zPiF149q8"" }",
     *     @SWG\Schema(ref="#/definitions/Video"),
     *   ),
     *
     *   @SWG\Response(response=200, description="Video Successfully Added to Database."),
     *   @SWG\Response(response=404, description="Video Not Found."),
     *   @SWG\Response(response=422, description="The Hash Field is Incorrect."),
     *   @SWG\Response(response=500, description="Internal Server Error.")
     * )
     *
     */
   public function update(UpdateVideoPut $request, $id)
   {
       $response = new ResponseVideo();
       try{
           $video = $this->youtubeService->editVideoById($id, $request->hash);
           $response
               ->setVideos($video)
               ->message('Edited Video with id: '.$id);
           return $response->makeToJson();
       }catch (VideoNotFoundException $vexp) {
           return $response
               ->makeException($vexp);
       } catch (\Exception $exp) {
           return $response
               ->message("internal error")
               ->makeException($exp);
       }
   }

    /**
     * @SWG\Delete(
     *   path="/videos/{videoId}",
     *   summary="Delete a video with a specified Id from the database.",
     *   operationId="deleteVideo",
     *   @SWG\Parameter(
     *     name="videoId",
     *     in="path",
     *     description="Id of a video in the database.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(response=200, description="Video Successfully Retrieved From Youtube."),
     *   @SWG\Response(response=404, description="Video Not Found."),
     *   @SWG\Response(response=500, description="Internal Server Error.")
     * )
     */
   public function destroy($id)
   {
       $response = new ResponseVideo();
      try{
         $video = $this->youtubeService->deleteVideoById($id);
         $response
             ->setVideos($video)
             ->message('Deleted Video with id: '.$id);
            return $response->makeToJson();

     } catch (VideoNotFoundException $vexp) {
         return $response
             ->makeException($vexp);
     } catch (\Exception $exp) {
         return $response
             ->message("internal error")
             ->makeException($exp);
     }
   }


    /**
     * @SWG\Get(
     *   path="/videos/youtube/{videoHash}",
     *   summary="Get information of a video from the Youtube API",
     *   operationId="getYoutubeInfo",
     *
     *   @SWG\Parameter(
     *     name="videoHash",
     *     in="path",
     *     description="Video hash from a youtube video",
     *     required=true,
     *     type="string",
     *     default="vr-jtDjTaIc"
     *   ),
     *   @SWG\Response(response=200, description="Video Successfully Retrieved From Youtube."),
     * )
     */
   public function getYoutubeInfo($hash){
       return $this->youtubeClient->getVideoFromYoutube($hash);
   }

    /**
     * @SWG\Get(
     *   path="/videos/search",
     *   summary="Search for videos with different parameters",
     *   operationId="getVideoQuery",
     *
     *    @SWG\Parameter(
     *     name="text",
     *     in="query",
     *     description="Searches video titles and descriptions for these keywords.",
     *     required=false,
     *     type="string",
     *     default="Spacemind"
     *   ),
     *    @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Limits the number of videos to show.",
     *     required=false,
     *     type="integer",
     *     default=5
     *   ),
     *    @SWG\Parameter(
     *     name="offset",
     *     in="query",
     *     description="Retrieves a number of videos starting from an offset value.",
     *     required=false,
     *     type="integer",
     *     default=0
     *   ),
     *
     *   @SWG\Response(response=200, description="Videos Successfully Retrieved."),
     *   @SWG\Response(response=500, description="Internal Server Error.")
     * )
     *
     */
   public function getVideoOnQuery(GetVideoQuery  $request){

       $response = new ResponseVideo();
       try{

           $videos = $this->youtubeService->getVideosOnParameters((object) $request->all());
           $response
               ->setVideos($videos)
               ->setTotal($this->youtubeService->getVideosByTitleOrDescription((object) $request->all())->get()->count())
               ->message('Retrieved the following videos');
           return $response->makeToJson();

       } catch (VideoNotFoundException $vexp) {
           return $response
               ->makeException($vexp);
       } catch (\Exception $exp) {
           return $response
               ->message("internal error")
               ->makeException($exp);
       }
   }
}