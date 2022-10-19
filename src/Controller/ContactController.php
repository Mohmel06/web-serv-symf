<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/admin/contacts", name="app_contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    /**
     * @Route("/rest/contacts", name="rest_app_contact_index", methods={"GET"})
     */
    public function rest_index(ContactRepository $contactRepository): Response
    {
        return $this->json(['status' => 200 , "message" => "Liste des contacts", "error" => null , "data" => $contactRepository->findAll()]);

    }

    /**
     * @Route("/admin/contact/new", name="app_contact_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/rest/contact/new", name="rest_app_contact_new", methods={"GET", "POST"})
     */
    public function rest_new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $date = new \DateTime('@'.strtotime('now'));

        $contact->setNom($request->query->get('nom'));
        $contact->setEmail($request->query->get('email'));
        $contact->setContenu($request->query->get('contenu'));
        $contact->setMessage($request->query->get('message'));
        $contact->setCreated($date, $request->query->get('created'));
        $contact->setModified($date, $request->query->get('modified'));
        $contact->setPublic($request->query->get('public'));
        $contact->setLu($request->query->get('lu'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager ->persist($contact);
        $entityManager ->flush();


    /*    if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }*/


        return $this->json(['status' => 200 , "message" => "Ajouté avec succés", "error" => null , "data" => $contact]);
    }


    /**
     * @Route("/admin/contact/show/{id}", name="app_contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/rest/contact/show/{id}", name="rest_app_contact_show", methods={"GET"})
     */
    public function rest_show(Contact $contact): Response
    {
        return $this->json(['status' => 200 , "message" => "Détail des contacts", "error" => null , "data" => $contact]);

    }


    /**
     * @Route("/admin/contact/edit/{id}", name="app_contact_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

        /**
     * @Route("/rest/contact/edit/{id}", name="rest_app_contact_edit", methods={"GET", "POST"})
     */
    public function rest_edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $date = new \DateTime('@'.strtotime('now'));

        $contact->setNom($request->query->get('nom'));
        $contact->setEmail($request->query->get('email'));
        $contact->setContenu($request->query->get('contenu'));
        $contact->setMessage($request->query->get('message'));
        $contact->setCreated($date, $request->query->get('created'));
        $contact->setModified($date, $request->query->get('modified'));
        $contact->setPublic($request->query->get('public'));
        $contact->setLu($request->query->get('lu'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager ->persist($contact);
        $entityManager ->flush();


        return $this->json(['status' => 200 , "message" => "Modifié avec succés", "error" => null , "data" => $contact]);
    }

    


    /**
     * @Route("/admin/contact/delete/{id}", name="app_contact_delete", methods={"POST"})
     */
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact, true);
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/rest/contact/delete/{id}", name="rest_app_contact_delete", methods={"GET", "DELETE"})
     */
    public function rest_delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact, true);
        }

        return $this->json(['status' => 200 , "message" => "Supprimé avec succés", "error" => null, "data" => true]);
    }

}
