<?php

namespace App\Controller\Dashboard\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/admin/dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
            'page_selection' => 'admin_dashboard'
        ]);
    }
}
