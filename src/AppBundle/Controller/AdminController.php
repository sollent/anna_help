<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use AppBundle\Form\ProjectForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * @Route(
     *     "/admin"
     * )
     */
    public function admin()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();

        return $this->render('default/admin.html.twig', \compact('users', 'projects'));
    }

    /**
     * @Route(
     *     "/admin/create-project"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createProject(Request $request)
    {
        $p = new Project();
        $form = $this->createForm(ProjectForm::class, $p);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $p = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();

            $this->addFlash('success', 'Проект успешно создан');
            return $this->redirect('/admin');
        }

        return $this->render('default/create-project.html.twig', ['form' => $form->createView()]);
    }
}
