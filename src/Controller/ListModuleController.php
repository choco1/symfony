<?php

namespace App\Controller;


use App\Entity\HistoricFonctionModule;
use App\Entity\Module;
use App\Entity\TypeModule;
use App\Form\NewModuleType;
use App\Repository\ConnectionRepository;
use App\Repository\ModuleRepository;
use App\Repository\PowerSupplyRepository;
use App\Repository\SensorRepository;
use App\Repository\TypeModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListModuleController extends AbstractController
{


    /**
     * @Route("/etat/{id}", name="etat_fonction")
     */
    public function etatFonction($id, Request $request , Module $module,ModuleRepository $moduleRepository){

        $em = $this->getDoctrine()->getManager();

        $moduleRepository = $em->getRepository(Module::class)->find($id);
       $recupId = $moduleRepository->getId();

        if($moduleRepository->getFunctionState() == 0){
            $moduleRepository->setFunctionState("1");

            $defected = new HistoricFonctionModule();
            $defected->getModules($recupId);
            $defected->setCommentaire("probleme de dysfonctionnement résolu ✔ : c'etait un disfonctionnment de batterie");
            $number = $defected->getNumber();

            $defected->setNumber(($number + 1));

        }else {

            $moduleRepository->setFunctionState("0");

            $defected = new HistoricFonctionModule();
            $defected->getModules($recupId);
            $defected->setName("probleme de fonctionnement est detecté ❌ !!!! : verifiez le périphérique de connexion");
            $number = $defected->getNumber();
            $defected->setNumber(($number + 1));


        }

        $em->flush();


        $this->addFlash('success', 'Votre Module fonctionne maintenent ');

        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }


    /**
     * @Route("/connex/{id}", name="etat_connex")
     */
    public function etatConex($id, Request $request, Module $module,ModuleRepository $moduleRepository){


        $em = $this->getDoctrine()->getManager();

        $moduleRepository = $em->getRepository(Module::class)->find($id);

        if ($moduleRepository->getEtatConnex() == 0) {

            $moduleRepository->setEtatConnex("1");
        }else {
            $moduleRepository->setEtatConnex("0");
        }

        $em->flush();

       $referer = $request->headers->get('referer');

        $this->addFlash('success', 'Changement effectué ');
        return $this->redirect($referer);

    }





    /**
     * @param $id
     * @param Module $module
     * @param ModuleRepository $moduleRepository
     * @return Response
     * @Route("/module/{id}", name="single_module")
     */

    public function singleModule($id, Module $module,ModuleRepository $moduleRepository ): Response {


        $moduleRepository = $this->getDoctrine()->getRepository(Module::class);


        $totalModule = $moduleRepository->filterConnex();

        return  $this->render('list_module/single-module.html.twig', [
            'module' => $module,
            'modules' => $totalModule,
           // 'moduleType' => $typeModules,
        ]);
    }


    /**
     * @Route("/modules", name="list_module")
     * @param $id
     * @param ModuleRepository $moduleRepository
     * @param TypeModuleRepository $typeModuleRepository
     * @param ConnectionRepository $connectionRepository
     * @param PowerSupplyRepository $powerSupplyRepository
     * @param SensorRepository $sensorRepository
     * @return Response
     */
    public function list( Request $request, ModuleRepository $moduleRepository, TypeModuleRepository $typeModuleRepository, ConnectionRepository $connectionRepository, PowerSupplyRepository $powerSupplyRepository, SensorRepository $sensorRepository): Response
    {
        $idUrl = $request->query->get('id');
       // dump($idUrl);


        $moduleRepository = $this->getDoctrine()->getRepository(Module::class);

        $module = $moduleRepository->findAll();
        $type = $typeModuleRepository->findAll();
      //  dump($type);

        $connexion = $connectionRepository->findAll();


        //dump($connexion);


        $power = $powerSupplyRepository->findAll();
        $sensor = $sensorRepository->findAll();



        $typeModules = $moduleRepository->findFiltersType($idUrl);
       // dump($typeModules);
        $sensorModules = $moduleRepository->findFiltersSensor($idUrl);
        $connexModules = $moduleRepository->findFiltersConnex($idUrl);
        $powerModules = $moduleRepository->findFiltersPower($idUrl);

//dump($sensorModules);


        return $this->render('list_module/index.html.twig', [
            'modules' => $module,
            'types' => $type,
            'connexions' => $connexion,
            'powers' => $power,
            'sensors' => $sensor,
            'modulesType' => $typeModules,
            'modulesSensor' => $sensorModules,
            'modulesConex' => $connexModules,
            'modulesPower' => $powerModules,

        ]);
    }


    /**
     * @Route("/add", name="add_module")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $module = new Module();
        $form = $this->createForm(NewModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $image = $form->get('image')->getData();
            if($image){
                $file = uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('upload_directory'), $file);
                $module->setImage('image/'.$file);
            }else {
                $module->setImage('default.jpg');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            $this->addFlash('success', 'Votre Module '.$module->getName().' a bien été ajoutée');

            return $this->redirectToRoute('list_module');
        }

        return $this->render('list_module/add-module.html.twig', [
            'addModule' => $form->createView(),
        ]);
    }


    /**
     * @return Response
     * @Route("/moduleKo", name="module_ko")
     */
    public function moduleKo(Request $request, ModuleRepository $repoModules, TypeModuleRepository $type): Response {

        $repoModules = $this->getDoctrine()->getRepository(Module::class);
        $moduleKo = $repoModules->moduleKo();
dump($moduleKo);


        return $this->render('list_module/module_ko.html.twig', [
          //  'testModules' => $testConex,
            'modulesKo' => $moduleKo,



        ]);
    }
}
