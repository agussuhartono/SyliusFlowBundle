<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FlowBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass that registers all setups.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class RegisterSetupsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $setupBuilder = $container->getDefinition('sylius_flow.builder');

        foreach ($container->findTaggedServiceIds('sylius_flow.setup') as $id => $attributes) {
            $setupBuilder->addMethodCall('registerSetup', array($attributes[0]['alias'], new Reference($id)));
            $container->getDefinition($id)->addMethodCall('setAlias', array($attributes[0]['alias']));
        }
    }
}
