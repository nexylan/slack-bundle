<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\SlackBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NexySlackExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $guzzleService = $config['guzzle_service'];
        $container->setParameter('nexy_slack.endpoint', $config['endpoint']);

        // Unset the not needed keys for the Slack config.
        unset($config['guzzle_service'], $config['endpoint']);

        $container->setParameter('nexy_slack.config', $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('client.xml');

        if ($guzzleService) {
            $container->getDefinition('nexy_slack.client')->addArgument(new Reference($guzzleService));
        }
    }
}
