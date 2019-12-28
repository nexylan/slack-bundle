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

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nexy\Slack\Client;
use Nexy\SlackBundle\DependencyInjection\NexySlackExtension;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class NexySlackExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadWithNoConfiguration(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage('The child node "endpoint" at path "nexy_slack" must be configured.');

        $this->load();
    }

    public function testLoadWithMinimalConfiguration(): void
    {
        $endpoint = 'https://hooks.slack.com/services/XXXXX/XXXXX/XXXXXXXXXX';
        $slackConfig = [
            'markdown_in_attachments' => [],
            'sticky_channel' => false,
        ];

        $this->load([
            'endpoint' => $endpoint,
        ]);

        $this->assertContainerBuilderHasParameter('nexy_slack.endpoint', $endpoint);
        $this->assertContainerBuilderHasParameter('nexy_slack.config', $slackConfig);

        $this->assertContainerBuilderHasService(Client::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(Client::class, 0, new Reference('nexy_slack.http.client'));
        $this->assertContainerBuilderHasServiceDefinitionWithArgument(Client::class, 1, new Reference('nexy_slack.http.request_factory'));
        $this->assertContainerBuilderHasServiceDefinitionWithArgument(Client::class, 2, new Reference('nexy_slack.http.stream_factory'));
        $this->assertContainerBuilderHasServiceDefinitionWithArgument(Client::class, 3, '%nexy_slack.endpoint%');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument(Client::class, 4, '%nexy_slack.config%');

        $this->assertContainerBuilderHasAlias('nexy_slack.client', Client::class);
        $this->assertContainerBuilderHasAlias('nexy_slack.http.client', 'httplug.client');
        $this->assertContainerBuilderHasAlias('nexy_slack.http.request_factory', 'nexy_slack.request_factory.default');
        $this->assertContainerBuilderHasAlias('nexy_slack.http.stream_factory', 'nexy_slack.stream_factory.default');
    }

    public function testLoadWithCustomConfiguration(): void
    {
        $endpoint = 'https://hooks.slack.com/services/XXXXX/XXXXX/XXXXXXXXXX';
        $slackConfig = [
            'channel' => 'test',
            'markdown_in_attachments' => [],
            'sticky_channel' => false,
        ];

        $this->load([
            'http' => [
                'client' => 'httplug.curl',
            ],
            'endpoint' => $endpoint,
            'channel' => 'test',
        ]);

        $this->assertContainerBuilderHasParameter('nexy_slack.config', $slackConfig);
        $this->assertContainerBuilderHasAlias('nexy_slack.http.client', 'httplug.curl');
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions(): array
    {
        return [
            new NexySlackExtension(),
        ];
    }
}
