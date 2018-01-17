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

namespace Nexy\SlackBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nexy_slack');

        $rootNode
            ->children()
                ->arrayNode('http')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('client')->defaultValue('httplug.client')->end()
                    ->end()
                ->end()
                ->scalarNode('endpoint')
                    ->isRequired()->cannotBeEmpty()
                    ->info('The Slack API Incoming WebHooks URL.')
                ->end()
                ->scalarNode('channel')->end()
                ->scalarNode('username')->end()
                ->scalarNode('icon')->end()
                ->booleanNode('link_names')->end()
                ->booleanNode('unfurl_links')->end()
                ->booleanNode('unfurl_media')->end()
                ->booleanNode('allow_markdown')->end()
                ->arrayNode('markdown_in_attachments')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
