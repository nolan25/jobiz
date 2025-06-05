<?php

namespace App\Controller\Admin;

use App\Entity\Job;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class JobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Job::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextareaField::new('description', 'Description'),
            TextField::new('city', 'Ville'),
            TextField::new('salaryRange', 'Salaire'),
            BooleanField::new('remoteAllowed', 'Télétravail autorisé'),
            AssociationField::new('company', 'Entreprise'),
            AssociationField::new('jobType', 'Type de job'),
            AssociationField::new('categories', 'Catégories')->setFormTypeOptions(['by_reference' => false]),
        ];
    }
}
