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

        $this->assertContainerBuilderHasService('Nexy\Slack\Client', Client::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument('Nexy\Slack\Client', 0, '%nexy_slack.endpoint%');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('Nexy\Slack\Client', 1, '%nexy_slack.config%');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('Nexy\Slack\Client', 2, new Reference('nexy_slack.http.client'));

        $this->assertContainerBuilderHasAlias('nexy_slack.http.client', 'httplug.client');
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
    protected function getContainerExtensions()
    {
        return [
            new NexySlackExtension(),
        ];
    }
}
