<?php
/**
 * The response object for "programs/index" method
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses;

use AppBundle\WebService\SR\Responses\Entities\Program;

use JMS\Serializer\Annotation as Jms;

class AllProgramsResponse extends PaginatedBaseResponse
{
    /**
     * @var Program[]
     *
     * @Jms\Type("array<AppBundle\WebService\SR\Responses\Entities\Program>")
     */
    private $programs;

    /**
     * Find all programs
     *
     * @return Program[]
     */
    public function getEntities() : array
    {
        return $this->getPrograms();
    }


    /**
     * @return Entities\Program[]
     */
    public function getPrograms() : array
    {
        return $this->programs;
    }

    /**
     * @param Entities\Program[] $programs
     *
     * @return AllProgramsResponse
     */
    public function setPrograms(array $programs) : AllProgramsResponse
    {
        $this->programs = $programs;

        return $this;
    }
}
