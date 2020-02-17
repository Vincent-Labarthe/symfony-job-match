<?php

namespace App\Command;

use App\Entity\JobApplication;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JobApplicationUpdate extends Command
{

    protected static $defaultName = 'app:job:update';

    private $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Mettre a jours les annonces dans la BDD')
            ->setHelp('Cette commande n\'a pas besoin de parametres elle se debrouille toute seule');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=%2Fpartenaire',
            [

                'body' =>
                [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'PAR_jobmatch_8020fad20589618f40624dbb438fa3d94961a7cb2cbf9034c9322679ba84422b',
                    'client_secret' => 'b556351b9d92d3d561a607319b3dd5bc72d463a3daf1d409cb09e63c7823e9ab',
                    'scope' => 'api_offresdemploiv2 application_PAR_jobmatch_8020fad20589618f40624dbb438fa3d94961a7cb2cbf9034c9322679ba84422b o2dsoffre '
                ]
            ],

        );
        $content = $response->toArray();
        $token = $content['access_token'];
        dump($token);

        $response = $client->request(
            'GET',
            'https://api.emploi-store.fr/partenaire/offresdemploi/v2/offres/search?codeROME=M1805&departement=94&publieeDepuis=1',
            [
                'headers' => [
                    'Authorization' => "Bearer $token"
                ],

                'body' =>
                [
                    'scope' => 'api_offresdemploiv2 application_PAR_jobmatch_8020fad20589618f40624dbb438fa3d94961a7cb2cbf9034c9322679ba84422b o2dsoffre'
                ]
            ]
        );
        $content = $response->toArray();
        
        
        foreach ($content['resultats'] as $annonce) {
            $newJobApplication = new JobApplication();
        $newJobApplication->setTitle($annonce['intitule']);
           $newJobApplication->setDescription($annonce['description']);
           $newJobApplication->setRefId($annonce['id']);
           $newJobApplication->setAdress(94);
       
            $this->manager->persist($newJobApplication);
            $this->manager->flush();
            
        }
        


        /*$contentLenght=$content['resultats'];
dump(count($contentLenght));*/
$output->writeln([
    'Intérrogationd de l\'api',
    '============',
    '',
]);
$output->writeln([
    'Mise a jour de la base de donnée',
    '============',
    '',
]);

        return 1;
    }
}
