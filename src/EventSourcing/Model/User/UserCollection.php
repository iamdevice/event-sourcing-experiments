<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 16:04
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User;

interface UserCollection
{
    /**
     * Save user
     *
     * @param \App\EventSourcing\Model\User\User $user
     */
    public function save(User $user): void;

    /**
     * Get user by userId
     *
     * @param \App\EventSourcing\Model\User\UserId $userId
     *
     * @return \App\EventSourcing\Model\User\User|null
     */
    public function get(UserId $userId): ?User;
}
