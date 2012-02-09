<?php
/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
 * 
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once dirname(__FILE__).'/../../Tracker_FormElement_Visitor.class.php';

/**
 * Can visit a FormElement and provides the corresponding administration element 
 */
class Tracker_FormElement_View_Admin_Visitor implements Tracker_FormElement_Visitor {
    /**
     * @var Tracker_FormElement_View_Admin
     */
    private $adminElement = null;
    
    /**
     * @var Tracker_FormElement 
     */
    private $element = null;
    
    private $allUsedElements = array();
    
    /**
     * Constructor needs the list all used FormElements (to rank the element in the page)
     * 
     * @param Array $allUsedElements 
     */
    public function __construct($allUsedElements) {
        $this->allUsedElements = $allUsedElements;
    }
    
    /**
     * Inspect the element
     * 
     * @param Tracker_FormElement $element 
     */
    public function visit(/*Tracker_FormElement*/ $element) {
        $this->element = $element;
        
        if ($element instanceof Tracker_FormElement_Field_MultiSelectbox) {
            $this->visitMultiSelectbox($element);
        } elseif ($element instanceof Tracker_FormElement_Field_Selectbox) {
            $this->visitSelectbox($element);
        } elseif ($element instanceof Tracker_FormElement_Field_SubmittedBy) {
            $this->visitSubmittedBy($element);
        } elseif ($element instanceof Tracker_FormElement_Field_List) {
            $this->visitList($element);
        } elseif ($element instanceof Tracker_FormElement_Field_ArtifactId) {
            $this->visitArtifactId($element);
        } elseif ($element instanceof Tracker_FormElement_Field_CrossReferences) {
            $this->visitCrossReferences($element);
        } elseif ($element instanceof Tracker_FormElement_Field_LastUpdateDate) {
            $this->visitLastUpdateDate($element);
        } elseif ($element instanceof Tracker_FormElement_Field_PermissionsOnArtifact) {
            $this->visitPermissionsOnArtifact($element);
        } elseif ($element instanceof Tracker_FormElement_Field_SubmittedOn) {
            $this->visitSubmittedOn($element);
        } elseif ($element instanceof Tracker_FormElement_Field) {
            $this->visitField($element);
        } elseif ($element instanceof Tracker_FormElement_Container) {
            $this->visitContainer($element);
        } elseif ($element instanceof Tracker_FormElement_StaticField_LineBreak) {
            $this->visitLineBreak($element);
        } elseif ($element instanceof Tracker_FormElement_StaticField_Separator) {
            $this->visitSeparator($element);
        } elseif ($element instanceof Tracker_FormElement_StaticField) {
            $this->visitStaticField($element);
        } elseif ($element instanceof Tracker_FormElement_Shared) {
            $this->visitShared($element);
        } else {
            throw new Exception("Cannot visit unknown type");
        }
    }

    private function visitField(Tracker_FormElement_Field $element) {
        include_once 'Field.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field($element, $this->allUsedElements);
    }
    
    private function visitArtifactId(Tracker_FormElement_Field_ArtifactId $element) {
        include_once 'Field/ArtifactId.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_ArtifactId($element, $this->allUsedElements);
    }
    
    private function visitCrossReferences(Tracker_FormElement_Field_CrossReferences $element) {
        include_once 'Field/CrossReferences.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_CrossReferences($element, $this->allUsedElements);
    }
    
    private function visitLastUpdateDate(Tracker_FormElement_Field_LastUpdateDate $element) {
        include_once 'Field/LastUpdateDate.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_LastUpdateDate($element, $this->allUsedElements);
    }
    
    private function visitPermissionsOnArtifact(Tracker_FormElement_Field_PermissionsOnArtifact $element) {
        include_once 'Field/PermissionsOnArtifact.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_PermissionsOnArtifact($element, $this->allUsedElements);
    }
    
    private function visitList(Tracker_FormElement_Field_List $element) {
        include_once 'Field/List.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_List($element, $this->allUsedElements);
    }
    
    private function visitSelectbox(Tracker_FormElement_Field_Selectbox $element) {
        include_once 'Field/Selectbox.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_Selectbox($element, $this->allUsedElements);
    }

    private function visitSubmittedBy(Tracker_FormElement_Field_SubmittedBy $element) {
        include_once 'Field/SubmittedBy.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_SubmittedBy($element, $this->allUsedElements);
    }
    
    private function visitSubmittedOn(Tracker_FormElement_Field_SubmittedOn $element) {
        include_once 'Field/SubmittedOn.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_SubmittedOn($element, $this->allUsedElements);
    }
    
    private function visitMultiSelectbox(Tracker_FormElement_Field_MultiSelectbox $element) {
        include_once 'Field/MultiSelectbox.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Field_MultiSelectbox($element, $this->allUsedElements);
    }
    
    private function visitContainer(Tracker_FormElement_Container $element) {
        include_once 'Container.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Container($element, $this->allUsedElements);
    }
    
    private function visitStaticField(Tracker_FormElement_StaticField $element) {
        include_once 'StaticField.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_StaticField($element, $this->allUsedElements);
    }
    
    private function visitLineBreak(Tracker_FormElement_StaticField_LineBreak $element) {
        include_once 'StaticField/LineBreak.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_StaticField_LineBreak($element, $this->allUsedElements);
    }
    
    private function visitSeparator(Tracker_FormElement_StaticField_Separator $element) {
        include_once 'StaticField/Separator.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_StaticField_Separator($element, $this->allUsedElements);
    }
    
    private function visitShared(Tracker_FormElement_Shared $element) {
        include_once 'Shared.class.php';
        $this->adminElement = new Tracker_FormElement_View_Admin_Shared($element, $this->allUsedElements);
    }
    
    /**
     * Return the AdminEdition element corresponding to the visited element
     * 
     * Mostly used for tests.
     * 
     * @return Tracker_FormElement_View_Admin
     */
    public function getAdmin() {
        return $this->adminElement;
    }
    
    /**
     * Return html corresponding to FormElement creation
     * 
     * @return String
     */
    public function fetchCreateForm() {
        return $this->adminElement->fetchAdminForCreate();
    }
    
    /**
     * Return html corresponding to FormElement update
     * 
     * @return String
     */
    public function fetchUpdateForm() {
        if ($this->element->isModifiable()) {
            return $this->adminElement->fetchAdminForUpdate();
        } else {
            return $this->adminElement->fetchAdminForShared();
        }
    }
    
    
    /**
     * Display the form to create a new formElement
     * 
     * @param TrackerManager  $tracker_manager The service
     * @param HTTPRequest     $request         The data coming from the user
     * @param string          $type            The internal name of type of the field
     * @param string          $factory_label   The label of the field (At factory 
     *                                         level 'Selectbox, File, ...')
     *
     * @return void
     */
    public function displayCreateForm(TrackerManager $tracker_manager, HTTPRequest $request, $type, $factory_label) {
        $hp               = Codendi_HTMLPurifier::instance();
        $title            = 'Create a new '. $factory_label;
        $url              = TRACKER_BASE_URL.'/?tracker='. (int)$this->element->getTracker()->getId() .'&amp;func=admin-formElements&amp;create-formElement['.  $hp->purify($type, CODENDI_PURIFIER_CONVERT_HTML) .']=1';
        $breadcrumbsLabel = $title;
        echo $this->displayForm($tracker_manager, $request, $breadcrumbsLabel, $url, $title, $this->fetchCreateForm());
    }
    
    
    /**
     * Display the form to administrate the element
     * 
     * @param TrackerManager  $tracker_manager The tracker manager
     * @param HTTPRequest     $request         The data coming from the user
     * 
     * @return void
     */
    public function displayUpdateForm(TrackerManager $tracker_manager, HTTPRequest $request) {
        $label            = $this->element->getLabel();
        $title            = $GLOBALS['Language']->getText('plugin_tracker_include_type', 'upd_label', $label);
        $url              = $this->element->getAdminEditUrl();
        $breadcrumbsLabel = $label;
        echo $this->displayForm($tracker_manager, $request, $breadcrumbsLabel, $url, $title, $this->fetchUpdateForm());
    }
    
    private function displayForm(TrackerManager $tracker_manager, HTTPRequest $request, $breadcrumbsLabel, $url, $title, $formContent) {
        $form  = '<form name="form1" method="POST" action="'. $url .'">';
        $form .= $formContent;
        $form .= '</form>';
        
        if ($request->isAjax()) {
            $this->displayAjax($title, $form);
        } else {
            $this->displayFullPage($tracker_manager, $breadcrumbsLabel, $url, $title, $form);
        }
    }
    
    private function displayAjax($title, $form) {
        header(json_header(array('dialog-title' => $title)));
        echo $form;
    }
    
    private function displayFullPage(TrackerManager $tracker_manager, $breadcrumbsLabel, $url, $title, $form) {
        $breadcrumbs = array(
            array(
                'title' => $breadcrumbsLabel,
                'url'   => $url,
            ),
        );
        $this->element->getTracker()->displayAdminFormElementsHeader($tracker_manager, $title, $breadcrumbs);
        echo '<h2>'. $title .'</h2>';
        echo $form;
        $this->element->getTracker()->displayFooter($tracker_manager);
    }
}

?>
