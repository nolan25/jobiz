<?php

namespace App\Controller\Admin;

use App\Entity\JobType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom du type de job'),
        ];
    }
}
