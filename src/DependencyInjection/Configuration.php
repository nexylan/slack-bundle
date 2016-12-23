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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nexy_slack');

        $rootNode
            ->children()
                ->scalarNode('guzzle_service')
                    ->defaultNull()
                    ->info('If you want to use your own Guzzle instance, set the service here.')
                ->end()
                ->scalarNode('endpoint')
                    ->isRequired()->cannotBeEmpty()
                    ->info('The Slack API Incoming WebHooks URL.')
                ->end()
                ->scalarNode('channel')->defaultNull()->end()
                ->scalarNode('username')->defaultNull()->end()
                ->scalarNode('icon')->defaultNull()->end()
                ->booleanNode('link_names')->defaultFalse()->end()
                ->booleanNode('unfurl_links')->defaultFalse()->end()
                ->booleanNode('unfurl_media')->defaultTrue()->end()
                ->booleanNode('allow_markdown')->defaultTrue()->end()
                ->arrayNode('markdown_in_attachments')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
