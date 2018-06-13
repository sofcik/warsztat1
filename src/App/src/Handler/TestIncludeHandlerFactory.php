<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class TestIncludeHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TestIncludeHandler
    {
        return new TestIncludeHandler($container->get(TemplateRendererInterface::class));
    }
}
