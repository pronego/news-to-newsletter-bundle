<?php


namespace Jl\NewsToNewsletterBundle;



/**
 * Provide methods to handle newsletters.
 *
 * @author Jonas Linn <https://github.com/euler271>
 */
class ModuleSubscribe extends \Contao\ModuleSubscribe
{
	protected  $strTemplate = 'nl_default_subscribe';

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		parent::compile();

		$this->Template->lastnameLabel = $GLOBALS['TL_LANG']['MSC']['lastname_label'];
		$this->Template->firstnameLabel = $GLOBALS['TL_LANG']['MSC']['firstname_label'];
		$this->Template->genderLabel = $GLOBALS['TL_LANG']['MSC']['gender_label'];
		$this->Template->genderOptions = $GLOBALS['TL_LANG']['MSC']['gender_options'];
	}

	protected function validateForm($objWidget=null)
	{
		$validated = parent::validateForm($objWidget);

		if($validated === false){
			return false;
		}

		$lastname = \Input::post('lastname');

		if(!\Validator::isAlphabetic($lastname)){
			$this->Template->mclass = 'error';
			$this->Template->message = $GLOBALS['TL_LANG']['ERR']['name'];
			return false;
		}

		$firstname = \Input::post('firstname');

		if(!\Validator::isAlphabetic($firstname)){
			$this->Template->mclass = 'error';
			$this->Template->message = $GLOBALS['TL_LANG']['ERR']['name'];
			return false;
		}

		$gender = \Input::post('gender');

		if(!\Validator::isAlphabetic($gender)){
			$this->Template->mclass = 'error';
			return false;
		}

		$validated[] = array(
			'firstname' => $firstname,
			'lastname' => $lastname,
			'gender' => $gender,
		);

		return $validated;
	}

	/**
	 * Add a new recipient
	 *
	 * @param string $strEmail
	 * @param array  $arrNew
	 * @param array  $personalInfo
	 */
	protected function addRecipient($strEmail, $arrNew, $personalInfo)
	{
		// Remove old subscriptions that have not been activated yet
		if (($objOld = \NewsletterRecipientsModel::findOldSubscriptionsByEmailAndPids($strEmail, $arrNew)) !== null)
		{
			while ($objOld->next())
			{
				$objOld->delete();
			}
		}

		$time = time();
		$strToken = md5(uniqid(mt_rand(), true));

		// Add the new subscriptions
		foreach ($arrNew as $id)
		{
			$objRecipient = new \NewsletterRecipientsModel();
			$objRecipient->pid = $id;
			$objRecipient->tstamp = $time;
			$objRecipient->email = $strEmail;
			$objRecipient->active = '';
			$objRecipient->addedOn = $time;
			$objRecipient->ip = $this->anonymizeIp(\Environment::get('ip'));
			$objRecipient->token = $strToken;
			$objRecipient->confirmed = '';
			$objRecipient->recipients_firstname = $personalInfo['firstname'];
			$objRecipient->recipients_lastname = $personalInfo['lastname'];
			$objRecipient->recipients_gender = $personalInfo['gender'];
			$objRecipient->save();

			// Remove the blacklist entry (see #4999)
			if (($objBlacklist = \NewsletterBlacklistModel::findByHashAndPid(md5($strEmail), $id)) !== null)
			{
				$objBlacklist->delete();
			}
		}

		// Get the channels
		$objChannel = \NewsletterChannelModel::findByIds($arrNew);

		// Prepare the simple token data
		$arrData = array();
		$arrData['token'] = $strToken;
		$arrData['domain'] = \Idna::decode(\Environment::get('host'));
		$arrData['link'] = \Idna::decode(\Environment::get('base')) . \Environment::get('request') . ((strpos(\Environment::get('request'), '?') !== false) ? '&' : '?') . 'token=' . $strToken;
		$arrData['channel'] = $arrData['channels'] = implode("\n", $objChannel->fetchEach('title'));
		$arrData['firstname'] = $personalInfo['firstname'];
		$arrData['lastname'] = $personalInfo['lastname'];
		$arrData['gender'] = $personalInfo['gender'];

		// Activation e-mail
		$objEmail = new \Email();
		$objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
		$objEmail->fromName = $GLOBALS['TL_ADMIN_NAME'];
		$objEmail->subject = sprintf($GLOBALS['TL_LANG']['MSC']['nl_subject'], \Idna::decode(\Environment::get('host')));
		$objEmail->text = \StringUtil::parseSimpleTokens($this->nl_subscribe, $arrData);
		$objEmail->sendTo($strEmail);

		// Redirect to the jumpTo page
		if ($this->jumpTo && ($objTarget = $this->objModel->getRelated('jumpTo')) instanceof PageModel)
		{
			/** @var PageModel $objTarget */
			$this->redirect($objTarget->getFrontendUrl());
		}

		\System::getContainer()->get('session')->getFlashBag()->set('nl_confirm', $GLOBALS['TL_LANG']['MSC']['nl_confirm']);

		$this->reload();

	}

}