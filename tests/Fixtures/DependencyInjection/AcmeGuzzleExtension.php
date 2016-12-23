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

namespace Nexy\SlackBundle\Tests\Fixtures\DependencyInjection;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Defines a fake Guzzle service for dependency injection tests.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AcmeGuzzleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->setDefinition('acme_guzzle', new Definition(Client::class, [[
            'timeout' => 42,
        ]]));
    }
}
