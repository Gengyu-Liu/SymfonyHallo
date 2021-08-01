<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
/**
 * This controller produces a random number and shows it using the template lucky/number.html.twig 
 * index function generates a link to number function
 */

class LuckyController extends AbstractController
{
    #[Route('/lucky/number', name:'lucky_number')]
    public function number():Response {
        $number = random_int(0, 100);
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
}

