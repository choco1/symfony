<?php

namespace App\Controller;


use App\Entity\ConsoBatterie;
use App\Entity\HistoricFonctionModule;
use App\Entity\Module;
use App\Entity\TypeModule;
use App\Form\NewModuleType;
use App\Repository\ConnectionRepository;
use App\Repository\ConsoBatterieRepository;
use App\Repository\HistoricFonctionModuleRepository;
use App\Repository\ModuleRepository;
use App\Repository\PowerSupplyRepository;
use App\Repository\SensorRepository;
use App\Repository\TypeModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
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
        dump($moduleRepository->getHistoric());

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

    public function singleModule($id, HistoricFonctionModuleRepository $fonctionModuleRepository, Module $module,ModuleRepository $moduleRepository, ConsoBatterieRepository $batterieRepository): Response {

        $tableDate = [];
        $date = [];
        $etatTempMin= [];
        $etatTempMax= [];
        $nameEtat= [] ;
        $valueEtat= [] ;
        $modeConnex = [];
        $connexName = [];
        $connexColor = [];
        $connexPercent = [];



        $temperatures = $module->getHistoricTemperature();



        foreach ($temperatures as $temperature){



            $etatTempMax[] = $temperature->getTempMax();
            $etatTempMin[] = $temperature->getTempMin();
            $date[] =$temperature->getDate()->format('Y-m-d H:i:s');
        }





//        dump($etatTempMax);
//
//        dump($etatTempMax);
//        dump($date);

       $values = $module->getHistoric();

       foreach ($values as $value){

           dump($value->getName());
           dump($value->getNumber());

           $nameEtat[] = $value->getName();
           $valueEtat[] = $value->getNumber();
       }
          // dump($nameEtat);
            //dump($valueEtat);


        $moduleRepository = $this->getDoctrine()->getRepository(Module::class);

        $list =$module->getConnection();


        foreach ($list as $item){
            $connexName[] = $item->getTypeConnex();
            $batterie = $batterieRepository->findOneBy( [ 'nameConnex' => $item->getTypeConnex()]);
            $modeConnex[] = $batterie;
            $connexColor[] = $batterie->getCodeColor();
            $connexPercent[] = $batterie->getPourcentage();
        }


        $totalModule = $moduleRepository->filterConnex();

        return  $this->render('list_module/single-module.html.twig', [
            'module' => $module,
            'modules' => $totalModule,
           'modeConnex' => $modeConnex,
           /*-------------------------------------------*/
           'connexName' => json_encode($connexName),
           'connexColor' => json_encode($connexColor),
           'connexPercent' => json_encode($connexPercent),
           'nameEtat' => json_encode($nameEtat),
           'valueEtat' => json_encode($valueEtat),
           'etatTempMax' => json_encode($etatTempMax),
           'etatTempMin' => json_encode($etatTempMin),
           'date' => json_encode($date),
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

        $moduleRepository = $this->getDoctrine()->getRepository(Module::class);


        $module = $moduleRepository->findAll();
        $type = $typeModuleRepository->findAll();

      //  dump($type);

        $connexion = $connectionRepository->findAll();
        //dump($connexion);

        $power = $powerSupplyRepository->findAll();
        $sensor = $sensorRepository->findAll();


        $typeModules = null;
        if(!empty($request->get('type'))){

            $typeModules = $moduleRepository->findFiltersType($request->get('type'));
            $module = null;
        }

        $sensorModules = null;
        if(!empty($request->get('sensor'))){
            $sensorModules = $moduleRepository->findFiltersSensor($request->get('sensor'));
            $module = null;
        }

        $connexModules = null;
        if(!empty($request->get('connection'))){
            $connexModules = $moduleRepository->findFiltersConnex($request->get('connection'));
            $module = null;
        }

        $powerModules = null;
        if(!empty($request->get('power'))){
            $powerModules = $moduleRepository->findFiltersPower($request->get('power'));
            $module = null;
        }

        dump($request);





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
        // On faite le traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $image = $form->get('image')->getData();
            if($image){
                $file = uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('upload_directory'), $file);
                $module->setImage($file);
            }else {
                $module->setImage('fixtures/default.jpg');
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
     * @Route("/modules/delete/{id}", name="delete_module")
     */
    public function delete(Module $module){

        // Pour supprimer avec Doctrine
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($module);
        $entityManager->flush(); // DELETE FROM

        $this->addFlash('danger', 'Votre Module a bien été supprimée');

        return $this->redirectToRoute('list_module');
    }


    /**
     * @return Response
     * @Route("/modules/edit/{id}", name="edit_module")
     */
    public function edit(Request $request, Module $module){


        $form = $this->createForm(NewModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if($image) {

                $allImage = ['default.jpg', 'fixtures/cam.jpg', 'fixtures/car.jpg', 'fixtures/four.jpg', 'fixtures/moto.jpg', 'fixtures/swatch.jpg', 'fixtures/tv.jpg', 'fixtures/iotcam.jpg', 'fixtures/iot1.png', 'fixtures/iot2.jpg', 'fixtures/gri.jpg', 'fixtures/vols.jpg', 'fixtures/iot4.jpg'];
                if ($module->getImage() && !in_array($module->getImage(), $allImage)) {
                    $fileSecond = new Filesystem();
                    $fileSecond->remove($this->getParameter('upload_directory') . '/' . $module->getImage());
                }

                $file = uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('upload_directory'), $file);
                $module->setImage($file);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre Module a bien été modifiée');

            return $this->redirectToRoute('list_module');
        }

        return $this->render('list_module/edit.html.twig', [
            'editModule' => $form->createView(),
            'modules' => $module,
        ]);
    }




    /**
     * @return Response
     * @Route("/moduleKo", name="module_ko")
     */
    public function moduleKo(Request $request, ModuleRepository $repoModules, TypeModuleRepository $type): Response {

        $repoModules = $this->getDoctrine()->getRepository(Module::class);
        $moduleKo = $repoModules->moduleKo();
        //dump($moduleKo);


        return $this->render('list_module/module_ko.html.twig', [
          //  'testModules' => $testConex,
            'modulesKo' => $moduleKo,



        ]);
    }
}
