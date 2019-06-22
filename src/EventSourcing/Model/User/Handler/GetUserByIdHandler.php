<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 19:57
 */

namespace App\EventSourcing\Model\User\Handler;

use App\EventSourcing\Model\User\Query\GetUserById;
use App\EventSourcing\Projection\User\UserFinder;

class GetUserByIdHandler
{
    /**
     * @var \App\EventSourcing\Projection\User\UserFinder $userFinder
     */
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function __invoke(GetUserById $query)
    {
        return $this->userFinder->findById($query->userId());
    }
}
