<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow 2018
 * @author     Sven Rhinow <http://www.sr-tag.de>
 * @package    news-to-newsletter-bundle
 * @license    LGPL
 * @filesource
 */
$GLOBALS['N2NL']['PROPERTIES']['PUBLICSRC'] = 'bundles/srhinownewstonewsletter';

$GLOBALS['BE_MOD']['content']['newsletter']['stylesheet'] = $GLOBALS['N2NL']['PROPERTIES']['PUBLICSRC'].'/be.css';
$GLOBALS['BE_MOD']['content']['newsletter']['checkNewNewsletter'] = array('Srhinow\NewsToNewsletterBundle\NewsToNewsletter', 'checkNewNewsletter');

/**
 * Cron jobs
 */ 
#$GLOBALS['TL_CRON']['monthly'][] = array('newsletterFromNews', 'generateNL');
