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

use Maknz\Slack\Client;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nexy\SlackBundle\DependencyInjection\NexySlackExtension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class NexySlackExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "endpoint" at path "nexy_slack" must be configured.
     */
    public function testLoadWithNoConfiguration()
    {
        $this->load();
    }

    public function testLoadWithMinimalConfiguration()
    {
        $endpoint = 'https://hooks.slack.com/services/XXXXX/XXXXX/XXXXXXXXXX';
        $slackConfig = [
            'channel' => null,
            'username' => null,
            'icon' => null,
            'link_names' => false,
            'unfurl_links' => false,
            'unfurl_media' => true,
            'allow_markdown' => true,
            'markdown_in_attachments' => [],
        ];

        $this->load([
            'endpoint' => $endpoint,
        ]);

        $this->assertContainerBuilderHasParameter('nexy_slack.endpoint', $endpoint);
        $this->assertContainerBuilderHasParameter('nexy_slack.config', $slackConfig);

        $this->assertContainerBuilderHasService('nexy_slack.client', Client::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument('nexy_slack.client', 0, '%nexy_slack.endpoint%');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('nexy_slack.client', 1, '%nexy_slack.config%');

        $this->assertSame($endpoint, $this->container->get('nexy_slack.client')->getEndPoint());
        $this->assertSame($slackConfig['channel'], $this->container->get('nexy_slack.client')->getDefaultChannel());
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
