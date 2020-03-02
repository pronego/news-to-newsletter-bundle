<?php


namespace Jl\NewsToNewsletterBundle;



/**
 * Provide methods to handle newsletters.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class Newsletter extends \Contao\Newsletter
{
	/**
	 * Return a form to choose an existing CSV file and import it
	 *
	 * @param DataContainer $dc
	 *
	 * @return string
	 */
	public function send(\Contao\DataContainer $dc)
	{
		return parent::send($dc);
	}

	protected function sendNewsletter($objEmail, $objNewsletter, $arrRecipient, $text, $html, $css=null)
	{
		if(!$arrRecipient['gender']){
			$arrRecipient['gender'] = $arrRecipient['recipients_gender'];
		}

		if(!$arrRecipient['firstname']){
			$arrRecipient['firstname'] = $arrRecipient['recipients_firstname'];
		}

		if(!$arrRecipient['lastname']){
			$arrRecipient['lastname'] = $arrRecipient['recipients_lastname'];
		}

		parent::sendNewsletter($objEmail, $objNewsletter, $arrRecipient, $text, $html, $css);
	}
}