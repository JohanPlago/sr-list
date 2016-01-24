<?php

namespace Tests\AppBundle\WebService\SR;

use AppBundle\WebService\SR\Exceptions\InvalidEpisodeException;
use AppBundle\WebService\SR\Responses\Entities\Episode;
use AppBundle\WebService\SR\Responses\Entities\Program;
use AppBundle\WebService\SR\SrWebServiceClient;
use Ci\RestClientBundle\Services\RestClient;
use JMS\Serializer\{
    Serializer,
    SerializerBuilder
};
use Symfony\Component\HttpFoundation\Response;

/**
 * Test the SR WebService REST client
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */
class SrWebServiceClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var RestClient|\PHPUnit_Framework_MockObject_MockObject */
    protected $restClient;
    /** @var Serializer */
    protected $serializer;

    /**
     * Just setup a rest client mock and the serializer
     */
    public function setUp()
    {
        $this->restClient = $this
            ->getMockBuilder(RestClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Test so all data in the response has been unserialized properly
     */
    public function testGetAllProgramsDataIsCorrect()
    {
        $sampleData = $this->getGetAllProgramsSingleTestData();
        $client = new SrWebServiceClient($this->restClient, $this->serializer);

        $this->restClient
            ->expects($this->once())
            ->method('get')
            ->with($this->stringContains('programs/index'))
            ->willReturn(new Response($sampleData));

        /** @var Program[] $programs (just for the autocompletion :) ) */
        $programs = $client->getAllPrograms();
        // It should just be one single program returned from the sample data
        $program = $programs[0];

        $this->assertTrue(
            $program instanceof Program,
            'Returned response should be an array of Programs'
        );

        $sampleProgram = json_decode($sampleData, true)['programs'][0];

        $this->assertEquals(
            $sampleProgram['id'],
            $program->getSrId(),
            'ID should be set'
        );
        $this->assertEquals(
            $sampleProgram['name'],
            $program->getName(),
            'Name should be set'
        );
        $this->assertEquals(
            $sampleProgram['description'],
            $program->getDescription(),
            'Description should be set'
        );
        $this->assertEquals(
            $sampleProgram['programcategory']['id'],
            $program->getProgramCategory()->getSrId(),
            'Program category id should be set'
        );
        $this->assertEquals(
            $sampleProgram['programcategory']['name'],
            $program->getProgramCategory()->getName(),
            'Program category name should be set'
        );
        $this->assertEquals(
            $sampleProgram['programurl'],
            $program->getProgramUrl(),
            'Program url should be set'
        );
        $this->assertEquals(
            $sampleProgram['programimage'],
            $program->getProgramImage(),
            'Program image should be set'
        );
        $this->assertEquals(
            $sampleProgram['socialimage'],
            $program->getSocialImage(),
            'Social image should be set'
        );
        $this->assertCount(
            1,
            $program->getSocialMediaPlatforms(),
            '1 social media platform should be set'
        );
        $this->assertEquals(
            $sampleProgram['socialmediaplatforms'][0]['platform'],
            $program->getSocialMediaPlatforms()[0]->getPlatform(),
            'Social media platform should be set'
        );
        $this->assertEquals(
            $sampleProgram['socialmediaplatforms'][0]['platformurl'],
            $program->getSocialMediaPlatforms()[0]->getPlatformUrl(),
            'Social media platform url should be set'
        );
        $this->assertEquals(
            $sampleProgram['channel']['id'],
            $program->getChannel()->getSrId(),
            'Channel id should be set'
        );
        $this->assertEquals(
            $sampleProgram['channel']['name'],
            $program->getChannel()->getName(),
            'Channel name should be set'
        );
    }

    /**
     * Test so data from all pages are fetched
     */
    public function testGetAllProgramsPaginates()
    {
        $client = new SrWebServiceClient($this->restClient, $this->serializer);
        // Fetch page1Data to be able to get the next page's url
        $page1Data = $this->getGetAllProgramsTestDataPage1();
        $page1NextPage = json_decode($page1Data, true)['pagination']['nextpage'];

        $this->restClient->expects($this->at(0))
                         ->method('get')
                         ->willReturn(new Response($page1Data));

        $this->restClient->expects($this->at(1))
                         ->method('get')
            // Should use the next page url
                         ->with($page1NextPage)
                         ->willReturn(new Response($this->getGetAllProgramsTestDataPage2()));

        $programs = $client->getAllPrograms();

        // Test data has a total of 10 entities
        $this->assertCount(10, $programs, 'Total number of found programs shold be 10');
    }

    /**
     * Test so all data from on episodes are correct
     */
    public function testGetAllEpisodesFromProgramDataIsCorrect()
    {
        $sampleData = $this->getGetAllEpisodesSingleTestData();
        $client = new SrWebServiceClient($this->restClient, $this->serializer);
        $programId = 4131;

        $this->restClient->expects($this->once())
                         ->method('get')
                         ->with($this->stringContains('episodes/index?programid='.$programId))
                         ->willReturn(new Response($this->getGetAllEpisodesSingleTestData()));

        /** @var Episode[] $episodes (just for the autocompletion :) ) */
        $episodes = $client->getAllEpisodesByProgramId($programId);
        $sampleEpisode = json_decode($sampleData, true)['episodes'][0];

        $this->doAssertionsForEpisode($sampleEpisode, $episodes[0]);
    }

    // FYI no need to test the get all episodes for pagination - it uses the same thing ass get all programs

    /**
     * Tests the search method
     */
    public function testSearchEpisode()
    {
        $sampleData = [];
        $client = new SrWebServiceClient($this->restClient, $this->serializer);
        $searchTerm = "intstitutet";

        $this->restClient->expects($this->once())
            ->method('get')
            ->with(
                $this->logicalAnd(
                    $this->stringContains('episodes/search'),
                    $this->stringContains('query='.$searchTerm),
                    $this->stringContains('page=1'),
                    $this->stringContains('format=json')
                )
            )
            ->willReturn(new Response($this->getEpisodesSearchTestData()));

        $episodes = $client->searchForEpisode($searchTerm);
        $sampleEpisode = json_decode($this->getEpisodesSearchTestData(), true)['episodes'][0];

        $this->doAssertionsForEpisode($sampleEpisode, $episodes->getEntities()[0]);
    }

    /**
     * Test get single episode method
     */
    public function testGetEpisode()
    {
        $client = new SrWebServiceClient($this->restClient, $this->serializer);
        $episodeTestData = $this->getGetEpisodeTestData();

        $this->restClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('episodes/get?id'))
            ->willReturn(new Response($episodeTestData));

        $episode = $client->getEpisode(42);
        $sampleEpisode = json_decode($episodeTestData, true)['episode'];

        $this->doAssertionsForEpisode($sampleEpisode, $episode);
    }

    /**
     * @expectedException \AppBundle\WebService\SR\Exceptions\InvalidEpisodeException
     */
    public function testGetEpisodeNotFound()
    {
        $client = new SrWebServiceClient($this->restClient, $this->serializer);

        $this->restClient->expects($this->once())
            ->method('get')
            ->willReturn(new Response('', 404));

        $client->getEpisode(42);
    }

    /**
     * Test get playlist by episode id method
     */
    public function testGetEpisodePlaylist()
    {
        $client = new SrWebServiceClient($this->restClient, $this->serializer);
        $sampleData = $this->getEpisodePlaylistTestData();

        $this->restClient->expects($this->once())
            ->method('get')
            ->with($this->stringContains('playlists/getplaylistbyepisodeid?id='))
            ->willReturn(new Response($sampleData));

        $songs = $client->getEpisodePlaylist(42);
        $firstSampleSong = json_decode($sampleData, true)['song'][0];

        // Just check the first item - the others shold be ok too
        $this->assertEquals(
            $firstSampleSong['title'],
            $songs[0]->getTitle(),
            'Title should be set'
        );
        $this->assertEquals(
            $firstSampleSong['description'],
            $songs[0]->getDescription(),
            'Description should be set'
        );
        $this->assertEquals(
            $firstSampleSong['artist'],
            $songs[0]->getArtist(),
            'Artist should be set'
        );
        $this->assertEquals(
            $firstSampleSong['composer'],
            $songs[0]->getComposer(),
            'Composer should be set'
        );
        $this->assertEquals(
            $firstSampleSong['recordlabel'],
            $songs[0]->getRecordLabel(),
            'Record label should be set'
        );
        $this->assertEquals(
            $firstSampleSong['lyricist'],
            $songs[0]->getLyricist(),
            'Lyricist should be set'
        );
    }

    /**
     * @expectedException \AppBundle\WebService\SR\Exceptions\InvalidEpisodeException
     */
    public function testGetEpisodePlaylistEpisodeNotFound()
    {
        $client = new SrWebServiceClient($this->restClient, $this->serializer);

        $this->restClient->expects($this->once())
                         ->method('get')
                         ->willReturn(new Response('', 404));

        $client->getEpisodePlaylist(42);
    }

    /**
     * Check all the data in an episode
     *
     * @param array $sampleEpisode
     * @param Episode $episode
     */
    protected function doAssertionsForEpisode(array $sampleEpisode, Episode $episode)
    {
        $this->assertEquals(
            $sampleEpisode['id'],
            $episode->getSrId(),
            'Id should be set'
        );
        $this->assertEquals(
            $sampleEpisode['title'],
            $episode->getTitle(),
            'Title should be set'
        );
        $this->assertEquals(
            $sampleEpisode['description'],
            $episode->getDescription(),
            'Description should be set'
        );
        $this->assertEquals(
            $sampleEpisode['url'],
            $episode->getWebUrl(),
            'Web url should be set'
        );
        $this->assertEquals(
            $sampleEpisode['program']['id'],
            $episode->getProgram()->getSrId(),
            'Program id should be set'
        );
        $this->assertEquals(
            $sampleEpisode['program']['name'],
            $episode->getProgram()->getName(),
            'Program name should be set'
        );

        // Date looks weird af when it comes from the api
        $publishTimestampMilliseconds = ((int)$episode->getPublishDateUtc()->format('U')) * 1000;
        $this->assertEquals(
            $sampleEpisode['publishdateutc'],
            "/Date({$publishTimestampMilliseconds})/",
            'Publish date should be set'
        );
        $this->assertEquals(
            $sampleEpisode['imageurltemplate'],
            $episode->getImageUrl(),
            'Image url should be set'
        );

        $this->assertEquals(
            $sampleEpisode['downloadpodfile']['title'],
            $episode->getDownloadPodFile()->getTitle(),
            "Download pod file title should be set"
        );
        $this->assertEquals(
            $sampleEpisode['downloadpodfile']['description'],
            $episode->getDownloadPodFile()->getDescription(),
            "Download pod file description should be set"
        );
        $this->assertEquals(
            $sampleEpisode['downloadpodfile']['filesizeinbytes'],
            $episode->getDownloadPodFile()->getFileSizeInBytes(),
            "Download pod file size should be set"
        );
        $this->assertEquals(
            $sampleEpisode['downloadpodfile']['duration'],
            $episode->getDownloadPodFile()->getDuration(),
            "Download pod file duration should be set"
        );
        $this->assertEquals(
            $sampleEpisode['downloadpodfile']['url'],
            $episode->getDownloadPodFile()->getUrl(),
            "Download pod file url should be set"
        );

        // Date looks weird af when it comes from the api
        $podPublishTimestampMilliseconds = ((int)$episode->getDownloadPodFile()->getPublishDateUtc()->format('U')) * 1000;
        $this->assertEquals(
            $sampleEpisode['downloadpodfile']['publishdateutc'],
            "/Date($podPublishTimestampMilliseconds)/",
            "Download pod file date should be set"
        );
    }

    /**
     * Get sample response with 1 program to check the data in
     *
     * @return string
     */
    protected function getGetAllProgramsSingleTestData() : string
    {
        return file_get_contents(__DIR__.'/response_test_data/programs_index-single.json');
    }

    /**
     * Get sample response with pagination (page 1)
     *
     * @return string
     */
    protected function getGetAllProgramsTestDataPage1() : string
    {
        return file_get_contents(__DIR__.'/response_test_data/programs_index-paginated-1.json');
    }

    /**
     * Get sample response with pagination (page 2)
     *
     * @return string
     */
    protected function getGetAllProgramsTestDataPage2() : string
    {
        return file_get_contents(__DIR__.'/response_test_data/programs_index-paginated-2.json');
    }

    protected function getGetAllEpisodesSingleTestData() : string
    {
        return file_get_contents(__DIR__.'/response_test_data/episodes_index-single.json');
    }

    /**
     * Get a sample search response
     *
     * @return string
     */
    protected function getEpisodesSearchTestData() : string
    {
        return file_get_contents(__DIR__.'/response_test_data/episodes_search.json');
    }

    protected function getGetEpisodeTestData() : string
    {
        return file_get_contents(__DIR__.'/response_test_data/episodes_get.json');
    }

    /**
     * Get sample test response when getting episode playlist
     *
     * @return string
     */
    protected function getEpisodePlaylistTestData() : string
    {
        return file_get_contents(__DIR__.'/response_test_data/playlist_getplaylistbyepisodeid.json');
    }
}
