<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class TestPageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TestPageHandler
    {
        return new TestPageHandler($container->get(TemplateRendererInterface::class));
    }
}
