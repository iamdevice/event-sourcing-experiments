<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 16:03
 */

namespace App\EventSourcing\Model\User\Handler;

use App\EventSourcing\Model\User\Command\CreateUser;
use App\EventSourcing\Model\User\Exception\UserAlreadyExists;
use App\EventSourcing\Model\User\User;
use App\EventSourcing\Model\User\UserCollection;

class CreateUserHandler
{
    /**
     * @var \App\EventSourcing\Model\User\UserCollection $userCollection
     */
    private $userCollection;

    public function __construct(UserCollection $userCollection)
    {
        $this->userCollection = $userCollection;
    }

    public function __invoke(CreateUser $command): void
    {
        if ($this->userCollection->get($command->userId()) instanceof User) {
            throw UserAlreadyExists::create();
        }

        $user = User::createWithData($command->userId(), $command->name());
        $this->userCollection->save($user);
    }
}
