<?php

namespace App\Controller\Dashboard\Admin;

use App\Entity\Resource;
use App\Form\ResourceForm;
use App\Repository\ResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminResourcesController extends AbstractController
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
        $resource = $repo->findWithRelations($id);

        return $this->render('dashboard/admin/resources/detail.html.twig', [
            'resource' => $resource,
        ]);
    }

    #[Route('/resources/{id}/modify', name: 'app_admin_resources_modify', methods: ["GET", "POST"], requirements:['id' => "\d+"])]
    public function modify(Resource $resource, Request $request, EntityManagerInterface $em): Response
    {
        $resourceForm = $this->createForm(ResourceForm::class, $resource);
        $resourceForm->handleRequest($request);

        if ($resourceForm->isSubmitted() && $resourceForm->isValid())
        {
            

            $this->addFlash("success", "La ressource à bien été modifié !");            
        }

        return $this->render('dashboard/admin/resources/edit.html.twig', [
            'resource' => $resource,
            'resourceForm' => $resourceForm,
        ]);
    }
}
