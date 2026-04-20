<?php

namespace App\Controller\Dashboard\Admin;

use App\Repository\ResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminRessourcesController extends AbstractController
{
    #[Route('/resources', name: 'app_admin_resources', methods: ["GET"])]
    public function index(ResourceRepository $repo, Request $request): Response
    {   
        $page = $request->query->getInt('page', 1);
        $limit = 10;
    
        $paginator = $repo->findPaginated($page, $limit);
        $total = $paginator->count();
        $totalPages = ceil($total / $limit);
        
        return $this->render('dashboard/admin/resources/index.html.twig', [
            'controller_name' => 'AdminRessourcesController',
            'page_selection' => 'admin_ressources',
            'paginator' => $paginator,
            'page' => $page,
            'limit' => $limit,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/resources/{id}', name: 'app_admin_resources_detail', methods: ["GET"], requirements:['id' => "\d+"])]
    public function detail($id, ResourceRepository $repo): Response
    {
        $resource = $repo->find($id);

        return $this->render('dashboard/admin/resources/detail.html.twig', [
            'resource' => $resource,
        ]);
    }
}
