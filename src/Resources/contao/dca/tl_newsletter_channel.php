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
 * Table tl_news_channel
 */
 
$GLOBALS['TL_DCA']['tl_newsletter_channel']['list']['global_operations']['checkNewNewsletter'] = array
(
    'label'               => &$GLOBALS['TL_LANG']['tl_newsletter_channel']['checkNewNewsletter'],
    'href'                => 'key=checkNewNewsletter',
    'class'               => 'check_new_newsletter',
    'attributes'          => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_newsletter_channel']['fields']['n2nl_template'] = array
(
	'label'					  => &$GLOBALS['TL_LANG']['tl_newsletter_channel']['n2nl_template'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'eval'                    => array('includeBlankOption'=>false, 'chosen'=>true, 'tl_class'=>'w50'),
	'options_callback' => static function ()
	{
		return Contao\Controller::getTemplateGroup('n2nl-mail_');
	},
	'sql'		=> "varchar(64) NOT NULL default ''"
);

/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_newsletter_channel']['palettes']['default'] = str_replace
(
	'template',
	'template,n2nl_template',
	$GLOBALS['TL_DCA']['tl_newsletter_channel']['palettes']['default']
);