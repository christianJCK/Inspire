<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phrase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Phrase controller.
 *
 */
class PhraseController extends Controller
{
    /**
     * Lists all phrase entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $phrases = $em->getRepository('AppBundle:Phrase')->findAll();

        return $this->render('phrase/index.html.twig', array(
            'phrases' => $phrases,
        ));
    }

    /**
     * Creates a new phrase entity.
     *
     */
    public function newAction(Request $request)
    {
        $phrase = new Phrase();
        $form = $this->createForm('AppBundle\Form\PhraseType', $phrase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phrase);
            $em->flush($phrase);

            return $this->redirectToRoute('phrase_show', array('id' => $phrase->getId()));
        }

        return $this->render('phrase/new.html.twig', array(
            'phrase' => $phrase,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a phrase entity.
     *
     */
    public function showAction(Phrase $phrase)
    {
        $deleteForm = $this->createDeleteForm($phrase);

        return $this->render('phrase/show.html.twig', array(
            'phrase' => $phrase,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing phrase entity.
     *
     */
    public function editAction(Request $request, Phrase $phrase)
    {
        $deleteForm = $this->createDeleteForm($phrase);
        $editForm = $this->createForm('AppBundle\Form\PhraseType', $phrase);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phrase_edit', array('id' => $phrase->getId()));
        }

        return $this->render('phrase/edit.html.twig', array(
            'phrase' => $phrase,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a phrase entity.
     *
     */
    public function deleteAction(Request $request, Phrase $phrase)
    {
        $form = $this->createDeleteForm($phrase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($phrase);
            $em->flush($phrase);
        }

        return $this->redirectToRoute('phrase_index');
    }

    /**
     * Creates a form to delete a phrase entity.
     *
     * @param Phrase $phrase The phrase entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Phrase $phrase)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('phrase_delete', array('id' => $phrase->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
