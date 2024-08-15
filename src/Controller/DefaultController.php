<?php

namespace App\Controller;

use App\Repository\UrunlerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, UrunlerRepository $UrunlerRepository, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $UrunlerRepository->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC'); // Tersine sıralama

        $pagination = $paginator->paginate(
            $queryBuilder, // QueryBuilder
            $request->query->getInt('page', 1), // Current page number
            5 // Limit per page
        );

        return $this->render('default/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/iletisim', name: 'iletisim')]
    public function iletisim()
    {
        return $this->render('default/iletisim.html.twig');
    }
    #[Route('/hakkinda', name: 'hakkinda')]
    public function hakkinda()
    {
        return $this->render('default/hakkinda.html.twig');
    }
}
