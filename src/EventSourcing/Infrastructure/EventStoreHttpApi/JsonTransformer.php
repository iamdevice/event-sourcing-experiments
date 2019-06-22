<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 20:33
 */

declare(strict_types=1);

namespace App\EventSourcing\Infrastructure\EventStoreHttpApi;

use Prooph\EventStore\Http\Middleware\Transformer;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

final class JsonTransformer implements Transformer
{
    public function createResponse(array $result): ResponseInterface
    {
        return new JsonResponse($result);
    }
}
