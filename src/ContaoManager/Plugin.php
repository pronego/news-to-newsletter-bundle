<?php

/**
 * @copyright  Sven Rhinow 2018 <https://www.sr-tag.de>
 * @author     Sven Rhinow
 * @author     Jonas Lnn
 * @package    NewsToNewsletterBundle
 * @license    LGPL-3.0+
 * @see	       https://github.com/euler271/news-to-newsletter-bundle
 *
 */

namespace Jl\NewsToNewsletterBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

use Contao\NewsBundle\ContaoNewsBundle;
use Contao\NewsletterBundle\ContaoNewsletterBundle;
use Jl\NewsToNewsletterBundle\JlNewsToNewsletterBundle;

/**
 * Plugin for the Contao Manager.
 *
 * @author Sven Rhinow
 * @author Jonas Linn
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(JlNewsToNewsletterBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setLoadAfter([ContaoNewsletterBundle::class])
                ->setLoadAfter([ContaoNewsBundle::class])
        ];
    }
}
