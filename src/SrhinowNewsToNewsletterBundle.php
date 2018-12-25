<?php

/**
 * @copyright  Sven Rhinow <https://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    NewsToNewsletterBundle
 * @license    LGPL-3.0+
 *
 */

namespace Srhinow\NewsToNewsletterBundle;


use Srhinow\NewsToNewsletterBundle\DependencyInjection\SrhinowNewsToNewsletterBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Configures the Contao contao-blank-bundle.
 *
 * @author Sven Rhinow
 */
class SrhinowNewsToNewsletterBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new SrhinowNewsToNewsletterBundleExtension();
    }
}
