<?php

namespace Neo\Presentation\Controller\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

readonly class HomePageController
{
    public function __construct(private KernelInterface $appKernel)
    {
    }

    public function __invoke(Request $request): Response
    {
        $pathToHomepageHtml = sprintf('%s/%s', $this->appKernel->getProjectDir(), 'resources/homepage.html');
        return new Response(file_get_contents($pathToHomepageHtml));
    }
}
