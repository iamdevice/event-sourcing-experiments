<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 19:17
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User\Event;

use App\EventSourcing\Model\User\UserId;
use App\EventSourcing\Model\User\UserName;
use Prooph\EventSourcing\AggregateChanged;

final class UserWasChangedName extends AggregateChanged
{
    /**
     * @var \App\EventSourcing\Model\User\UserId $userId
     */
    private $userId;

    /**
     * @var \App\EventSourcing\Model\User\UserName $oldName
     */
    private $oldName;

    /**
     * @var \App\EventSourcing\Model\User\UserName $newName;
     */
    private $newName;

    public static function withData(UserId $userId, UserName $oldName, UserName $newName): UserWasChangedName
    {
        $event = self::occur($userId->toString(), [
            'old_name' => $oldName->toString(),
            'new_name' => $newName->toString(),
        ]);

        $event->userId = $userId;
        $event->oldName = $oldName;
        $event->newName = $newName;

        return $event;
    }

    public function userId(): UserId
    {
        if (null === $this->userId) {
            $this->userId = UserId::fromString($this->aggregateId());
        }

        return $this->userId;
    }

    public function oldName(): UserName
    {
        if (null === $this->oldName) {
            $this->oldName = UserName::fromString($this->payload['old_name']);
        }

        return $this->oldName;
    }

    public function newName(): UserName
    {
        if (null === $this->newName) {
            $this->newName = UserName::fromString($this->payload['new_name']);
        }

        return $this->newName;
    }
}
