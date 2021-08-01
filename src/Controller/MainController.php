<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
/**
 * subdomain routing
 */
class MainController extends AbstractController
{
    #[Route(
                '/',
                name: 'mobile_homepage',
                host: '{subdomain}.example.com',
                defaults: ['subdomain' => 'm'],
                requirements: ['subdomain' => 'm|mobile'],
        )]
    public function mobileHomepage(): Response{
        $homePage = $this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL);
        return $this->render('home.html.twig', [
            'url' => $homePage,
            'pageName' => 'homepage',
            'method' => 'mobile_homepage', 
        ]);
        
    }

    #[Route(
                '/',
                name: 'homepage',
                host: 'localhost',
        )]
    public function homepage(): Response
    {
         $homePage = $this->generateUrl('mobile_homepage',[], UrlGeneratorInterface::ABSOLUTE_URL);
         return $this->render('home.html.twig', [
            'url' => $homePage,
            'pageName' => 'mobile_homepage',
            'method' => 'homepage', 
        ]);
    }
}
