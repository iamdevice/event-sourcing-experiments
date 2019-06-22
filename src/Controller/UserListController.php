<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 21:08
 */

namespace App\Controller;

use App\EventSourcing\Projection\User\UserFinder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserListController
{
    /**
     * @var \App\EventSourcing\Projection\User\UserFinder $userFinder
     */
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function listAction(Request $request): Response
    {
        $users = $this->userFinder->findAll();

        return new JsonResponse($users);
    }
}
