<?php

namespace App\Controller;

use App\Entity\Urunler;
use App\Form\UrunType;
use App\Repository\UrunlerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrunlerController extends AbstractController
{
    private UrunlerRepository $urunlerRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UrunlerRepository $urunlerRepository, EntityManagerInterface $entityManager)
    {
        $this->urunlerRepository = $urunlerRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/urunler', name: 'urun_listesi')]
    public function index(Request $request): Response
    {
        // Veritabanından ürünleri çek
        $urunler = $this->urunlerRepository->findAll();

        // Yeni ürün ekleme formu oluştur
        $urun = new Urunler();
        $form = $this->createForm(UrunType::class, $urun);

        // Formu işleme
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Yeni ürünü veritabanına kaydet
            $this->entityManager->persist($urun);
            $this->entityManager->flush();

            // Ürün eklendikten sonra sayfayı yenile
            return $this->redirectToRoute('urun_listesi');
        }

        // Her ürün için düzenleme ve silme formunu oluştur
        $editForms = [];
        $deleteForms = [];
        foreach ($urunler as $urun) {
            $editForms[$urun->getId()] = $this->createForm(UrunType::class, $urun)->createView();

            // Silme formunu oluştur
            $deleteForms[$urun->getId()] = $this->createFormBuilder()
                ->setAction($this->generateUrl('urun_sil', ['id' => $urun->getId()]))
                ->setMethod('DELETE')
                ->getForm()
                ->createView();
        }

        // Twig şablonunu render et
        return $this->render('urunler/urun_list.html.twig', [
            'urunler' => $urunler,
            'form' => $form->createView(),
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ]);
    }

    #[Route('/urun/sil/{id}', name: 'urun_sil', methods: ['POST'])]
    public function sil(Urunler $urun): Response
    {
        // Ürünü veritabanından sil
        $this->entityManager->remove($urun);
        $this->entityManager->flush();

        // Ürün silindikten sonra sayfayı yenile
        return $this->redirectToRoute('urun_listesi');
    }
    #[Route('/urun/duzenle/{id}', name: 'urun_duzenle')]
    public function duzenle(Request $request, Urunler $urun): Response
    {
        $form = $this->createForm(UrunType::class, $urun);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('urun_listesi');
        }

        return $this->render('urunler/urun_duzenle.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}

