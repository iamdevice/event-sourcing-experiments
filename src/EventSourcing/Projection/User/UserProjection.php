<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 18:36
 */

declare(strict_types=1);

namespace App\EventSourcing\Projection\User;

use App\EventSourcing\Model\User\Event\UserWasChangedName;
use App\EventSourcing\Model\User\Event\UserWasCreated;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

final class UserProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('event_stream')
            ->when([
                UserWasCreated::class => function ($state, UserWasCreated $event) {
                    /** @var \App\EventSourcing\Projection\User\UserReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', $event);
                },
                UserWasChangedName::class => function ($state, UserWasChangedName $event) {
                    /** @var \App\EventSourcing\Projection\User\UserReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('updateName', $event);
                }
            ]);

        return $projector;
    }
}
