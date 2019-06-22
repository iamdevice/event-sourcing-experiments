<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 19:22
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User\Command;

use App\EventSourcing\Model\User\UserId;
use App\EventSourcing\Model\User\UserName;
use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

final class ChangeUserName extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function withData(string $userId, string $name)
    {
        return new self([
            'user_id' => $userId,
            'name' => $name,
        ]);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->payload['user_id']);
    }

    public function name(): UserName
    {
        return UserName::fromString($this->payload['name']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'user_id');
        Assertion::uuid($payload['user_id']);
        Assertion::keyExists($payload, 'name');
        Assertion::string($payload['name']);

        $this->payload = $payload;
    }
}
