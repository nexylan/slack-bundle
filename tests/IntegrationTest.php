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

namespace Nexy\SlackBundle\Tests;

use Http\HttplugBundle\HttplugBundle;
use Nexy\Slack\Client;
use Nexy\SlackBundle\NexySlackBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollectionBuilder;

class IntegrationTest extends TestCase
{
    public function testServiceIntegration(): void
    {
        $kernel = new NexySlackIntegrationTestKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        // sanity check on service wiring
        $client = $container->get('nexy_slack.client');
        $this->assertInstanceOf(Client::class, $client);
    }
}

abstract class AbstractNexySlackIntegrationTestKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new NexySlackBundle(),
            new HttplugBundle(),
        ];
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir().'/cache'.spl_object_hash($this);
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir().'/logs'.spl_object_hash($this);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->loadFromExtension('framework', [
            'secret' => 'foo',
        ]);

        $container->loadFromExtension('nexy_slack', [
            'endpoint' => 'http://localhost',
        ]);
    }
}

if (method_exists(AbstractNexySlackIntegrationTestKernel::class, 'configureRouting')) {
    class NexySlackIntegrationTestKernel extends AbstractNexySlackIntegrationTestKernel
    {
        protected function configureRouting(RoutingConfigurator $routes): void
        {
        }
    }
} else {
    class NexySlackIntegrationTestKernel extends AbstractNexySlackIntegrationTestKernel
    {
        protected function configureRoutes(RouteCollectionBuilder $routes): void
        {
        }
    }
}
