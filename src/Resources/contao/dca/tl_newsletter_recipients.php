<?php

/**
 * PHP version 7
 * @copyright  Jonas Linn 2020
 * @author     Jonas Linn
 * @package    news-to-newsletter-bundle
 * @license    LGPL-3.0+
 * @filesource
 */

/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default'] = str_replace
(
	'active',
	'active,recipients_lastname',
	$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default']
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default'] = str_replace
(
	'active',
	'active,recipients_firstname',
	$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default']
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default'] = str_replace
(
	'active',
	'active,recipients_gender',
	$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default']
);


/**
 * Add field to tl_newsletter_recipients
 * ['value1' => 'label1', 'value2' => 'label2']
 */
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['fields']['recipients_gender'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['gender'],
	'exclude'   => true,
	'inputType' => 'select',
	'options'	=> array(
		'male' => $GLOBALS['TL_LANG']['tl_newsletter_recipients']['gender_options']['male'],
		'female' => $GLOBALS['TL_LANG']['tl_newsletter_recipients']['gender_options']['female'],
		'other' => $GLOBALS['TL_LANG']['tl_newsletter_recipients']['gender_options']['other'],
	),
	'eval'      => array('mandatory'=>true, 'rgxp'=>'alpha', 'maxlength'=>8, 'tl_class'=>'w50'),
	'sql'		=> "varchar(8) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['fields']['recipients_lastname'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['lastname'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>true, 'rgxp'=>'alpha', 'maxlength'=>50, 'tl_class'=>'w50'),
	'sql'		=> "varchar(50) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['fields']['recipients_firstname'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['firstname'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>true, 'rgxp'=>'alpha', 'maxlength'=>50, 'tl_class'=>'w50'),
	'sql'		=> "varchar(50) NOT NULL default ''"
);


