<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\Job;
use App\Entity\JobApplication;
use App\Entity\JobCategory;
use App\Entity\JobType;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Jobiz - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Entreprises', 'fas fa-building', Company::class);
        yield MenuItem::linkToCrud('Offres d\'emploi', 'fas fa-briefcase', Job::class);
        yield MenuItem::linkToCrud('Catégories de jobs', 'fas fa-list', JobCategory::class);
        yield MenuItem::linkToCrud('Types de jobs', 'fas fa-tags', JobType::class);
        yield MenuItem::linkToCrud('Candidatures', 'fas fa-envelope', JobApplication::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-arrow-left', 'home');
    }
}
