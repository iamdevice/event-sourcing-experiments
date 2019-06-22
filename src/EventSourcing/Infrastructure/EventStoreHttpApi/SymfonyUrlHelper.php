<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 20:44
 */

namespace App\EventSourcing\Infrastructure\EventStoreHttpApi;

use Prooph\EventStore\Http\Middleware\UrlHelper;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SymfonyUrlHelper implements UrlHelper
{
    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
     */
    private $urlGenerator;

    /**
     * SymfonyUrlHelper constructor.
     *
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generate(string $urlId, array $params = []): string
    {
        return $this->urlGenerator->generate($urlId, $params);
    }
}
