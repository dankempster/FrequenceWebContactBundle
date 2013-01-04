<?php

namespace FrequenceWeb\Bundle\ContactBundle\Controller;


/**
 * Annotations
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Dependancies
 */
use FrequenceWeb\Bundle\ContactBundle\EventDispatcher\ContactEvents;
use FrequenceWeb\Bundle\ContactBundle\EventDispatcher\Event\MessageSubmitEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

/**
 * Contact controller
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class DefaultController extends ContainerAware
{
    /**
     * Action that displays the contact form
     *
     * @Template("FrequenceWebContactBundle:Default:index.html.twig")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->container->get('session')->set('_fw_contact_referer', $request->getUri());

        $form = $this->getForm();
        return array('form'=>$form->createView());
    }

    /**
     * Action that handles the submitted contact form
     *
     * @Template("FrequenceWebContactBundle:Default:index.html.twig")
     * @param  Request                                    $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitAction(Request $request)
    {
        $form = $this->getForm();
        $form->bind($request->request->get('contact'));

        if ($form->isValid()) {
            // Send the event for message handling (send mail, add to DB, don't care)
            $event = new MessageSubmitEvent($form->getData());
            $this->container->get('event_dispatcher')->dispatch(ContactEvents::onMessageSubmit, $event);

            // Let say the user it's ok
            $message = $this->container->get('translator')->trans('contact.submit.success', array(), 'FrequenceWebContactBundle');
            $this->container->get('session')->setFlash('success', $message);

            // Redirect somewhere
            return new RedirectResponse($this->container->get('session')->get('_fw_contact_referer'));
        }

        // Let say the user there's a problem
        $message = $this->container->get('translator')->trans('contact.submit.failure', array(), 'FrequenceWebContactBundle');
        $this->container->get('session')->setFlash('error', $message);

        // Errors ? Re-render the form
        return array('form'=>$form->createView());
    }

    /**
     * Returns the contact form instance
     *
     * @return FormInterface
     */
    protected function getForm()
    {
        return $this->container->get('form.factory')->create(
            $this->container->get('frequence_web_contact.type'),
            $this->container->get('frequence_web_contact.model')
        );
    }
}
