<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 14-07-2017
 * Time: 15:24
 */

namespace App\Services\YoutubeService;


use App\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface YoutubeServiceInterface
{
    /**
     * @return mixed
     */
    public function countVideos(): int;

    /**
     * @return mixed
     */
    public function getVideosWithThumbnail(): Collection;

    /**
     * @param string $hash
     * @return Video
     */
    public function getVideoByHash(string $hash): Collection;

    /**
     * @param int $id
     * @return Video
     */
    public function getVideoById(int $id): Video;

    /**
     * @param string $hash
     * @return mixed
     */
    public function addVideoByHash(string $hash);

    /**
     * @param int $id
     * @param string $hash
     * @return Video
     */
    public function editVideoById(int $id, string $hash): Video;

    /**
     * @param string $hash
     * @return array
     */
    public function deleteVideoByHash(string $hash): array;

    /**
     * @param int $id
     * @return Video
     */
    public function deleteVideoById(int $id): Video;

    /**
     * @param string $hash
     * @return bool
     */
    public function checkIfVideoExistsByUrl(string $hash): bool;

    /**
     * @param string $hash
     * @return Video
     */
    public function getVideoDescriptionByHash(string $hash): Video;

    /**
     * @param array $fields
     * @return Collection
     */
    public function getAllVideos(array $fields): Collection;

    /**
     * @param \stdClass|null $request
     * @return Builder
     */
    public function getVideosByTitleOrDescription(\stdClass $request = null): Builder;

    /**
     * @param \stdClass $parameters
     * @return Collection
     */
    public function getVideosOnParameters(\stdClass $parameters): Collection;
}