<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Client\RabbitMqClient;
use App\Client\WebScrapper;
use App\Command\GetArticleCommand;

class ArticleController extends AbstractController
{
    
    #[Route('/articles', name: 'app_article')]
    public function index(Request $request,ArticleRepository 
    $articleRepository,PaginatorInterface $paginator): Response
    {
        $articles = $articleRepository->findAll();
        $articles = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
        ]);
    }

       
    #[Route('/test', name: 'test')]
    public function test( ): Response
    {
     

    }


}
