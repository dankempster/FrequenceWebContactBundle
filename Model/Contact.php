<?php

namespace FrequenceWeb\Bundle\ContactBundle\Model;

/**
 * Class attached to the contact form. Represents data from it.
 * You can extend it, and / or make it an entity or a document.
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
interface Contact
{
    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getName();

    /**
     * Returns data that can be injected in the translating message subject
     *
     * @return array
     */
    public function toTranslateArray();
}
