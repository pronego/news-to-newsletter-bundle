<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Sven Rhinow 2004-2012
 * @author     Sven Rhinow <http://www.sr-tag.de>
 * @package    newsletterFromNews
 * @license    LGPL
 * @filesource
 */

/**
 * System configuration
 */
 
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{ntnl_legend:hide},ntonl_news_groups,ntonl_nl_channel,ntonl_sender,ntonl_senderName';
 
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
			
?>