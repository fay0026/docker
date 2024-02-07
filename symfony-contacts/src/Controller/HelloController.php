<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'last_search' => '',
        ]);
    }

    // , requirements: ['times' => '\d+']
    #[Route('/hello/{name}/{times<\d+>?3}', name: 'app_hello_manytimes')]
    public function manyTimes(string $name, int $times): Response
    {
        if (0 == $times or $times > 10) {
            $ret = $this->redirectToRoute('app_hello_manytimes', ['name' => $name, 'times' => 3, 'last_search' => '']);
        } else {
            $ret = $this->render('hello/many_times.html.twig', ['name' => $name, 'times' => $times, 'last_search' => '']);
        }

        return $ret;
    }

    #[Route('/hello/{name}')]
    public function world(string $name): Response
    {
        return $this->render('hello/world.html.twig', ['name' => $name, 'last_search' => '']);
    }
}
