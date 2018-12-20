<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow 2004-2016
 * @author     Sven Rhinow <http://www.sr-tag.de>
 * @package    newsletterFromNews
 * @license    LGPL
 * @filesource
 */
 
$GLOBALS['BE_MOD']['content']['newsletter']['stylesheet'] = 'system/modules/newsletterFromNews/assets/be.css'; 
$GLOBALS['BE_MOD']['content']['newsletter']['checkNewNewsletter'] = array('newsletterFromNews', 'checkNewNewsletter');

/**
 * Cron jobs
 */ 
#$GLOBALS['TL_CRON']['monthly'][] = array('newsletterFromNews', 'generateNL');
