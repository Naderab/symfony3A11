<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentCrudController extends AbstractController
{
    #[Route("/author/get/all",name:'app_author_getall')]
    public function getAllAuthors(AuthorRepository $repo) {
        $authors= $repo->findAll();
        return $this->render('listAuthors.html.twig',['authors'=>$authors]);
    }

    #[Route('/author/add',name:'app_author_add')]
    public function addAuthor(EntityManagerInterface $em,Request $req){
        $author = new Author();
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($req);
        if($form->isSubmitted()){
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('app_author_getall');
        }
        return $this->render('formAuthor.html.twig',[
            'f'=>$form
        ]);
    }

    #[Route('/author/update/{id}',name:'app_author_update')]
    public function updateAuthor(EntityManagerInterface $em,$id
    ,AuthorRepository $repo){
        $author = $repo->find($id);
        $author->setName("author updated");
        $em->flush();
        return $this->redirectToRoute('app_author_getall');
    }

     #[Route('/author/delete/{id}',name:'app_author_delete')]
    public function deleteAuthor(ManagerRegistry $manager,$id
    ,AuthorRepository $repo){
        $author = $repo->find($id);
        $em=$manager->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_author_getall');
    }


}
