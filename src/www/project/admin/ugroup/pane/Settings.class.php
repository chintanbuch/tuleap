<?php
/**
 * Copyright (c) Enalean, 2013. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class Project_Admin_UGroup_Pane_Settings extends Project_Admin_UGroup_Pane {

    public function getContent() {
        $content = '<p>'.$GLOBALS['Language']->getText('project_admin_editugroup', 'upd_ug_name').'</p>
        <form method="post" name="form_create" action="/project/admin/ugroup.php?group_id='.$this->ugroup->getProjectId().'" onSubmit="return selIt();">
        <input type="hidden" name="func" value="do_update">
        <input type="hidden" name="group_id" value="'.$this->ugroup->getProjectId().'">
        <input type="hidden" name="ugroup_id" value="'.$this->ugroup->getId().'">
        <table width="100%" border="0" cellpadding="5">
            <tr>
              <td width="21%"><b>'.$GLOBALS['Language']->getText('project_admin_editugroup', 'name').'</b>:</td>
              <td width="79%">
                <input type="text" name="ugroup_name" value="'.$this->ugroup->getName().'">
              </td>
            </tr>
                <tr><td colspan=2><i>'.$GLOBALS['Language']->getText('project_admin_editugroup', 'avoid_special_ch').'</td></tr>
            <tr>
              <td width="21%"><b>'.$GLOBALS['Language']->getText('project_admin_editugroup', 'desc').'</b>:</td>
              <td width="79%">
              <textarea name="ugroup_description" rows="3" cols="50">'.$this->ugroup->getDescription().'</textarea>
              </td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" value="'.$GLOBALS['Language']->getText('global', 'btn_submit').'" /></td>
            </tr>
        </table>
        </form>';
        return $content;
    }
}

?>
