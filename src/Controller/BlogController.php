<?php
/**
 * Route Parameters and their validation
 * Getting the Route Name and Parameters from Request Object
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController{
    #[Route('/{page<\d+>?1}', name: 'list')]
    public function list(int $page, Request $request): Response
    {
//        $routeName = $request->attributes->get('_route');
//        $routeParameters = $request->attributes->get('_route_params');
//        // use this to get all the available attributes (not only routing ones):
//        $allAttributes = $request->attributes->all();

        
        return $this->render('blog/list.html.twig', [
            'page' => $page,
        ]);
//        return new Response(
//               '<html><body>List methode mit '.$page.'</body></html>'
//       );
    }
    
    #[Route('/{start}/{end}', name: 'diff')]
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
