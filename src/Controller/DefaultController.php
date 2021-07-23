<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of DefaultController
 *
 * @author CC-Student
 */
class DefaultController extends AbstractController{
    #[Route(
        '/contact',
        name: 'contact',
        condition: "context.getMethod() in ['GET', 'HEAD'] and request.headers.get('User-Agent') matches '/firefox/i'",
    )]
    // expressions can also include config parameters:
    // condition: "request.headers.get('User-Agent') matches '%app.allowed_browsers%'"
    public function contact(): Response
    {
        // ...
    }
}
