<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\ProjectTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route(
     *     "/"
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        return $this->render('default/home.html.twig');
    }

    /**
     * @Route(
     *     "/app",
     *     name="app"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('project', EntityType::class, [
                'attr' => [
                    'id' => 'selectProject',
                    'class' => 'form-control'
                ],
                'class' => 'AppBundle\Entity\Project',
                'choice_label' => 'title',
                'label' => false
            ])
        ->getForm();


        return $this->render('default/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route(
     *     "/save"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function save(Request $request)
    {
        $pt = new ProjectTime();

        /** @var ProjectTime $pt */
        $pt ->setProject($this->getDoctrine()->getRepository(Project::class)->find((int) $request->get('project')));
        $pt ->setUser($this->getUser());
        $pt ->setTime((string) $request->get('time'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($pt);
        $em->flush();

        $this->addFlash('success', 'Времня затраченное на данный проект сохранено');
        return $this->redirect('/app');
    }
}
