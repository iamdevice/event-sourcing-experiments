<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 19:25
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User\Handler;

use App\EventSourcing\Model\User\Command\ChangeUserName;
use App\EventSourcing\Model\User\Exception\UserNotFound;
use App\EventSourcing\Model\User\User;
use App\EventSourcing\Model\User\UserCollection;

class ChangeUserNameHandler
{
    /**
     * @var \App\EventSourcing\Model\User\UserCollection $userCollection
     */
    private $userCollection;

    public function __construct(UserCollection $userCollection)
    {
        $this->userCollection = $userCollection;
    }

    public function __invoke(ChangeUserName $command): void
    {
        $user = $this->userCollection->get($command->userId());

        if (false === $user instanceof User) {
            throw UserNotFound::create();
        }

        $user->changeName($command->name());
        $this->userCollection->save($user);
    }
}
