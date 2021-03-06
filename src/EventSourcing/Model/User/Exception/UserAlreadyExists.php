<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 16:08
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User\Exception;

use DomainException;

class UserAlreadyExists extends DomainException
{
    public static function create(): UserAlreadyExists
    {
        return new self('User already exists');
    }
}
