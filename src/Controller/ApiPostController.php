<?php

namespace App\Controller;

use App\Controller\ApiPostController;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository) //: Response
    {
        $contacts = $contactRepository->findAll();

        $json = json_encode([
            'prenom' => 'Momo',
            'mellal' => 'Mellal'

        ]);
        var_dump($json, $contact);

        return $this->render('api_post/index.html.twig', [
            'controller_name' => 'ApiPostController',
        ]);
    }
}
