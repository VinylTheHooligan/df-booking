<?php

namespace App\Controller\Dashboard\Admin;

use App\Entity\Resource;
use App\Repository\ResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminRessourcesController extends AbstractController
{
    #[Route('/ressources', name: 'app_admin_ressources')]
    public function index(ResourceRepository $repo, Request $request): Response
    {   
        $page = $request->query->getInt('page', 1);
        $limit = 10;
    
        $paginator = $repo->findPaginated($page, $limit);
        $total = $paginator->count();
        $totalPages = ceil($total / $limit);
        
        return $this->render('dashboard/admin/ressources/index.html.twig', [
            'controller_name' => 'AdminRessourcesController',
            'page_selection' => 'admin_ressources',
            'paginator' => $paginator,
            'page' => $page,
            'limit' => $limit,
            'totalPages' => $totalPages,
        ]);
    }
}
