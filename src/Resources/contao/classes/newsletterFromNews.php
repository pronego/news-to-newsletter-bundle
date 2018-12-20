<?php

/**
 * Class newsletterFromNews
 *
 * Provide methods regarding news archives.
 * @copyright  Sven Rhinow 2004-2016
 * @author     Sven Rhinow <http://www.sr-tag.de>
 * @package    newsletterFromNews
 */

class newsletterFromNews extends Backend
{
 	protected $NewsletterContent = '';
	protected $NewsletterText = '';

	/**
	 * Delete old files and generate all feeds
	 */
	public function generateNL($dbObj)
	{

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
		    	if (\ContentModel::countPublishedByPidAndTable($dbObj->id, 'tl_news') > 0)
		    	{
					$text = $this->getContentElementFromNews($dbObj->id);
		    	}

		    	//baut den Inhalt zusammen
			    $this->NewsletterContent .= '<h3>'.$dbObj->headline.'</h3>'.$text;
			    $this->NewsletterText .= "\n------------------------------------\n".$dbObj->headline."\n------------------------------------\n".strip_tags($text);

			    //UPDATE all exported News
			    $this->Database->prepare("UPDATE `tl_news` SET `tonl`= 0 WHERE `id`=? ")->execute($dbObj->id);
		    }

		    //Create new Newsletter with all relevant News
		    $set = array
		    (
				'pid' => $GLOBALS['TL_CONFIG']['ntonl_nl_channel'],
				'tstamp' => time(),
				'subject' => 'Newsletter-Ausgabe'.$GLOBALS['TL_CONFIG']['cron_monthly'].' der B&uuml;chereizentrale Niedersachsen',
				'alias' => 'nl-'.$GLOBALS['TL_CONFIG']['cron_monthly'],
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
	* holt den gesammlten Text der News-Inhaltselemente (> Contao 3.0)
	*/
	public function getContentElementFromNews($id)
	{
		$strText = '';
		$objElement = \ContentModel::findPublishedByPidAndTable($id, 'tl_news');

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

	    $objArchive = $this->Database->prepare("SELECT * FROM `tl_news` WHERE `tonl` = ? AND `published` = ? AND (`start` = '' OR `start` < ?) AND (`stop` = '' OR `stop` > ?) AND pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") ")
					     ->execute(1,1,$time,$time);
	    
	    if ($objArchive->numRows > 0)
	    {
			$this->generateNL($objArchive);
			$_SESSION['TL_ERROR'] = '';
			$_SESSION['TL_CONFIRM'][] = $GLOBALS['TL_LANG']['tl_newsletter']['newsletter_is_create'];
	    }
	    else
	    {
			$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['tl_newsletter']['newsletter_isnot_create'];
			$_SESSION['TL_CONFIRM'] = '';
	    }

	    setcookie('BE_PAGE_OFFSET', 0, 0, '/');
	    $this->redirect(str_replace('&key=checkNewNewsletter', '', $this->Environment->request));
	}
}
