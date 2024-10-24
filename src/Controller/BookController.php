<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\GetByTitleType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
   
    #[Route("/book/get/all",name:'app_book_getall')]
    public function getAllbooks(BookRepository $repo) {
        $books= $repo->findAll();
        $form=$this->createForm(GetByTitleType::class);
        $booksOrdred = $repo->getBooksOrdredByTitle();
        $nb = $repo->getNbBooks();
        return $this->render('book/index.html.twig',
        ['books'=>$books,'b'=>$booksOrdred,'nb'=>$nb,'f'=>$form]);
    }

    #[Route('/book/add',name:'app_book_add')]
    public function addbook(Request $req,EntityManagerInterface $em){
        $book = new Book();
        $form= $this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        if($form->isSubmitted()){
                $em->persist($book);
                $em->flush();
        return $this->redirectToRoute('app_book_getall');
        }
        
        return $this->render('book/formBook.html.twig',[
            'f'=>$form
        ]);

        
    }

    #[Route('/book/update/{id}',name:'app_book_update')]
    public function updatebook(Request $req,EntityManagerInterface $em,$id
    ,bookRepository $repo){
        $book = $repo->find($id);
        $form= $this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        if($form->isSubmitted()){
                $em->persist($book);
                $em->flush();
        return $this->redirectToRoute('app_book_getall');
        }
        
        return $this->render('book/formBook.html.twig',[
            'f'=>$form
        ]);

    }

     #[Route('/book/delete/{id}',name:'app_book_delete')]
    public function deletebook(ManagerRegistry $manager,$id
    ,bookRepository $repo){
        $book = $repo->find($id);
        $em=$manager->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('app_book_getall');
    }
}
