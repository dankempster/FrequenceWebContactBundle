<?php

namespace FrequenceWeb\Bundle\ContactBundle\Model;

/**
 * FrequenceWeb\Bundle\ContactBundle\Model\AbstractContact
 *
 * @author Dan Kempster <dev@dankempster.co.uk>
 */
abstract class AbstractContact
    implements Contact
{
    /**
     * The sender name
     *
     * @var string
     */
    protected $name;

    /**
     * The sender email
     *
     * @var string
     */
    protected $email;

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns data that can be injected in the translating message subject
     *
     * @return array
     */
    public function toTranslateArray()
    {
        return array(
            '%name%'    => $this->getName(),
            '%email%'   => $this->getEmail(),
        );
    }
}
