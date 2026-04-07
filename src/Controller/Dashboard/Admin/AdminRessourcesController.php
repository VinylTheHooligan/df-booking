<?php

namespace App\Controller\Dashboard\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminRessourcesController extends AbstractController
{
    #[Route('/ressources', name: 'app_admin_ressources')]
    public function index(): Response
    {
        return $this->render('dashboard/admin/ressources/index.html.twig', [
            'controller_name' => 'AdminRessourcesController',
            'page_selection' => 'admin_ressources'  
        ]);
    }
}
