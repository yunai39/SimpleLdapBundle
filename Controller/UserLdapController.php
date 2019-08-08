<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yunai39\Bundle\SimpleLdapBundle\Entity\UserLdap;
use Yunai39\Bundle\SimpleLdapBundle\Form\UserLdapType;

/**
 * Class UserLdapController
 * @package Yunai39\Bundle\SimpleLdapBundle\Controller
 */
class UserLdapController extends Controller
{
    /**
     * Lists all UserLdap entities.
     * @return mixed
     */
    public function indexAction()
    {
        $em      = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SimpleLdapBundle:UserLdap')->findAll();

        return $this->render('SimpleLdapBundle:UserLdap:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Creates a new UserLdap entity.
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $entity = new UserLdap();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('userldap_show', array('id' => $entity->getId())));
        }

        return $this->render('SimpleLdapBundle:UserLdap:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a UserLdap entity.
     * @param UserLdap $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(UserLdap $entity)
    {
        $form = $this->createForm(new UserLdapType(), $entity, array(
            'action' => $this->generateUrl('userldap_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'admin.create'));

        return $form;
    }

    /**
     * @return mixed
     */
    public function newAction()
    {
        $entity = new UserLdap();
        $form   = $this->createCreateForm($entity);

        return $this->render('SimpleLdapBundle:UserLdap:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserLdap entity.
     * @param $id
     * @return mixed
     */
    public function showAction($id)
    {
        $em    = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SimpleLdapBundle:UserLdap')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserLdap entity.');
        }
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SimpleLdapBundle:UserLdap:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing UserLdap entity.
     * @param $id
     * @return mixed
     */
    public function editAction($id)
    {
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SimpleLdapBundle:UserLdap')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserLdap entity.');
        }
        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SimpleLdapBundle:UserLdap:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a UserLdap entity.
     * @param UserLdap $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(UserLdap $entity)
    {
        $form = $this->createForm(new UserLdapType(), $entity, array(
            'action' => $this->generateUrl('userldap_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'admin.update'));

        return $form;
    }

    /**
     * Edits an existing UserLdap entity.
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SimpleLdapBundle:UserLdap')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserLdap entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('userldap_edit', array('id' => $id)));
        }

        return $this->render('SimpleLdapBundle:UserLdap:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserLdap entity.
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
            $entity = $em->getRepository('SimpleLdapBundle:UserLdap')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserLdap entity.');
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('userldap'));
    }

    /**
     * Creates a form to delete a UserLdap entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userldap_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'admin.delete'))
            ->getForm();
    }
}
