<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class StudentController extends AbstractController{

    public $students = array(
            array('id'=>1,'name'=>'Flen','moyenne'=>14,'image'=>'images/user1.jpg'),
            array('id'=>2,'name'=>'Ben Flen','moyenne'=>19,'image'=>'images/user2.png'),
            array('id'=>3,'name'=>'falten','moyenne'=>8,'image'=>'images/user3.png')
        );
    public function SayHello(){
        $msg = 'Hello 3A11';
        $student = array('id'=>1,'name'=>'Flen');
        
        $tab = [1,2,3,4];
        // return new Response("Bonjour 3A11");
        return $this->render('test.html.twig',[
            'm'=>$msg,
            's'=>$student,
            'students'=>$this->students,
            'tab'=>$tab
        ]);
    }

    #[Route('/student/details/{id}',name:'app_student_details')]
    public function studentDetails($id){
        $student = $this->students[$id-1];
        return $this->render('details.html.twig',[
            's'=>$student
        ]);
    }

    public function test(){
        return new Response("test test");
    }

    //Route(path,le nom de route)
    #[Route("/pathtest2",name:"app_test2")] 
    public function test2(){
        return new Response("test route méthode 2");
    }

    #[Route("/redirect",name:"app_redirect")] 
    public function testRedirect(){
        return $this->redirectToRoute('app_test2'); #POO
    }


    #[Route("/user/{id}/{name}",name:'app_testroutepara')]
    public function testRoutePara($id,$name){
        return new Response("test : ".$id."Name : ".$name);
    }



}

?>