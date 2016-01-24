<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Exceptions;

class InvalidEpisodeException extends \Exception
{
    public static function notFound(int $id)
    {
        return new static("Episode with id #$id does not exest");
    }
}
