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

$LANG->loadLanguageMsg('svn/svn');

// CAUTION!!
// Make the changes before calling svn_header_admin because 
// svn_header_admin caches the project object in memory and
// the form values are therefore not updated.
//
if ($post_changes) {
    $ret = svn_data_update_notification($group_id,$form_mailing_list,$form_mailing_header);
    if ($ret) {
	$feedback = $LANG->getText('svn_admin_notification','upd_succ');
    } else {
	$feedback = $LANG->getText('svn_admin_notification','upd_fail',db_error());
    }
}

// Display the form
svn_header_admin(array ('title'=>$LANG->getText('svn_admin_general_settings','gen_settings'),
		      'help' => 'SubversionAdministrationInterface.html#SubversionEmailNotification'));

$project=project_get_object($group_id);
$svn_mailing_list = $project->getSVNMailingList();
$svn_mailing_header = $project->getSVNMailingHeader();

echo '
       <H2>'.$LANG->getText('svn_admin_notification','email').'</H2>
       <FORM ACTION="'. $PHP_SELF .'" METHOD="GET">
       <INPUT TYPE="HIDDEN" NAME="group_id" VALUE="'.$group_id.'">
       <INPUT TYPE="HIDDEN" NAME="func" VALUE="notification">
       <INPUT TYPE="HIDDEN" NAME="post_changes" VALUE="y">
       '.$LANG->getText('svn_admin_notification','mail_comment').'

       <P><b>'.$LANG->getText('svn_admin_notification','mail_to').'</b></p><p><INPUT TYPE="TEXT" SIZE="70" NAME="form_mailing_list" VALUE="'.$svn_mailing_list.'"></p>

       <p><b>'.$LANG->getText('svn_admin_notification','header').'</b></p>
       <p><INPUT TYPE="TEXT" SIZE="20" NAME="form_mailing_header" VALUE="'.$svn_mailing_header.'"></p>

        <INPUT TYPE="SUBMIT" NAME="SUBMIT" VALUE="'.$LANG->getText('global','btn_submit').'"></p></FORM>';

svn_footer(array());
?>
