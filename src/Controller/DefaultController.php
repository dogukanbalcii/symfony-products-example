<?php

namespace App\Controller;

use App\Entity\UrunKategori;
use App\Repository\UrunlerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UrunlerRepository $UrunlerRepository): Response
    {
        $urunler = $UrunlerRepository->findAll();
        return $this->render('default/index.html.twig', [
            'urunler' => $urunler,
        ]);
    }
}
