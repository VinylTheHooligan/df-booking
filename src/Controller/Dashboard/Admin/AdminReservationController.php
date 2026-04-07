<?php

namespace App\Controller\Dashboard\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/admin')]
final class AdminReservationController extends AbstractController
{
    #[Route('/booking', name: 'app_admin_booking')]
    public function index(): Response
    {
        return $this->render('dashboard/admin/booking/index.html.twig', [
            'controller_name' => 'AdminReservationController',
            'page_selection' => 'admin_booking'  
        ]);
    }
}
