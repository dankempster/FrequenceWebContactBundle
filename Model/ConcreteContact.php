<?php

namespace FrequenceWeb\Bundle\ContactBundle\Model;

/**
 * Class attached to the contact form. Represents data from it.
 * You can extend it, and / or make it an entity or a document.
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 * @author Dan Kempster <dev@dankempster.co.uk>
 */
class ConcreteContact extends AbstractContact
{
    /**
     * The message subject
     *
     * @var string
     */
    protected $subject;

    /**
     * The message body
     *
     * @var string
     */
    protected $body;

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Returns data that can be injected in the translating message subject
     *
     * @return array
     */
    public function toTranslateArray()
    {
        return parent::toTranslateArray()+array(
            '%subject%' => $this->subject,
        );
    }
}
