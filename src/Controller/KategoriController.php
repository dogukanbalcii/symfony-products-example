<?php

namespace App\Controller;

use App\Entity\UrunKategori;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class KategoriController extends AbstractController
{
    #[Route('/urunler/kategori-ekle', name: 'kategori_ekle')]
    public function kategoriEkle(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator,AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_EDITOR')) {
            return $this->redirectToRoute('index');
        }

        $page = $request->query->getInt('page', 1);
        $limit = 5;

        $kategoriRepository = $entityManager->getRepository(UrunKategori::class);

        $query = $kategoriRepository->createQueryBuilder('k')
            ->orderBy('k.id', 'DESC')
            ->getQuery();

        $kategoriler = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        if ($request->isMethod('POST')) {
            $isim = $request->request->get('isim');

            $kategori = new UrunKategori();
            $kategori->setIsim($isim);

            $entityManager->persist($kategori);
            $entityManager->flush();

            return $this->redirectToRoute('kategori_ekle');
        }

        return $this->render('urunler/kategori_ekle.html.twig', [
            'kategoriler' => $kategoriler,
        ]);
    }

    #[Route('/urunler/kategori-sil/{id}', name: 'kategori_sil')]
    public function kategoriSil(int $id, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_EDITOR')) {
            return $this->redirectToRoute('index');
        }

        $kategoriRepository = $entityManager->getRepository(UrunKategori::class);
        $kategori = $kategoriRepository->find($id);

        if (!$kategori) {
            throw $this->createNotFoundException('Kategori bulunamadı');
        }

        // Kategoriye bağlı ürün sayısını kontrol et
        $urunlerSayisi = $kategori->getKategori()->count();

        if ($urunlerSayisi > 0) {
            $message = sprintf('%d Adet bu veri kullanılıyor, silemezsiniz', $urunlerSayisi);
            $this->addFlash('error', $message);
            return $this->redirectToRoute('kategori_ekle');
        }

        $entityManager->remove($kategori);
        $entityManager->flush();

        return $this->redirectToRoute('kategori_ekle');
    }

    #[Route('/urunler/kategori-duzenle/{id}', name: 'kategori_duzenle', methods: ['POST', 'PUT'])]
    public function kategoriDuzenle(int $id, Request $request, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_EDITOR')) {
            return $this->redirectToRoute('index');
        }
        $kategoriRepository = $entityManager->getRepository(UrunKategori::class);
        $kategori = $kategoriRepository->find($id);

        if (!$kategori) {
            throw $this->createNotFoundException('Kategori bulunamadı');
        }

        if ($request->isMethod('POST') || $request->isMethod('PUT')) {
            $isim = $request->request->get('isim');
            $kategori->setIsim($isim);

            $entityManager->flush();

            return $this->redirectToRoute('kategori_ekle');
        }

        return $this->render('urunler/kategori_duzenle.html.twig', [
            'kategori' => $kategori,
        ]);
    }
}
