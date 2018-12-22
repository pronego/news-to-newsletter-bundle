<?php 

/**
 * Table tl_news_archive
 */
 
$GLOBALS['TL_DCA']['tl_newsletter_channel']['list']['global_operations']['checkNewNewsletter'] = array
(
    'label'               => &$GLOBALS['TL_LANG']['tl_newsletter_channel']['checkNewNewsletter'],
    'href'                => 'key=checkNewNewsletter',
    'class'               => 'check_new_newsletter',
    'attributes'          => 'onclick="Backend.getScrollOffset();"'
);