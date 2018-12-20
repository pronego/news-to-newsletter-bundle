<?php

/*
 * This file is part of bz-bbk-bundle.
 *
 * Copyright (c) 2004-2018 Sven Rhinow
 *
 * @license LGPL-3.0+
 */

namespace Srhinow\BzBbkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Adds the bundle services to the container.
 *
 * @author Sven Rhinow <https://gitlab.com/srhinow>
 */
class SrhinowBzBbkBundleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('listener.yml');

        //Setzen von globalen Variablen
        $container->setParameter('bn.testvalue','lorem ipsum...');
    }
}
