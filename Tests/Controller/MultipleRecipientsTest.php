<?php

namespace FrequenceWeb\Bundle\ContactBundle\Tests\Controller;

use FrequenceWeb\Bundle\ContactBundle\Tests\Functional\WebTestCase;

class MultipleRecipientsTest extends WebTestCase
{
    public function testIndex()
    {
        /** @var $client \Symfony\Bundle\FrameworkBundle\Client */
        $client = static::createClient(array(
            'test_case' => 'multi-recipients',
        ));
        /** @var $crawler \Symfony\Component\DomCrawler\Crawler  */
        $crawler = $client->request('GET', '/contact');

        // Submit the form
        $form = $crawler->selectButton('contact_message_submit')->form();
        $form->setValues(array(
            'contact[name]'    => 'John Doe',
            'contact[email]'   => 'john.doe@gmail.com',
            'contact[subject]' => 'I have a message for you.',
            'contact[body]'    => 'This is my message body.',
        ));
        $client->submit($form);

        // fetch the sent emails
        $messages = $client->getProfile()->getCollector('swiftmailer')->getMessages();
        $this->assertEquals(
            array(
                'foo@bar.baz' => null,
                'zack@bar.baz' => null,
            ),
            $messages[0]->getTo()
        );
    }
}
