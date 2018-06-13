<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class TestAnimalsHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    public function __construct(TemplateRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        // Render and return a response:
        return new HtmlResponse($this->renderer->render(
            'app::test-animals',
            $this->prepareTestData($request) // parameters to pass to template
        ));
    }

    protected function prepareTestData(ServerRequestInterface $request)
    {
        $data = [
            'content2' => '',
            'content3' => ''
        ];
        $params = $request->getQueryParams();
        $data['content2'] = var_export($params, true);


        $animal = 'dog';
        if (array_key_exists('animal', $params)){
            $animal = $params['animal'];
        }
        $classname = '\\OopAnimals\\Species\\' . ucfirst($animal);

        if (class_exists($classname)) {
            $animalObj = new $classname();
            $data['content3'] = $animalObj->getSound();
        } else {
            $data['content3'] = 'Class not found: ' . $classname;
        }

        return $data;
    }
}
