<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\SlackBundle\Tests;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;
use Nexy\SlackBundle\NexySlackBundle;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class NexySlackBundleTest extends AbstractContainerBuilderTestCase
{
    /**
     * @var NexySlackBundle
     */
    protected $bundle;

    protected function setUp()
    {
        parent::setUp();

        $this->bundle = new NexySlackBundle();
    }

    public function testBuild()
    {
        $this->bundle->build($this->container);
    }
}
