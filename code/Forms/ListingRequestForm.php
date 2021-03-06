<?php
/**
 * 	
 * @package Contact Form 
 * @requires 
 * @author Richard Rudy twitter:@thezenmonkey web: http://designplusawesome.com
 */

class ListingRequestForm extends Form {
	function __construct($controller, $name) {
		// Create fields
		$fields = new FieldList(
			TextField::create('Name')->setAttribute('required', true)->setCustomValidationMessage("Please include your name", "error"),
			EmailField::create('Email','E-Mail Address')->setAttribute('required', true)->setCustomValidationMessage("Please include your email address", "error"),
			TextField::create('Phone'),
			TextareaField::create("Company", "Message", "Please send me more information about ".$controller->Address)->setAttribute('autocomplete', 'no'),
			HiddenField::create('Address', '', $controller->Address),
			HiddenField::create('ID', '', $controller->ID),
			HiddenField::create('HiddenMLS', 'HiddenMLS', $controller->MLS)
		);
		
		// Create actions
		$actions = new FieldList(
		   FormAction::create('doSubmit', 'Submit')->setUseButtonTag(true)
		);
		
		if($controller->ClassName == "MLSListing") {
			$controller = MLSListingsPage::get()->First();
		}
		$validation = new RequiredFields(array('Email'));
		
		parent::__construct($controller, $name, $fields, $actions, $validation);
	}
	
	function forTemplate() {
	   return $this->renderWith(array(
	      $this->class,
	      'ListingRequestForm',
	      'Form'
	   ));
	}
	
	function doSubmit($data, $form) {
		
		//Set data
		$siteConfig = SiteConfig::current_site_config();
		if($siteConfig->ContactFormFrom){
			$From = $siteConfig->ContactFormFrom;
		} else {
			$From = $data['Email'];
		}
		
		$To = $siteConfig->SiteEmail;
		$Subject = "Viewing Request ".$data['Address']." From ".$data['Name'];
		$Body = nl2br($data['Company'])."<br>\n ".$data['Email'];
		
		$email = new Email($From, $To, $Subject,$Body);
		$email->send();
		
		$redirect = false;
		if($siteConfig->DefaultThankYouID != 0 && !$data['CustomThankYou']) {
			$redirect = ThankYouPage::get()->byID($siteConfig->DefaultThankYouID);
		} elseif ($data['CustomThankYou']) {
			$redirect = ThankYouPage::get()->byID($data['CustomThankYou']);
		}
		
		if($redirect){
			Controller::curr()->redirect($redirect->URLSegment);
		} else {
			$form->addErrorMessage('Message', 'Thank you, someone from our office will contact you shortly', 'success');
			Controller::curr()->redirectBack();
		}
	}
}