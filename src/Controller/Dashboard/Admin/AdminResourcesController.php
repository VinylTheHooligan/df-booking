<?php

namespace App\Controller\Dashboard\Admin;

use App\Entity\Resource;
use App\Enum\LogState;
use App\Form\ResourceForm;
use App\Repository\ResourceRepository;
use App\Service\EntityServiceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'app_admin')]
final class AdminResourcesController extends AbstractController
{
    #[Route('/resources', name: '_resources', methods: ["GET"])]
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

    #[Route('/resources/{id}', name: '_resources_detail', methods: ["GET"], requirements:['id' => "\d+"])]
    public function detail($id, ResourceRepository $repo): Response
    {
        $resource = $repo->findWithRelations($id);

        return $this->render('dashboard/admin/resources/detail.html.twig', [
            'resource' => $resource,
        ]);
    }

    #[Route('/resources/create', name: '_resources_create', methods: ["GET", "POST"])]
    public function create(Request $request, EntityServiceManager $esm): Response
    {
        $resource = new Resource();
        $resourceForm = $this->createForm(ResourceForm::class, $resource);
        $resourceForm->handleRequest($request);

        if ($resourceForm->isSubmitted() && $resourceForm->isValid())
        {
            $esm->manage($resource, $this->getUser(), LogState::CREATED, null);
            $this->addFlash("success", "La ressource à bien été créer !");
            return $this->redirectToRoute('app_admin_resources_detail', ['id' => $resource->getId()]);         
        }

        return $this->render('dashboard/admin/resources/edit.html.twig', [
            'resource' => $resource,
            'resourceForm' => $resourceForm,
        ]);
    }

    #[Route('/resources/{id}/modify', name: '_resources_modify', methods: ["GET", "POST"], requirements:['id' => "\d+"])]
    public function modify(Resource $resource, Request $request, EntityServiceManager $esm): Response
    {
        $resourceForm = $this->createForm(ResourceForm::class, $resource);
        $resourceForm->handleRequest($request);

        if ($resourceForm->isSubmitted() && $resourceForm->isValid())
        {
            $esm->manage($resource, $this->getUser(), LogState::UPDATED, null);
            $this->addFlash("success", "La ressource à bien été modifiée !");            
        }

        return $this->render('dashboard/admin/resources/edit.html.twig', [
            'resource' => $resource,
            'resourceForm' => $resourceForm,
        ]);
    }

    #[Route('/resources/{id}/toggle', name: '_resources_toggle', methods: ["GET", "POST"], requirements:['id' => "\d+"])]
    public function toggle(Resource $resource, EntityServiceManager $esm): Response
    {
        $resource->setIsEnabled(!$resource->isEnabled());

        $customMessage = "This resource has been toggled to " . ($resource->isEnabled() ? "'true'." : "'false'.");
        $esm->manage($resource, $this->getUser(), LogState::UPDATED, $customMessage);

        if($resource->isEnabled())
        {
            $this->addFlash("info", "La ressource à bien été activée !");
        }
        else
        {
            $this->addFlash("info", "La ressource à bien été désactivée !");
        }

        return $this->redirectToRoute('app_admin_resources_detail', ['id' => $resource->getId()]);
    }

    #[Route('/resources/{id}/delete/{token}', name: '_resources_delete', methods: ["POST"], requirements:['id' => "\d+"])]
    public function delete(Resource $resource, EntityServiceManager $esm, string $token): Response
    {
        if ($this->isCsrfTokenValid("delete-resource-" . $resource->getId(), $token))
        {
            $esm->delete($resource, $this->getUser(), LogState::DELETED, "This resource has been deleted.");

            $this->addFlash("success", "La ressource a bien été supprimée !");
            return $this->redirectToRoute("app_admin_resources");
        }
        $this->addFlash("danger", "Le token CSRF est invalide. La ressource n'a pas été supprimée.");
        return $this->redirectToRoute('app_admin_resources_detail', ["id" => $resource->getId()]);
        
    }
}
