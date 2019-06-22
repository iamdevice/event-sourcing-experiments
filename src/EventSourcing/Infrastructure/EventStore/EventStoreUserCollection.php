<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 18:31
 */

declare(strict_types=1);

namespace App\EventSourcing\Infrastructure\EventStore;

use App\EventSourcing\Model\User\User;
use App\EventSourcing\Model\User\UserCollection;
use App\EventSourcing\Model\User\UserId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

class EventStoreUserCollection extends AggregateRepository implements UserCollection
{
    public function save(User $user): void
    {
        $this->saveAggregateRoot($user);
    }

    public function get(UserId $userId): ?User
    {
        return $this->getAggregateRoot((string)$userId);
    }
}
