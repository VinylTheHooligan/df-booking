<?php

namespace App\Controller\Dashboard\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/admin')]
final class AdminReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_admin_reservation')]
    public function index(): Response
    {
        return $this->render('dashboard/admin/index.html.twig', [
            'controller_name' => 'AdminReservationController',
            'page_selection' => 'admin_booking'  
        ]);
    }
}
