<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\JobApplication;
use App\Form\JobApplicationType;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\JobCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


final class PageController extends AbstractController
{
#[Route('/', name: 'home')]
public function home(): Response
{
    return $this->render('page/home.html.twig');
}
#[Route('/about', name: 'about')]
public function about(): Response
{
    return $this->render('page/about.html.twig');
}
#[Route('/jobs', name: 'job_list')]
public function jobList(JobRepository $jobRepository, JobCategoryRepository $categoryRepository, Request $request): Response
{
    $categoryId = $request->query->get('category');

    $queryBuilder = $jobRepository->createQueryBuilder('j');

    if ($categoryId) {
        $queryBuilder
            ->join('j.categories', 'c')
            ->andWhere('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId);
    }

    $jobs = $queryBuilder->getQuery()->getResult();

    $categories = $categoryRepository->findAll();

    return $this->render('page/job_list.html.twig', [
        'jobs' => $jobs,
        'categories' => $categories,
        'selectedCategory' => $categoryId
    ]);
}

#[Route('/jobs/{id}', name: 'job_detail')]
public function jobDetail(Job $job, Request $request, EntityManagerInterface $entityManager): Response
{
    $application = new JobApplication();

    $form = $this->createForm(JobApplicationType::class, $application);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // On complète l'objet
        $application->setJob($job);
        $application->setApplicant($this->getUser()); // tu as appelé le champ "applicant"
        $application->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($application);
        $entityManager->flush();

        $this->addFlash('success', 'Votre candidature a été envoyée avec succès !');

        return $this->redirectToRoute('job_detail', ['id' => $job->getId()]);
    }

    return $this->render('page/job_detail.html.twig', [
        'job' => $job,
        'applicationForm' => $form->createView(),
    ]);
}
}
