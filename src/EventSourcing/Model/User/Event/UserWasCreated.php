<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 15:51
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User\Event;

use App\EventSourcing\Model\User\UserId;
use App\EventSourcing\Model\User\UserName;
use Prooph\EventSourcing\AggregateChanged;

final class UserWasCreated extends AggregateChanged
{
    /**
     * @var \App\EventSourcing\Model\User\UserId $userId
     */
    private $userId;

    /**
     * @var \App\EventSourcing\Model\User\UserName $userName
     */
    private $userName;

    public static function withData(UserId $userId, UserName $userName): UserWasCreated
    {
        $event = self::occur((string)$userId, [
            'name' => (string)$userName
        ]);

        $event->userId = $userId;
        $event->userName = $userName;

        return $event;
    }

    public function userId(): UserId
    {
        if (null === $this->userId) {
            $this->userId = UserId::fromString($this->aggregateId());
        }

        return $this->userId;
    }

    public function userName(): UserName
    {
        if (null === $this->userName) {
            $this->userName = UserName::fromString($this->payload['name']);
        }

        return $this->userName;
    }
}
