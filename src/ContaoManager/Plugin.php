<?php

/**
 * @copyright  Sven Rhinow 2018 <https://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    BzBbkBundle
 * @license    comercial
 * @see	       https://gitlab.com/srhinow/bz-bbk-bundle
 *
 */

namespace Srhinow\BzBbkBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

use Srhinow\BzBbkBundle\SrhinowBzBbkBundle;

/**
 * Plugin for the Contao Manager.
 *
 * @author Sven Rhinow
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(SrhinowBzBbkBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
