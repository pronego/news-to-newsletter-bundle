<?php

/**
 * @copyright  Sven Rhinow 2018 <https://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    NewsToNewsletterBundle
 * @license    LGPL
 * @see	       https://gitlab.com/srhinow/bz-bbk-bundle
 *
 */

namespace Srhinow\NewsToNewsletterBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

use Srhinow\NewsToNewsletterBundle\SrhinowNewsToNewsletterBundle;

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
            BundleConfig::create(SrhinowNewsToNewsletterBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
