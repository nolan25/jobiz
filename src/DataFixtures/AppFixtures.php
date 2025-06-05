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
        // Créer des JobCategories
        $category = new JobCategory();
        $category->setName('Développement Web');
        $manager->persist($category);

        // Créer des JobTypes
        $jobType = new JobType();
        $jobType->setName('Temps plein');
        $manager->persist($jobType);

        // Créer une Company
        $company = new Company();
        $company->setName('OpenAI Corp');
        $company->setDescription('Entreprise innovante en IA');
        $company->setAdress('123 Avenue des Sciences');
        $company->setCountry('France');
        $company->setCity('Paris');
        $manager->persist($company);

        // Créer un User admin
        $user = new User();
        $user->setEmail('admin@jobiz.fr');
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'admin123');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        // Créer un Job
        $job = new Job();
        $job->setTitle('Développeur Symfony');
        $job->setDescription('Nous recherchons un développeur Symfony motivé !');
        $job->setCity('Paris');
        $job->setRemoteAllowed(true);
        $job->setSalaryRange('45k-55k');
        $job->setCompany($company);
        $job->setJobType($jobType);
        $job->addCategory($category);
        $manager->persist($job);

        // On flush toutes les entités
        $manager->flush();
    }
}
