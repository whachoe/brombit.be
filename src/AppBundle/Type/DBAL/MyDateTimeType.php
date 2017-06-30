<?php
/**
 * Created by PhpStorm.
 * User: cjpa
 * Date: 30/06/2017
 * Time: 22:44
 */

namespace AppBundle\Type\DBAL;

use AppBundle\Type\MyDateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class MyDateTimeType extends DateTimeType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        if ( ! $dateTime) {
            return $dateTime;
        }

        return new MyDateTime('@' . $dateTime->format('U'));
    }

    public function getName()
    {
        return 'mydatetime';
    }
}