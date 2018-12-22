<?php
/**
 * PHP version 7
 * @copyright  Sven Rhinow Webentwicklung 2018 <http://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    news-to-newsletter-bundle
 * @license    LGPL
 * @filesource
 */


/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('published', 'published,ntonl', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);



/**
 * Add fields to tl_news
 */
$GLOBALS['TL_DCA']['tl_news']['fields']['ntonl'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['ntonl'],
    'exclude'                 => true,
    'filter'                  => true,
    'flag'                    => 1,
    'inputType'               => 'checkbox',
    'eval'                    => array('doNotCopy'=>true, 'tl_class'=>''),
    'sql'                     => "char(1) NOT NULL default ''"
);
