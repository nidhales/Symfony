<?php

namespace App\Controller;

use App\Entity\Job;
use Doctrine\ORM\Mapping\Id;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function index(): Response
    {
        return $this->render('job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }
    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil()
    {
        #$url = $this->get('router')->generate('job');
        return $this->RedirectToRoute('job');
    }
    /**
     * @Route("/voir/{id}", name="voir",requirements={"id"="\d+"})
     */
    public function voir($id)
    {
        $job = $this->getDoctrine()->getManager()->getRepository(Job::class)->find($id);
        return $this->render('job/voir.html.twig', [
            'id' => $id,
            'job' => $job
        ]);
    }
    /**
     * @Route("/add", name="add")
     */
    public function add()
    {
        $job = new job();
        $job->setTitle('Developeur symfony');
        $job->setcompany('Sloth-Lab');
        $job->setDescription('searching for a symfony developer');
        $job->setIsActivated(1);
        $job->setExpiresAt(new \DateTimeImmutable());
        $job->setEmail('nidhales@gmailcom');

        $em = $this->getDoctrine()->getManager();
        $em->persist($job);
        $em->flush();

        #$url = $this->get('router')->generate('job');
        return $this->render('job/add.html.twig');
    }
    /**
     * @Route("/edit", name="edit")
     */
    public function edit()
    {
        #$url = $this->get('router')->generate('job');
        return $this->render('job/edit.html.twig');
    }
    /**
     * @Route("/delete", name="delete")
     */
    public function delete()
    {
        #$url = $this->get('router')->generate('job');
        return $this->render('job/delete.html.twig');
    }
    /**
     * @return Response 
     */
    public function menu(): Response
    {

        $mymenu = array(
            ['route' => 'job', 'intitule' => 'Accueil'],
            ['route' => 'add', 'intitule' => 'Ajouter un job'],
            ['route' => 'edit', 'intitule' => 'Modifier les jobs'],
            ['route' => 'delete', 'intitule' => 'Supprimer un job'],
        );
        return $this->render('job/navbar.html.twig', [
            'adc' => $mymenu,
        ]);
    }
    public function sidebar(): Response
    {
        $listjobs = array(
            ['id' => 1, 'nomjob' => 'Developeur Web'],
            ['id' => 2, 'nomjob' => 'Responsable Marketing'],
            ['id' => 3, 'nomjob' => 'Team Leader'],
        );
        return $this->render(
            'job/sidebar.html.twig',
            [
                'aze' => $listjobs,
            ]
        );
    }
}
