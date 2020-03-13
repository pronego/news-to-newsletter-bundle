<?php


namespace Jl\NewsToNewsletterBundle;

use Contao\Input;
use Contao\FileUpload;
use Contao\File;

/**
 * Provide methods to handle newsletters.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class Newsletter extends \Contao\Newsletter
{
	/**
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

	/**
	 * Return a form to choose a CSV file and import it
	 *
	 * @return string
	 */
	public function importRecipients()
	{
		if (Input::get('key') != 'import')
		{
			return '';
		}

		/** @var FileUpload $objUploader */
		$objUploader = new FileUpload();

		// Import recipients
		if (Input::post('FORM_SUBMIT') == 'tl_recipients_import')
		{
			$arrUploaded = $objUploader->uploadTo('system/tmp');

			if (empty($arrUploaded))
			{
				Message::addError($GLOBALS['TL_LANG']['ERR']['all_fields']);
				$this->reload();
			}

			$time = time();
			$intTotal = 0;
			$intInvalid = 0;

			foreach ($arrUploaded as $strCsvFile)
			{
				$objFile = new File($strCsvFile);

				if ($objFile->extension != 'csv')
				{
					Message::addError(sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $objFile->extension));
					continue;
				}

				// Get separator
				switch (Input::post('separator'))
				{
					case 'semicolon':
						$strSeparator = ';';
						break;

					case 'tabulator':
						$strSeparator = "\t";
						break;

					case 'linebreak':
						$strSeparator = "\n";
						break;

					default:
						$strSeparator = ',';
						break;
				}

				$arrRecipients = array();
				$resFile = $objFile->handle;

				while (($arrRow = @fgetcsv($resFile, null, $strSeparator)) !== false)
				{
					$arrRecipients[] = $arrRow;
				}

				//var_dump($arrRecipients);

				/*
				if (!empty($arrRecipients))
				{
					$arrRecipients = array_merge(...$arrRecipients);
				}

				$arrRecipients = array_filter(array_unique($arrRecipients));
				*/

				foreach ($arrRecipients as $arrRecipient)
				{
					$strRecipient = $arrRecipient[0];
					$surname = $arrRecipient[1];
					$name = $arrRecipient[2];
					$gender = $arrRecipient[3];


					// Skip invalid entries
					if (!\Validator::isEmail($strRecipient))
					{
						$this->log('The recipient address "' . $strRecipient . '" seems to be invalid and was not imported', __METHOD__, TL_ERROR);
						++$intInvalid;
						continue;
					}

					// Check whether the e-mail address exists
					$objRecipient = $this->Database->prepare("SELECT COUNT(*) AS count FROM tl_newsletter_recipients WHERE pid=? AND email=?")
						->execute(Input::get('id'), $strRecipient);

					if ($objRecipient->count > 0)
					{
						continue;
					}

					// Check whether the e-mail address has been blacklisted
					$objBlacklist = $this->Database->prepare("SELECT COUNT(*) AS count FROM tl_newsletter_blacklist WHERE pid=? AND hash=?")
						->execute(Input::get('id'), md5($strRecipient));

					if ($objBlacklist->count > 0)
					{
						$this->log('Recipient "' . $strRecipient . '" has unsubscribed from channel ID "' . Input::get('id') . '" and was not imported', __METHOD__, TL_ERROR);
						continue;
					}

					//Validate Name
					if(!\Validator::isAlphabetic($surname)){
						$this->log('Names must be alphabetic. The entry '.$name.' '.$surname.' '.$strRecipient.' '.'('.$gender.') was not imported' , __METHOD__, TL_ERROR);
					}

					if(!\Validator::isAlphabetic($name)){
						$this->log('Names must be alphabetic. The entry '.$name.' '.$surname.' '.$strRecipient.' '.'('.$gender.') was not imported' , __METHOD__, TL_ERROR);
					}

					if(!\Validator::isAlphabetic($gender) || in_array($gender, array('male', 'female', 'other'))){
						$this->log('Gender must either be male, female or other. The entry '.$name.' '.$surname.' '.$strRecipient.' '.'('.$gender.') was not imported' , __METHOD__, TL_ERROR);
					}

					$this->Database->prepare("INSERT INTO tl_newsletter_recipients SET pid=?, tstamp=$time, email=?, recipients_lastname=?, recipients_firstname=?, recipients_gender=?, active=1")
						->execute(Input::get('id'), $strRecipient, $surname, $name, $gender);

					++$intTotal;

				}
			}

			\Message::addConfirmation(sprintf($GLOBALS['TL_LANG']['tl_newsletter_recipients']['confirm'], $intTotal));

			if ($intInvalid > 0)
			{
				\Message::addInfo(sprintf($GLOBALS['TL_LANG']['tl_newsletter_recipients']['invalid'], $intInvalid));
			}

			$this->reload();
		}

		// Return form
		return '
<div id="tl_buttons">
<a href="' . ampersand(str_replace('&key=import', '', \Environment::get('request'))) . '" class="header_back" title="' . \StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']) . '" accesskey="b">' . $GLOBALS['TL_LANG']['MSC']['backBT'] . '</a>
</div>
' . \Message::generate() . '
<form action="' . ampersand(\Environment::get('request'), true) . '" id="tl_recipients_import" class="tl_form tl_edit_form" method="post" enctype="multipart/form-data">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="tl_recipients_import">
<input type="hidden" name="REQUEST_TOKEN" value="' . REQUEST_TOKEN . '">
<input type="hidden" name="MAX_FILE_SIZE" value="' . \Config::get('maxFileSize') . '">
<fieldset class="tl_tbox nolegend">
  <div class="widget w50">
    <h3><label for="separator">' . $GLOBALS['TL_LANG']['MSC']['separator'][0] . '</label></h3>
    <select name="separator" id="separator" class="tl_select" onfocus="Backend.getScrollOffset()">
      <option value="comma">' . $GLOBALS['TL_LANG']['MSC']['comma'] . '</option>
      <option value="semicolon">' . $GLOBALS['TL_LANG']['MSC']['semicolon'] . '</option>
      <option value="tabulator">' . $GLOBALS['TL_LANG']['MSC']['tabulator'] . '</option>
      <option value="linebreak">' . $GLOBALS['TL_LANG']['MSC']['linebreak'] . '</option>
    </select>' . (($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '
    <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['MSC']['separator'][1] . '</p>' : '') . '
  </div>
  <div class="widget clr">
    <h3>' . $GLOBALS['TL_LANG']['MSC']['source'][0] . '</h3>' . $objUploader->generateMarkup() . (isset($GLOBALS['TL_LANG']['MSC']['source'][1]) ? '
    <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['MSC']['source'][1] . '</p>' : '') . '
  </div>
</fieldset>
</div>
<div class="tl_formbody_submit">
<div class="tl_submit_container">
  <button type="submit" name="save" id="save" class="tl_submit" accesskey="s">' . $GLOBALS['TL_LANG']['tl_newsletter_recipients']['import'][0] . '</button>
</div>
</div>
</form>';
	}
}