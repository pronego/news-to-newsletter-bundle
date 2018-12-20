<?php

/**
 * @copyright  Sven Rhinow <https://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    BzBbkBundle
 *
 */

namespace Srhinow\BzBbkBundle;


use Srhinow\BzBbkBundle\DependencyInjection\SrhinowBzBbkBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Configures the Contao contao-blank-bundle.
 *
 * @author Sven Rhinow
 */
class SrhinowBzBbkBundle extends Bundle
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
        return new SrhinowBzBbkBundleExtension();
    }
}
