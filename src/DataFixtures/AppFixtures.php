<?php

namespace App\DataFixtures;

use App\Entity\Connection;
use App\Entity\ConsoBatterie;
use App\Entity\HistoricFonctionModule;
use App\Entity\HomePage;
use App\Entity\Module;
use App\Entity\Partner;
use App\Entity\PowerSupply;
use App\Entity\Sensor;
use App\Entity\TypeModule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create("fr_FR");


        for ($i = 0; $i < 20; $i++ ){

            $carousel = new Partner();
            $carousel->setEntreprise($faker->company);
            $carousel->setLogo($faker->randomElement([
                'partner/alin.png','partner/Bouygues.png','partner/fond.png','partner/ili.png','partner/logo.png','partner/n.png','partner/nant.png','partner/sim.png','partner/sncf.png','partner/soged.png'
            ]));

            $manager->persist($carousel);
        }


        for ($i=0; $i < 10 ; $i++){
            $homePage = new HomePage();
            $homePage->setTitle($faker->domainName);

            //!!!!!!!!!!!:!!!!!!!!!!!!!!!!!!!!
            //ils ont un pb de biblio image de faker alors j'ai fait un tableau
            //  $homePage->setImage($faker->imageUrl(640,480, 'technics'));
            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $homePage->setImage($faker->randomElement(['imageHome/iot.jpg', 'imageHome/iot-11.jpg', 'imageHome/i-o-t.jpg', 'imageHome/iot5.jpg', 'imageHome/iot6.jpg', 'imageHome/iot7.jpg', 'imageHome/iot8.jpg', 'imageHome/iot9.jpg']));
            $homePage->setDescription($faker->text(200));

            $manager->persist($homePage);
        }


        $historics = ['Defected', 'Works', 'Connected', 'Disconnected'];
        foreach ($historics as $key => $historic){
            $historicModule = new HistoricFonctionModule();
            $historicModule->setName($historic);
            $historicModule->setNumber($faker->numberBetween(1, 5));
            $this->addReference('historic-'.$key, $historicModule);

            $manager->persist($historicModule);

        }


        for($i = 0; $i < 5; $i++){

            $type = new TypeModule();
            $type->setType($faker->name);
            $this->addReference('type-'.$i, $type);
            $manager->persist($type);


        }


        for ($i =0; $i < 6; $i++){

            $power = new PowerSupply();
            $power->setTypeOfPower($faker->name);
            $this->addReference('power-'.$i, $power);
            $manager->persist($power);

        }


        $typeCapteurs = ['Temperature', 'Son', 'Mouvement', 'Vision', 'Couleurs', 'Lumière', 'Distance'];
        foreach ($typeCapteurs as $key => $typeCapteur){

            $sensor = new Sensor();
            $sensor->setNameSensor($typeCapteur);
            $this->addReference('sensor-'.$key, $sensor);

            $manager->persist($sensor);
        }


        $typesConnex = ['Wifi', 'Bluetoot', 'Zigbee', 'NFC', 'LoRa', 'Sigfox', 'Z-wave', 'Cellulaire'];
        foreach ($typesConnex as $key => $typeConnex){

            $connex = new Connection();
            $connex->setTypeConnex($typeConnex);
            $this->addReference('connexion-'.$key, $connex);

            $manager->persist($connex);
        }


        foreach ($typesConnex as $key => $typeConnex){

            $modeConnex = new ConsoBatterie();
            $modeConnex->setNameConnex($typeConnex);
            $modeConnex->setPourcentage($faker->numberBetween(1, 5));
            $modeConnex->setCodeColor($faker->hexColor);
            $this->addReference('modeConnex-'.$key, $modeConnex);

            $manager->persist($modeConnex);
        }

        //'#23afe3', '#a7d212', '#ff4241', '#edc214', '#C173D7' ,'#73B4D7', '#5DC8C1', '#0E35B3'

        for ($i =0; $i < 30; $i++){

            $module = new Module();
            $module->setName($faker->name);
            $module->setPrice($faker->numberBetween(300, 2000));
            $module->setDescription($faker->text(70));
            $module->setFunctionState($faker->boolean(70));
            $module->setEtatConnex($faker->boolean(0));
            $module->setNumberSerie($faker->unique()->numberBetween(100,200000000));
            $module->setType($this->getReference('type-'.rand(0, 4)));
            $module->setTemperatureModule($faker->numberBetween(-30,0));
            $module->setMaxTemperature($faker->numberBetween(50, 300));
            $module->setAutonomie($faker->numberBetween(1, 30));
            $module->setTypePower($this->getReference('power-'.rand(0, 5)));
            for($n = 0; $n < 7; $n++){
                $module->addSensor($this->getReference('sensor-'.rand(0, 6)));
            }
            for($j = 0; $j < 2; $j++){
                $module->addConnection($this->getReference('connexion-'.rand(0, 7)));
            }
            for($n =0; $n < 6; $n++){
                $module->addHistoric($this->getReference('historic-'.rand(0, 3)));
            }

            $module->setImage($faker->randomElement([
                 'image/cam.jpg', 'image/car.jpg', 'image/four.jpg', 'image/moto.jpg', 'image/swatch.jpg', 'image/tv.jpg', 'image/iotcam.jpg', 'image/iot1.png', 'image/iot2.jpg', 'image/gri.jpg', 'image/vols.jpg', 'image/iot4.jpg'
            ]));


            $manager->persist($module);
        }

        $manager->flush();
    }
}
