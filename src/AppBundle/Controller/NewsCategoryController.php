<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\NewsCategory;
use AppBundle\Form\NewsCategoryType;

/**
 * NewsCategory controller.
 *
 * @Route("/newscategory")
 */
class NewsCategoryController extends Controller
{
    /**
     * Lists all NewsCategory entities.
     *
     * @Route("/", name="newscategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsCategories = $em->getRepository('AppBundle:NewsCategory')->findAll();

        return $this->render('newscategory/index.html.twig', array(
            'newsCategories' => $newsCategories,
        ));
    }

    /**
     * Creates a new NewsCategory entity.
     *
     * @Route("/new", name="newscategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $newsCategory = new NewsCategory();
        $form = $this->createForm('AppBundle\Form\NewsCategoryType', $newsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsCategory);
            $em->flush();

            return $this->redirectToRoute('newscategory_show', array('id' => $newsCategory->getId()));
        }

        return $this->render('newscategory/new.html.twig', array(
            'newsCategory' => $newsCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a NewsCategory entity.
     *
     * @Route("/{id}", name="newscategory_show")
     * @Method("GET")
     */
    public function showAction(NewsCategory $newsCategory)
    {
        $deleteForm = $this->createDeleteForm($newsCategory);

        return $this->render('newscategory/show.html.twig', array(
            'newsCategory' => $newsCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing NewsCategory entity.
     *
     * @Route("/{id}/edit", name="newscategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, NewsCategory $newsCategory)
    {
        $deleteForm = $this->createDeleteForm($newsCategory);
        $editForm = $this->createForm('AppBundle\Form\NewsCategoryType', $newsCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsCategory);
            $em->flush();

            return $this->redirectToRoute('newscategory_edit', array('id' => $newsCategory->getId()));
        }

        return $this->render('newscategory/edit.html.twig', array(
            'newsCategory' => $newsCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a NewsCategory entity.
     *
     * @Route("/{id}", name="newscategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, NewsCategory $newsCategory)
    {
        $form = $this->createDeleteForm($newsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsCategory);
            $em->flush();
        }

        return $this->redirectToRoute('newscategory_index');
    }

    /**
     * Creates a form to delete a NewsCategory entity.
     *
     * @param NewsCategory $newsCategory The NewsCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NewsCategory $newsCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newscategory_delete', array('id' => $newsCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
