<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\SlackBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Nexy\SlackBundle\DependencyInjection\Configuration;
use Nexy\SlackBundle\DependencyInjection\NexySlackExtension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    public function testMinimalConfigurationProcess()
    {
        $expectedConfiguration = [
            'guzzle_service' => null,
            'endpoint' => 'https://hooks.slack.com/services/XXXXX/XXXXX/XXXXXXXXXX',
            'channel' => null,
            'username' => null,
            'icon' => null,
            'link_names' => false,
            'unfurl_links' => false,
            'unfurl_media' => true,
            'allow_markdown' => true,
            'markdown_in_attachments' => [],
        ];

        $sources = [
            __DIR__.'/../Fixtures/config/config_minimal.yml',
        ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    public function testFullConfigurationProcess()
    {
        $expectedConfiguration = [
            'guzzle_service' => 'acme_guzzle',
            'endpoint' => 'https://hooks.slack.com/services/XXXXX/XXXXX/XXXXXXXXXX',
            'channel' => 'dev',
            'username' => 'jdoe',
            'icon' => 'icon.png',
            'link_names' => true,
            'unfurl_links' => true,
            'unfurl_media' => false,
            'allow_markdown' => false,
            'markdown_in_attachments' => ['test', 'foo', 'bar'],
        ];

        $sources = [
            __DIR__.'/../Fixtures/config/config_full.yml',
        ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtension()
    {
        return new NexySlackExtension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
