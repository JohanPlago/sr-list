<?php

namespace AppBundle\WebService\SR;

use AppBundle\WebService\SR\Responses\AllProgramsResponse;
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
     */
    public function __construct(RestClient $client, Serializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function getAllPrograms()
    {
        $programs = $this->doGetAllPrograms();

        return $programs;
    }

    protected function doGetAllPrograms($programs = [], $nextPage = null)
    {
        $url = $nextPage ?: static::API_BASE_URI.'programs/index?format=json&size=100';

        $rawResponse = $this->client->get($url);
        $serializedResponse = $this->serializer->deserialize(
            $rawResponse->getContent(),
            AllProgramsResponse::class,
            'json'
        );

        $programs = array_merge($programs, $serializedResponse->getPrograms());

        if ($serializedResponse->getPagination()->getPage() < $serializedResponse->getPagination()->getTotalPages()) {
            return $this->doGetAllPrograms($programs, $serializedResponse->getPagination()->getNextPage());
        }

        return $programs;
    }
}
