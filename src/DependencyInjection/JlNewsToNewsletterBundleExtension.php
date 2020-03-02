<?php

/*
 * This file is part of news-to-newsletter-bundle.
 *
 * Copyright (c) 2004-2018 Sven Rhinow
 * Copyright (c) 2020 Jonas Linn
 *
 * @license LGPL-3.0+
 */

namespace Jl\NewsToNewsletterBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Adds the bundle services to the container.
 *
 * @author Sven Rhinow <https://gitlab.com/srhinow>
 * @author Jonas Linn <https://github.com/euler271/>
 */
class JlNewsToNewsletterBundleExtension extends Extension
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
//        $container->setParameter('bn.testvalue','lorem ipsum...');
    }
}
