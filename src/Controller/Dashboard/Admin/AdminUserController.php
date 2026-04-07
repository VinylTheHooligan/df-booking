<?php

namespace App\Controller\Dashboard\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/admin')]
final class AdminUserController extends AbstractController
{
    #[Route('/user', name: 'app_admin_user')]
    public function index(): Response
    {
        return $this->render('dashboard/admin/user/index.html.twig', [
            'controller_name' => 'AdminUserController',
            'page_selection' => 'admin_user'  
        ]);
    }
}
