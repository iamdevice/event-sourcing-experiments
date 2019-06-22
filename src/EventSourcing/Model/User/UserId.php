<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 15:42
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserId
{
    private $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Generate entity
     *
     * @return \App\EventSourcing\Model\User\UserId
     * @throws \Exception
     */
    public static function generate(): UserId
    {
        return new self(Uuid::uuid4());
    }

    /**
     * Generate entity from string
     *
     * @param string $userId
     *
     * @return \App\EventSourcing\Model\User\UserId
     */
    public static function fromString(string $userId): UserId
    {
        return new self(Uuid::fromString($userId));
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function toString(): string
    {
        return $this->__toString();
    }
}
