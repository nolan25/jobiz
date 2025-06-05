<?php

namespace App\Controller;

use App\Entity\Job;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
public function jobList(JobRepository $jobRepository): Response
{
    $jobs = $jobRepository->findAll();
    return $this->render('page/job_list.html.twig', [
        'jobs' => $jobs,
    ]);
}

#[Route('/jobs/{id}', name: 'job_detail')]
public function jobDetail(Job $job): Response
{
    return $this->render('page/job_detail.html.twig', [
        'job' => $job,
    ]);
}
}
