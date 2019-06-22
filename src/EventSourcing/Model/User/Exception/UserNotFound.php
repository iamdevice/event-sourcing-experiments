<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 19:26
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User\Exception;

use DomainException;

class UserNotFound extends DomainException
{
    public static function create(): UserNotFound
    {
        return new self('User not found');
    }
}
