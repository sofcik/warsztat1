<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class TestAnimalsHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TestAnimalsHandler
    {
        return new TestAnimalsHandler($container->get(TemplateRendererInterface::class));
    }
}
