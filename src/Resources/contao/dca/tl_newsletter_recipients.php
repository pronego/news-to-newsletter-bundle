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
	'contact',
	'contact,salutation',
	$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default']
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default'] = str_replace
(
	'contact',
	'contact,surname',
	$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default']
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default'] = str_replace
(
	'contact',
	'contact,firstname',
	$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default']
);


/**
 * Add field to tl_newsletter_recipients
 */
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['fields']['salutation'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['salutation'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>true, 'rgxp'=>'digit', 'maxlength'=>8, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['fields']['surname'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['surname'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>true, 'rgxp'=>'digit', 'maxlength'=>50, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['fields']['firstname'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['firstname'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>true, 'rgxp'=>'digit', 'maxlength'=>50, 'tl_class'=>'w50')
);


