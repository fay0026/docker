<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contactRepository, Request $request): Response
    {
        $searched = $request->query->get('search');
        if (!$searched) {
            $searched = '';
        }
        $contact_list = $contactRepository->search($searched);
        // $old_contact_list = $contactRepository->findBy([], ['lastname' => 'ASC', 'firstname' => 'ASC']);

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact_list' => $contact_list,
            'last_search' => $searched,
        ]);
    }

    #[Route('/contact/create', name: 'app_contact_create')]
    public function create(EntityManagerInterface $entityManager, Request $request)
    {
        $Nouveau = new Contact();

        $form = $this->createForm(ContactType::class, $Nouveau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Nouveau);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_show', ['id' => $Nouveau->getId()]);
        }

        return $this->render('contact/create.html.twig', ['contact' => $Nouveau, 'form' => $form, 'last_search' => '']);
    }

    /*
     * Ce chemin permet d'afficher les détails d'un utilisateur à partir d'un identifiant passé
     * en paramètres. L'utilisation de MapEntity permet de n'effectuer qu'une requête pour avoir
     * le contact et sa catégorie, plutôt que deux avec juste un paramètre contact.
     */
    #[Route('/contact/{id<\d+>}', name: 'app_contact_show')]
    public function show(/* Contact $contact */ #[MapEntity(expr: 'repository.findWithCategory(id)')] Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', ['contact' => $contact, 'last_search' => '']);
    }

    #[Route('/contact/{id<\d+>}/update', name: 'app_contact_update')]
    public function update(#[MapEntity(expr: 'repository.findWithCategory(id)')] Contact $contact, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_show', ['id' => $contact->getId()]);
        }

        return $this->render('contact/update.html.twig', ['contact' => $contact, 'form' => $form, 'last_search' => '']);
    }

    #[Route('/contact/{id<\d+>}/delete', name: 'app_contact_delete')]
    public function delete(#[MapEntity(expr: 'repository.findWithCategory(id)')] Contact $contact)
    {
        return $this->render('contact/delete.html.twig', ['contact' => $contact, 'last_search' => '']);
    }
}
