<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function addAuthor(EntityManagerInterface $em){
        $author = new Author();
        $author->setName("author 1");
        $author->setEmail("author1@gmail.com");

        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('app_author_getall');
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
