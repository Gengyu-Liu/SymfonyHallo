<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Psr\Log\LoggerInterface;
/**
 * This controller produces a random number and shows it using the template lucky/number.html.twig 
 * index function generates a link to number function
 */

class LuckyController extends AbstractController
{
    #[Route('/lucky/number', name:'lucky_number')]
    public function number(LoggerInterface $logger):Response {
        $number = random_int(0, 100);
        $logger->info('We are logging!');
        $logger->error('An error occurred');
        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
//        return new Response(
//            '<html><body>Lucky number: '.$number.'</body></html>'
//        );
    }
    #[Route('/lucky/index', name:'lucky_index')]
    public function index():Response{
        $luckyNumberUrl = $this->generateUrl('lucky_number', [], UrlGeneratorInterface::ABSOLUTE_URL);
        return $this->render('lucky/index.html.twig', [
            'luckyNumberUrl' => $luckyNumberUrl,
        ]);
    }
    /**
     * Redirecting in Controller
     */
    #[Route('/lucky/home', name:'lucky_home')]
    public function home():RedirectResponse{
        // redirects to the "homepage" route
        return $this->redirectToRoute('lucky_number');
    }
}

