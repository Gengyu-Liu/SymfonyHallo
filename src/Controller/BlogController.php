<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BlogController extends AbstractController{
    #[Route('/blog/{page<\d+>?1}', name: 'blog_list')]
    public function list(int $page = 1): Response
    {
       return new Response(
               '<html><body>List methode mit '.$page.'</body></html>'
       );
    }
    
    #[Route('/blog/{start}/{end}', name: 'blog_diff')]
    #[ParamConverter('start', options: ['format' => '!Y-m-d'])]
    #[ParamConverter('end', options: ['format' => '!Y-m-d'])]
    public function diff(\DateTime $start, \DateTime $end): Response
    {
        // $slug will equal the dynamic part of the URL
        // e.g. at /blog/yay-routing, then $slug='yay-routing'
        $interval = $start->diff($end);
        $diffstr = $interval->format('%R%a days');
        return new response(
               '<html><body>show methode mit '.$diffstr.'</body></html>'
       );
        
    }
}
