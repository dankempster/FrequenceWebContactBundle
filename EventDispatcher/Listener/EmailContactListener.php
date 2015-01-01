<?php

namespace FrequenceWeb\Bundle\ContactBundle\EventDispatcher\Listener;

use FrequenceWeb\Bundle\ContactBundle\EventDispatcher\Event\MessageSubmitEvent;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

use FrequenceWeb\Bundle\ContactBundle\Exception\InvalidArgumentException;
use FrequenceWeb\Bundle\ContactBundle\Exception\InvalidConfigKey;

/**
 * Listener for contact events, that sends emails
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class EmailContactListener
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param \Swift_Mailer       $mailer
     * @param EngineInterface     $templating
     * @param TranslatorInterface $translator
     * @param array<string>       $config     Configuration from DIC
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, TranslatorInterface $translator, array $config)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
        $this->translator = $translator;
        $this->config     = $config;
    }

    /**
     * Called when onMessageSubmit event is fired
     *
     * @param MessageSubmitEvent $event
     */
    public function onMessageSubmit(MessageSubmitEvent $event)
    {
        $contact = $event->getContact();

        // @TODO: Is there a Factory or Container we can use to remove this dependancy?
        $message = new \Swift_Message($this->translator->trans(
            $this->config['subject'],
            $contact->toTranslateArray(),
            'FrequenceWebContactBundle'
        ));

        if ($this->config['timestamp_subject']) {
            $message->setSubject(
                $message->getSubject()
               .$this->config['timestamp_subject_separator']
               .date($this->config['timestamp_mask'])
            );
        }

        $message->addFrom($this->config['from']);
        $message->addReplyTo($contact->getEmail(), $contact->getName());
        $message->setTo($this->config['to']);
        $message->addPart(
            $this->templating->render(
                'FrequenceWebContactBundle:Mails:mail.html.twig',
                array('contact' => $contact)
            ),
            'text/html'
        );
        $message->addPart(
            $this->templating->render(
                'FrequenceWebContactBundle:Mails:mail.txt.twig',
                array('contact' => $contact)
            ),
            'text/plain'
        );

        $this->mailer->send($message);
    }

    /**
     * Change one fo the configuration options
     *
     * @param string $key
     * @param scalar $value
     * @return EmailContactListener Returns self for fluent interface
     */
    public function setConfigValue($key, $value)
    {
        if (!isset($this->config[$key])) {
            throw new InvalidConfigKey("'{$key} is not a valid config value");
        }
        elseif (!is_scalar($value)) {
            throw new InvalidArgumentException("\$value must be a scalar value");
        }

        $this->config[$key] = $value;

        return $this;
    }
}
