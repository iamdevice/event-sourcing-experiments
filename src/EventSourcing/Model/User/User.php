<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 15:40
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User;

use RuntimeException;
use App\EventSourcing\Model\User\Event\UserWasChangedName;
use App\EventSourcing\Model\User\Event\UserWasCreated;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use function implode, explode, array_slice, method_exists, get_class;

final class User extends AggregateRoot
{
    /**
     * @var \App\EventSourcing\Model\User\UserId $id
     */
    private $id;

    /**
     * @var \App\EventSourcing\Model\User\UserName $name
     */
    private $name;

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public static function createWithData(
        UserId $id,
        UserName $name
    ): User {
        $new = new self();
        $new->recordThat(UserWasCreated::withData($id, $name));

        return $new;
    }

    public function changeName(UserName $name): void
    {
        $this->recordThat(UserWasChangedName::withData($this->id, $this->name, $name));
    }

    protected function aggregateId(): string
    {
        return $this->id->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);

        if (false === method_exists($this, $handler)) {
            throw new RuntimeException('Missing event handler method');
        }

        $this->{$handler}($event);
    }

    protected function whenUserWasCreated(UserWasCreated $event): void
    {
        $this->id = $event->userId();
        $this->name = $event->userName();
    }

    protected function whenUserWasChangedName(UserWasChangedName $event): void
    {
        $this->id = $event->userId();
        $this->name = $event->newName();
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $event): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($event)), -1));
    }
}
