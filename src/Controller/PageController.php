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
public function jobDetail(Request $request, Job $job, EntityManagerInterface $em): Response
{
    // Créer un formulaire de postulation UNIQUEMENT si l'utilisateur est connecté
    $applicationForm = null;

    if ($this->getUser()) {
        $jobApplication = new JobApplication();
        $jobApplication->setJob($job);
        $jobApplication->setApplicant($this->getUser());
        $jobApplication->setCreatedAt(new \DateTimeImmutable());

        $applicationForm = $this->createForm(JobApplicationType::class, $jobApplication);
        $applicationForm->handleRequest($request);

        if ($applicationForm->isSubmitted() && $applicationForm->isValid()) {
            $em->persist($jobApplication);
            $em->flush();

            $this->addFlash('success', 'Votre candidature a été envoyée avec succès !');

            return $this->redirectToRoute('job_detail', ['id' => $job->getId()]);
        }
    }

    return $this->render('page/job_detail.html.twig', [
        'job' => $job,
        'applicationForm' => $applicationForm ? $applicationForm->createView() : null,
    ]);
}

}
