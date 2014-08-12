<?php


class ListingSearchForm extends Form {
	function __construct($controller, $name) {
		$context = singleton('Listing')->getCustomSearchContext();
        $fields = $context->getSearchFields();
        
        // Create actions
		$actions = new FieldList(
		   FormAction::create('doSearch', 'Search')->setUseButtonTag(true)
		);
		
		parent::__construct($controller, $name, $fields, $actions);
	}
	
	function forTemplate() {
	   return $this->renderWith(array(
	      $this->class,
	      'ListingSearchForm',
	      'Form'
	   ));
	}
	
	public function doSearch($data, $form) {
        $context = singleton('Listing')->getCustomSearchContext();
        $results = $context->getResults($data);
        return $this->customise(array(
            'Results' => $results
        ))->renderWith('Page_results');
    }
}