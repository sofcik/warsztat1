<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class TestIncludeHandler implements RequestHandlerInterface
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
            'app::test-include',
            $this->prepareTestData($request) // parameters to pass to template
        ));
    }

    protected function prepareTestData(ServerRequestInterface $request)
    {
        $data = [
            'content1' => ''
        ];

        // comment pipeline.php ErrorHandler
        ini_set('display_errors', '1');
        ob_start();

        echo "\n current dir: " . getcwd();
        echo "\n current include_path " . get_include_path();

        include 'include_me_1.php';

        //include 'public/include_me_1.php'; // wywalić z katalogu

        include 'public/subdir/include_me_2.php';

        $data['content1'] = nl2br(ob_get_clean());

        return $data;
    }
}
