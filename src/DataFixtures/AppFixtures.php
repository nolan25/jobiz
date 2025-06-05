<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Job;
use App\Entity\JobCategory;
use App\Entity\JobType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // Créer JobCategories
        $categories = [];

        $catNames = ['Développement Web', 'Cybersecurité', 'Réseaux'];

        foreach ($catNames as $name) {
            $category = new JobCategory();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Créer JobTypes
        $jobTypes = [];

        $typeNames = ['Temps plein', 'Alternance', 'Freelance'];

        foreach ($typeNames as $name) {
            $jobType = new JobType();
            $jobType->setName($name);
            $manager->persist($jobType);
            $jobTypes[] = $jobType;
        }

        // Créer Companies
        $companies = [];

        for ($i = 1; $i <= 3; $i++) {
            $company = new Company();
            $company->setName('Company '.$i);
            $company->setDescription('Description de Company '.$i);
            $company->setAdress('Adresse '.$i);
            $company->setCountry('France');
            $company->setCity('Paris');
            $manager->persist($company);
            $companies[] = $company;
        }

        // Créer Users
        $admin = new User();
        $admin->setEmail('admin@jobiz.fr');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for ($i = 1; $i <= 2; $i++) {
            $user = new User();
            $user->setEmail('user'.$i.'@jobiz.fr');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'user123'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        // Créer Jobs
        for ($i = 1; $i <= 3; $i++) {
            $job = new Job();
            $job->setTitle('Offre '.$i.' - Développeur Symfony');
            $job->setDescription('Description de l\'offre '.$i);
            $job->setCity('Paris');
            $job->setRemoteAllowed($i % 2 === 0);
            $job->setSalaryRange('40k-50k');
            $job->setCompany($companies[array_rand($companies)]);
            $job->setJobType($jobTypes[array_rand($jobTypes)]);

            // Ajouter 1 ou plusieurs catégories aléatoirement
            shuffle($categories);
            $job->addCategory($categories[0]);
            if ($i % 2 === 0) {
                $job->addCategory($categories[1]);
            }

            $manager->persist($job);
        }

        $manager->flush();
    }
}
