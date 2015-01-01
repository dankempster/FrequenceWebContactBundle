<?php

namespace FrequenceWeb\Bundle\ContactBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseTestCase;

/**
 * The bundle base web test case
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class WebTestCase extends BaseTestCase
{
    protected static function createKernel(array $options = array())
    {
        return new AppKernel(
            isset($options['test_case']) ? $options['test_case'] : 'fwcontact',
            isset($options['root_config']) ? $options['root_config'] : 'config.yml',
            isset($options['environment']) ? $options['environment'] : 'test',
            isset($options['debug']) ? $options['debug'] : true
        );
    }
}
