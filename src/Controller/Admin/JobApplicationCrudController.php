<?php

namespace App\Controller\Admin;

use App\Entity\JobApplication;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class JobApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobApplication::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextareaField::new('coverLetter', 'Lettre de motivation'),
            DateTimeField::new('createdAt', 'Date de candidature'),
            AssociationField::new('applicant', 'Utilisateur'),
            AssociationField::new('job', 'Offre d\'emploi'),
        ];
    }
}
