<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow 2018
 * @copyright  Jonas Linn 2020
 * @author     Sven Rhinow <http://www.sr-tag.de>
 * @author     Jonas Linn
 * @package    news-to-newsletter-bundle
 * @license    LGPL-3.0+
 * @filesource
 */
$GLOBALS['N2NL']['PROPERTIES']['PUBLICSRC'] = 'bundles/jlnewstonewsletter';

$GLOBALS['BE_MOD']['content']['newsletter']['stylesheet'] = $GLOBALS['N2NL']['PROPERTIES']['PUBLICSRC'].'/be.css';
$GLOBALS['BE_MOD']['content']['newsletter']['checkNewNewsletter'] = array('Jl\NewsToNewsletterBundle\NewsToNewsletter', 'checkNewNewsletter');

/**
 * Cron jobs
 */ 
#$GLOBALS['TL_CRON']['monthly'][] = array('newsletterFromNews', 'generateNL');
