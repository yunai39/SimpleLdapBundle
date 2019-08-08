<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yunai39\Bundle\SimpleLdapBundle\Entity\RoleLdap;
use Yunai39\Bundle\SimpleLdapBundle\Form\RoleLdapType;

/**
 * Class RoleLdapController
 * @package Yunai39\Bundle\SimpleLdapBundle\Controller
 */
class RoleLdapController extends Controller
{
    /**
     * Lists all RoleLdap entities.
     * @return mixed
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SimpleLdapBundle:RoleLdap')->findAll();

        return $this->render('SimpleLdapBundle:RoleLdap:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new RoleLdap entity.
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $entity = new RoleLdap();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('roleldap_show', array('id' => $entity->getId())));
        }

        return $this->render('SimpleLdapBundle:RoleLdap:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a RoleLdap entity.
     *
     * @param RoleLdap $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RoleLdap $entity)
    {
        $form = $this->createForm(new RoleLdapType(), $entity, array(
            'action' => $this->generateUrl('roleldap_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'admin.create'));

        return $form;
    }

    /**
     * Displays a form to create a new RoleLdap entity.
     * @return mixed
     */
    public function newAction()
    {
        $entity = new RoleLdap();
        $form = $this->createCreateForm($entity);

        return $this->render('SimpleLdapBundle:RoleLdap:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RoleLdap entity.
     * @param int $id
     * @return mixed
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SimpleLdapBundle:RoleLdap')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoleLdap entity.');
        }
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SimpleLdapBundle:RoleLdap:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RoleLdap entity.
     *
     */
    public function editAction($id)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SimpleLdapBundle:RoleLdap')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoleLdap entity.');
        }
        $editForm  = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SimpleLdapBundle:RoleLdap:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a RoleLdap entity.
     *
     * @param RoleLdap $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(RoleLdap $entity)
    {
        $form = $this->createForm(new RoleLdapType(), $entity, array(
            'action' => $this->generateUrl('roleldap_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'admin.update'));

        return $form;
    }

    /**
     * Edits an existing RoleLdap entity.
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateAction(Request $request, $id)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SimpleLdapBundle:RoleLdap')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RoleLdap entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('roleldap_edit', array('id' => $id)));
        }

        return $this->render('SimpleLdapBundle:RoleLdap:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a RoleLdap entity.
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SimpleLdapBundle:RoleLdap')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RoleLdap entity.');
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('roleldap'));
    }

    /**
     * Creates a form to delete a RoleLdap entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('roleldap_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'admin.delete'))
            ->getForm();
    }
}
