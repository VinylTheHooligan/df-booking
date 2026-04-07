<?php

namespace App\Controller\Dashboard\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/admin')]
final class AdminLogController extends AbstractController
{
    #[Route('/log', name: 'app_admin_log')]
    public function index(): Response
    {
        return $this->render('dashboard/admin/log/index.html.twig', [
            'controller_name' => 'LogController',
            'page_selection' => 'admin_log'
        ]);
    }
}
