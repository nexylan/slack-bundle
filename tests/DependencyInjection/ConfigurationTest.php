<?php

declare(strict_types=1);

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
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    public function testMinimalConfigurationProcess(): void
    {
        $expectedConfiguration = [
            'http' => [
                'client' => 'httplug.client',
                'request_factory' => 'nexy_slack.request_factory.default',
                'stream_factory' => 'nexy_slack.stream_factory.default',
            ],
            'sticky_channel' => false,
            'endpoint' => 'https://hooks.slack.com/services/XXXXX/XXXXX/XXXXXXXXXX',
            'markdown_in_attachments' => [],
        ];

        $sources = [
            __DIR__.'/../Fixtures/config/config_minimal.yml',
        ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    public function testFullConfigurationProcess(): void
    {
        $expectedConfiguration = [
            'http' => [
                'client' => 'httplug.curl',
                'request_factory' => 'nexy_slack.request_factory.default',
                'stream_factory' => 'nexy_slack.stream_factory.default',
            ],
            'sticky_channel' => false,
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
    protected function getContainerExtension(): ExtensionInterface
    {
        return new NexySlackExtension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration(): ConfigurationInterface
    {
        return new Configuration();
    }
}
