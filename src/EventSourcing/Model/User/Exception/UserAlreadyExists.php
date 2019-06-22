<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 16:08
 */

namespace App\EventSourcing\Model\User\Exception;

class UserAlreadyExists extends \DomainException
{
    public static function create(): UserAlreadyExists
    {
        return new self('User already exists');
    }
}
