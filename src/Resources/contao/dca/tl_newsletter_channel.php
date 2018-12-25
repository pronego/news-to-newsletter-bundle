<?php

/**
 * PHP version 7
 * @copyright  Sven Rhinow Webentwicklung 2018 <http://www.sr-tag.de>
 * @author     Sven Rhinow
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