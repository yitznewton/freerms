<?php

namespace Yitznewton\FreermsBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IpRangeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/ip');

        $this->assertTrue(
            $crawler->filter('html:contains("IP Ranges")')->count() > 0,
            'IpRange:index title present');
    }
}
