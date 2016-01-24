<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Exception;

class NoTracksFoundException extends \Exception
{
    public static function emptyResult()
    {
        return new static('No tracks found');
    }
}
