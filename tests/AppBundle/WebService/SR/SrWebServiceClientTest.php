<?php

namespace Tests\AppBundle\WebService\SR;

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
}
