<?php

namespace App\Controller;

use App\Entity\UrunKategori;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class KategoriController extends AbstractController
{

    #[Route('/urunler/kategori-ekle', name: 'kategori_ekle')]
    public function kategoriEkle(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        // Sayfa numarasını ve sayfa başına gösterilecek veri sayısını alın
        $page = $request->query->getInt('page', 1); // varsayılan olarak 1
        $limit = 5;

        // Kategori repository'sini al
        $kategoriRepository = $entityManager->getRepository(UrunKategori::class);

        // Kategorileri al ve sayfalandır
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

            // Kategori nesnesi oluşturma
            $kategori = new UrunKategori();
            $kategori->setIsim($isim);

            // Kategoriyi veritabanına ekleme
            $entityManager->persist($kategori);
            $entityManager->flush();

            return $this->redirectToRoute('kategori_ekle');
        }

        // Twig şablonuna veri geçirme
        return $this->render('urunler/kategori_ekle.html.twig', [
            'kategoriler' => $kategoriler,
        ]);
    }

    #[Route('/urunler/kategori-sil/{id}', name: 'kategori_sil')]
    public function kategoriSil(int $id, EntityManagerInterface $entityManager): Response
    {
        // Kategori silme işlemi
        $kategoriRepository = $entityManager->getRepository(UrunKategori::class);
        $kategori = $kategoriRepository->find($id);

        if ($kategori) {
            $entityManager->remove($kategori);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kategori_ekle');
    }

    #[Route('/urunler/kategori-duzenle/{id}', name: 'kategori_duzenle', methods: ['POST', 'PUT'])]
    public function kategoriDuzenle(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Kategori verisini al
        $kategoriRepository = $entityManager->getRepository(UrunKategori::class);
        $kategori = $kategoriRepository->find($id);

        if (!$kategori) {
            throw $this->createNotFoundException('Kategori bulunamadı');
        }

        if ($request->isMethod('POST') || $request->isMethod('PUT')) {
            $isim = $request->request->get('isim');
            $kategori->setIsim($isim);

            // Değişiklikleri veritabanına kaydetme
            $entityManager->flush();

            return $this->redirectToRoute('kategori_ekle');
        }

        // Kategori formunu render et
        return $this->render('urunler/kategori_duzenle.html.twig', [
            'kategori' => $kategori,
        ]);
    }
}
