<?php

/**
 * PHP version 7
 * @copyright  Sven Rhinow Webentwicklung 2018 <http://www.sr-tag.de>
 * @copyright  Jonas Linn 2020
 * @author     Sven Rhinow
 * @author     Jonas Linn
 * @package    news-to-newsletter-bundle
 * @license    LGPL-3.0+
 * @filesource
 */

/**
 * System configuration
 */
 
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{ntonl_legend:hide},ntonl_news_groups,ntonl_nl_channel';
 
$GLOBALS['TL_DCA']['tl_settings']['fields']['ntonl_news_groups'] = array
		(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ntonl_news_groups'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'foreignKey'              => 'tl_news_archive.title',
		'eval'                    => array('multiple'=>true,'tl_class'=>'w50')
		);

$GLOBALS['TL_DCA']['tl_settings']['fields']['ntonl_nl_channel'] = array
		(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ntonl_nl_channel'],
		'exclude'                 => true,
		'inputType'               => 'radio',
		'foreignKey'              => 'tl_newsletter_channel.title',
		'eval'                    => array('multiple'=>false,'tl_class'=>'w50')
		);