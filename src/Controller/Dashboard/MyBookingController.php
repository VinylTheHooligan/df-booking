<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MyBookingController extends AbstractController
{
    #[Route('/my_booking', name: 'app_my_booking')]
    public function index(): Response
    {
        return $this->render('dashboard/my_booking/index.html.twig', [
            'controller_name' => 'MyBookingController',
        ]);
    }
}
