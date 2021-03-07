<?php

namespace App\Controller;

use App\Entity\HomePage;
use App\Entity\Module;
use App\Entity\Partner;
use App\Repository\HomePageRepository;
use App\Repository\ModuleRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param ModuleRepository $repoModule
     * @return Response
     */
    public function index(HomePageRepository $homePageRepository, PartnerRepository $partnerRepository): Response
    {
        $partnerRepository = $this->getDoctrine()->getRepository(Partner::class);
        $homePageRepository = $this->getDoctrine()->getRepository(HomePage::class);
        $cards = $homePageRepository->filtreCartsHomePage();
        $carousel1 = $partnerRepository->filtreCarouselHomePage($i = 1);
        $carousel2 = $partnerRepository->filtreCarouselHomePage($i = 2);
        $carousel3 = $partnerRepository->filtreCarouselHomePage($i = 3);
        $carousel4 = $partnerRepository->filtreCarouselHomePage($i = 4);

//dump($cards);
        return $this->render('home/index.html.twig', [
            'cards' => $cards,
            'carousels1' => $carousel1,
            'carousels2' => $carousel2,
            'carousels3' => $carousel3,
            'carousels4' => $carousel4,

        ]);
    }
}
