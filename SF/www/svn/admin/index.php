<?php
//
// CodeX: Breaking Down the Barriers to Source Code Sharing inside Xerox
// Copyright (c) Xerox Corporation, CodeX / CodeX Team, 2004. All Rights Reserved
// http://codex.xerox.com
//
// $Id$
//
//	Originally written by Laurent Julliard 2004, CodeX Team, Xerox
//

require($DOCUMENT_ROOT.'/include/pre.php');    
require('../svn_data.php');    
require('../svn_utils.php');    

$LANG->loadLanguageMsg('svn/svn');

// need a group_id !!!
if (!$group_id) {
    exit_no_group();
}

// Must be at least Project Admin to configure this
if (!user_ismember($group_id,'A')) {
    exit_permission_denied();
}


switch ($func) {

 case 'general_settings' : {
   require('./general_settings.php');
   break;
 }

 case 'access_control' : {
   require('./access_control.php');
   break;
 }

 case 'notification' : {
   require('./notification.php');
   break;
 }

 default:


   // get project object
   $project = project_get_object($group_id);
   if (!$project || !is_object($project) || $project->isError()) {
       exit_no_group();
   }

   svn_header_admin(array ('title'=>$LANG->getText('svn_admin_index','admin'),
		      'help' => 'SubversionAdministrationInterface.html'));

   echo '<H2>'.$LANG->getText('svn_admin_index','admin').'</H2>';
   echo '<H3><a href="/svn/admin/?func=general_settings&group_id='.$group_id.'">'.$LANG->getText('svn_admin_index','gen_sett').'</a></H3>';
   echo '<p>'.$LANG->getText('svn_admin_index','welcome').'</p>';
   
   echo '<H3><a href="/svn/admin/?func=access_control&group_id='.$group_id.'">'.$LANG->getText('svn_admin_index','access').'</a></H3>';
   echo '<P>'.$LANG->getText('svn_admin_index','access_comment').'</P>';
   echo '<H3><a href="/svn/admin/?func=notification&group_id='.$group_id.'">'.$LANG->getText('svn_admin_index','email_sett').'</a></H3>';
   echo '<p>'.$LANG->getText('svn_admin_index','email_comment').'</P>';

   svn_footer(array());
}
 
?>
