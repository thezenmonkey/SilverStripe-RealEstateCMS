<?php

class SimpleContactForm extends Form {
	
	public function __construct($controller, $name) {
        $fields = new FieldList(
            TextField::create("Name")->setAttribute('required', true),
            EmailField::create("Email")->setAttribute('type', 'email')->setAttribute('required', true),
            TextareaField::create("Company", "Message")->setAttribute('required', true)->setAttribute('autocomplete', 'no'),
            TextareaField::create("EmailMessage", "Company")->addExtraClass("honeypot")->setAttribute('autocomplete', 'no')
        );
        
        if(!class_exists('StaticPublisher')) {
	        $fields->insertAfter( HiddenField::create("TimeLog", '', time()), 'EmailMessage' );
        }
        
        $actions = new FieldList(FormAction::create("doSubmit")->setTitle("Submit"));
         
        parent::__construct($controller, $name, $fields, $actions);
    }
    
    function forTemplate() {
	   return $this->renderWith(array(
	      $this->class,
	      'Form'
	   ));
	}
    
    public function doSubmit(array $data, Form $form) {
	    //basic spam protection
	    if( $data['EmailMessage']  ) {
			$form->addErrorMessage('Message', 'We may have mistakenly marked your message as spam, please contact us via phone or email', 'warning');
			//Controller::curr()->redirectBack();
		}
		Debug::show($data);
		$siteConfig = SiteConfig::current_site_config();
		Debug::show($siteConfig);
		if($siteConfig->ContactFormFrom){
			$From = $siteConfig->ContactFormFrom;
		} else {
			$From = $data['Email'];
		}
		
		$To = $siteConfig->SiteEmail;
		$Subject = "Website Contact From ".$data['Name'];
		$Body = $data['Company']."<br>\n ".$data['Email'];
		$email = new Email($From, $To, $Subject,$Body, null, null, "rick@designplusawesome.com");
		//$email->send();
		//print_r($email->debug());
		$redirect = false;
		if($siteConfig->DefaultThankYouID != 0 && !$data['CustomThankYou']) {
			$redirect = ThankYouPage::get()->byID($siteConfig->DefaultThankYouID);
		} elseif ($data['CustomThankYou']) {
			$redirect = ThankYouPage::get()->byID($data['CustomThankYou']);
		}
		
		if($redirect){
			//Controller::curr()->redirect($redirect->URLSegment);
		} else {
			$form->addErrorMessage('Name', 'Thank you, someone from our office will contact you shortly', 'success');
			//Controller::curr()->redirectBack();
		}
		
		
    }
	
}