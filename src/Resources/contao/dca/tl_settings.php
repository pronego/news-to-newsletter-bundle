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
 * System configuration
 */
 
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{ntonl_legend:hide},ntonl_news_groups,ntonl_nl_channel,ntonl_sender,ntonl_senderName,ntonl_submitText';
 
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

$GLOBALS['TL_DCA']['tl_settings']['fields']['ntonl_sender'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ntonl_sender'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'email', 'maxlength'=>128, 'decodeEntities'=>true, 'tl_class'=>'clr w50')
		);		

$GLOBALS['TL_DCA']['tl_settings']['fields']['ntonl_senderName'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ntonl_senderName'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'text',
			'eval'                    => array('decodeEntities'=>true, 'maxlength'=>128, 'tl_class'=>'w50')
		);

$GLOBALS['TL_DCA']['tl_settings']['fields']['ntonl_submitText'] = array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ntonl_submitText'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 11,
            'inputType'               => 'text',
            'eval'                    => array('decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'clr long')
        );