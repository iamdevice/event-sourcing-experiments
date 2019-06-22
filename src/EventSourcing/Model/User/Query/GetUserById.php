<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 19:50
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User\Query;

final class GetUserById
{
    /**
     * @var string $userId
     */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
