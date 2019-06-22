<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 18:34
 */

namespace App\EventSourcing\Projection\User;

use App\EventSourcing\Infrastructure\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;

class UserFinder
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository $userRepository
     */
    private $userRepository;

    public function __construct(ObjectRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function findById(string $userId): ?User
    {
        return $this->userRepository->find($userId);
    }
}
