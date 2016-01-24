<?php

namespace AppBundle\WebService\SR;

use AppBundle\WebService\SR\Exceptions\InvalidEpisodeException;
use AppBundle\WebService\SR\Responses\EpisodeResponse;
use AppBundle\WebService\SR\Responses\EpisodesResponse;
use AppBundle\WebService\SR\Responses\AllProgramsResponse;
use AppBundle\WebService\SR\Responses\Entities\Episode;
use AppBundle\WebService\SR\Responses\Entities\Program;
use AppBundle\WebService\SR\Responses\BaseResponse;
use Ci\RestClientBundle\Services\RestClient;
use JMS\Serializer\Serializer;


/**
 * Class SrWebServiceClient
 */
class SrWebServiceClient
{
    /** @var RestClient */
    protected $client;
    /** @var Serializer */
    protected $serializer;

    const API_BASE_URI = 'http://api.sr.se/api/v2/';

    /**
     * SrWebServiceClient constructor.
     *
     * @param RestClient $client
     * @param $serializer $serializer
     */
    public function __construct(RestClient $client, Serializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * Get all programs/shows by SR
     *
     * @return Program[]
     */
    public function getAllPrograms() : array
    {
        $url = static::API_BASE_URI.'programs/index?format=json&size=100';

        $programs = $this->getObjectsFromPaginatedRequest($url, AllProgramsResponse::class);

        return $programs;
    }

    /**
     * Fetch all episodes from a program
     *
     * @param int $programId
     *
     * @return Episode[]
     */
    public function getAllEpisodesByProgramId(int $programId) : array
    {
        $url = static::API_BASE_URI.'episodes/index?programid='.urlencode($programId).'&format=json&size=100';

        $episodes = $this->getObjectsFromPaginatedRequest($url, EpisodesResponse::class);

        return $episodes;
    }

    /**
     * Search for episodes (with manual paging!)
     *
     * @param string $searchTerm
     * @param int $page
     * @param int $size
     *
     * @return EpisodesResponse
     */
    public function searchForEpisode(string $searchTerm, int $page = 1, int $size = 30) : EpisodesResponse
    {
        $url = static::API_BASE_URI.'episodes/search?query='.rawurlencode($searchTerm)
               .'&page='.$page.'&size='.$size
               .'&format=json';

        $response =  $this->doGetObjectsRequest($url, EpisodesResponse::class);

        return $response;
    }

    /**
     * Get data about a single episode
     *
     * @param int $id
     *
     * @return Episode
     *
     * @throws InvalidEpisodeException if no episode was found
     */
    public function getEpisode(int $id) : Episode
    {
        $url = static::API_BASE_URI.'episodes/get?id='.urlencode($id).'&format=json';

        $rawResponse = $this->client->get($url);

        if ($rawResponse->getStatusCode() === 404) {
            throw InvalidEpisodeException::notFound($id);
        }

        $deserializedResponse = $this->serializer->deserialize(
            $rawResponse->getContent(),
            EpisodeResponse::class,
            'json'
        );

        return $deserializedResponse->getEpisode();
    }

    /**
     * Fetches objects/entities (i.e. programs, episodes) from the paginated index
     *
     * @param string $url The url to fetch the objects from
     * @param string $targetClass The target response class to create
     * @param array $foundObjects Objects found on previous pages
     *
     * @return array
     */
    protected function getObjectsFromPaginatedRequest(
        string $url,
        string $targetClass,
        array $foundObjects = []
    ) : array
    {
        $response = $this->doGetObjectsRequest($url, $targetClass);

        $foundObjects = array_merge($foundObjects, $response->getEntities());

        if (
            $response->getPagination()->getPage() < $response->getPagination()->getTotalPages()
        ) {
            return $this->getObjectsFromPaginatedRequest(
                $response->getPagination()->getNextPage(),
                $targetClass,
                $foundObjects
            );
        }

        return $foundObjects;
    }

    /**
     * @param string $url
     * @param string $targetClass
     *
     * @return BaseResponse
     */
    protected function doGetObjectsRequest(string $url, string $targetClass) : BaseResponse
    {
        $rawResponse = $this->client->get($url);

        $deserializedResponse = $this->serializer->deserialize(
            $rawResponse->getContent(),
            $targetClass,
            'json'
        );

        return $deserializedResponse;
    }
}
