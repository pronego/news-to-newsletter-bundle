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
namespace Jl\NewsToNewsletterBundle;

use Contao\Backend;
use Contao\ContentModel;
use Contao\Message;
use Contao\System;
use Psr\Log\LogLevel;

class NewsToNewsletter extends Backend
{
 	protected $NewsletterContent = '';
	protected $NewsletterText = '';

	/**
	 * create newsletter from news text-field(s)
	 */
	public function generateNL($dbObj)
	{
        $this->loadLanguageFile('tl_newsletter');
        $nlChannel = (int) $GLOBALS['TL_CONFIG']['ntonl_nl_channel'];

	    if($nlChannel < 1) {
            Message::addError($GLOBALS['TL_LANG']['tl_newsletter']['newsletter_check_settings']);
            $logger = System::getContainer()->get('monolog.logger.contao');
            $logger->log(LogLevel::ERROR, $GLOBALS['TL_LANG']['tl_newsletter']['newsletter_check_settings']);

            $this->redirect(str_replace('&key=checkNewNewsletter', '', $this->Environment->request));
        }

		$objChannel = \NewsletterChannelModel::findByIds(array($nlChannel))[0];

	    $content = array();

		if ($dbObj->numRows > 0)
		{
		    while ($dbObj->next())
		    {
		    	$text = '';

		    	// beruecksichtigt das alte Verfahren, wie bis Contao 2.x
		    	if(strlen($dbObj->text) > 0) $text = $dbObj->text;

		    	// beruecksichtigt das Modul simpleNews
		    	if(strlen($dbObj->newsText) > 0) $text = $dbObj->newsText;

		    	// holt wenn vorhanden den Inhalt der Inhaltselemente zu der News, wie ab Contao 3.x
		    	if (ContentModel::countPublishedByPidAndTable($dbObj->id, 'tl_news') > 0)
		    	{
					$text = $this->getContentElementFromNews($dbObj->id);
		    	}

		    	//baut den Inhalt zusammen
			    //$this->NewsletterContent .= '<h3>'.$dbObj->headline.'</h3>'.$text;
		    	$content[] = array('headline' => $dbObj->headline, "text" => $text);
			    $this->NewsletterText .= "\n------------------------------------\n".$dbObj->headline."\n------------------------------------\n".strip_tags($text);

			    //UPDATE all exported News
			    $this->Database->prepare("UPDATE `tl_news` SET `ntonl`= 0 WHERE `id`=? ")->execute($dbObj->id);
		    }

		    //Find the template or use the default

			if(!$objChannel->n2nl_template){
				$template = "n2nl-mail";
			}else{
				$template = $objChannel->n2nl_template;
			}

		    //Generate the HTML Newsletter Content from the Template
			$template             = new \BackendTemplate($template);
			$template->wildcard   = "### MailTemplate ###";
			$template->content	  = $content;
			$this->NewsletterContent = $template->parse();

		    //Create new Newsletter with all relevant News
		    $set = array
		    (
				'pid' => $GLOBALS['TL_CONFIG']['ntonl_nl_channel'],
				'tstamp' => time(),
				'subject' => htmlentities(sprintf($GLOBALS['TL_CONFIG']['ntonl_submitText'],date('m-Y'))),
				'alias' => 'nl-'.date('dmY-His'),
				'content' => $this->NewsletterContent,
				'text' => $this->NewsletterText,
				'sender' => $GLOBALS['TL_CONFIG']['ntonl_sender'],
				'senderName' => $GLOBALS['TL_CONFIG']['ntonl_senderName']
		    );

		    $this->Database->prepare("INSERT INTO `tl_newsletter` %s ")
				   ->set($set)
				   ->execute();
		}
	}

	/**
	* holt den gesammelten Text der News-Inhaltselemente (> Contao 3.0)
	*/
	public function getContentElementFromNews($id)
	{
		$strText = '';
		$objElement = ContentModel::findPublishedByPidAndTable($id, 'tl_news');

		if ($objElement !== null)
		{
			while ($objElement->next())
			{
				$strText .= $this->getContentElement($objElement->current());
			}
		}

		return $strText;
	}

	/**
	* manuell check News for Newsletter
	*/
	public function checkNewNewsletter()
	{
	    $time = time();
	    $this->loadLanguageFile('tl_newsletter');

	    $this->news_archives = deserialize($GLOBALS['TL_CONFIG']['ntonl_news_groups']);

	    if(!is_array($this->news_archives) || count($this->news_archives) < 1) {
            Message::addError($GLOBALS['TL_LANG']['tl_newsletter']['newsletter_check_settings']);
            $logger = System::getContainer()->get('monolog.logger.contao');
            $logger->log(LogLevel::ERROR, $GLOBALS['TL_LANG']['tl_newsletter']['newsletter_check_settings']);

            $this->redirect(str_replace('&key=checkNewNewsletter', '', $this->Environment->request));
        }

	    $objArchive = $this->Database->prepare("SELECT * FROM `tl_news` WHERE `ntonl` = ? AND `published` = ? AND (`start` = '' OR `start` < ?) AND (`stop` = '' OR `stop` > ?) AND pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") ")
					     ->execute(1,1,$time,$time);
	    
	    if ($objArchive->numRows > 0)
	    {
			$this->generateNL($objArchive);

            Message::addConfirmation($GLOBALS['TL_LANG']['tl_newsletter']['newsletter_created']);
            $logger = System::getContainer()->get('monolog.logger.contao');
            $logger->log(LogLevel::ALERT, $GLOBALS['TL_LANG']['tl_newsletter']['newsletter_created']);
	    }
	    else
	    {
            Message::addInfo($GLOBALS['TL_LANG']['tl_newsletter']['newsletter_not_created']);
            $logger = System::getContainer()->get('monolog.logger.contao');
            $logger->log(LogLevel::ALERT, $GLOBALS['TL_LANG']['tl_newsletter']['newsletter_not_created']);
	    }

	    setcookie('BE_PAGE_OFFSET', 0, 0, '/');
	    $this->redirect(str_replace('&key=checkNewNewsletter', '', $this->Environment->request));
	}
}
