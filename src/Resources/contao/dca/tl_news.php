<?php

/**
 * @copyright  Sven Rhinow 2004-2016
 * @author     Sven Rhinow <http://www.sr-tag.de>
 * @package    newsletterFromNews
 * @license    LGPL
 * @filesource
 */


/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('published', 'published,tonl', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);


/**
 * Add fields to tl_news
 */
$GLOBALS['TL_DCA']['tl_news']['fields']['tonl'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['tonl'],
    'exclude'                 => true,
    'filter'                  => true,
    'flag'                    => 1,
    'inputType'               => 'checkbox',
    'eval'                    => array('doNotCopy'=>true, 'tl_class'=>'clr w50')
);
