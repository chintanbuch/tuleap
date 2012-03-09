<?php
/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
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
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'Hierarchy.class.php';
require_once 'Dao.class.php';

class Tracker_HierarchyFactory {
    
    protected $hierarchy_dao;
    
    public function __construct(Tracker_Hierarchy_Dao $hierarchy_dao) {
        $this->hierarchy_dao = $hierarchy_dao;
    }
    
    public function getHierarchy($tracker_ids = array()) {
        $hierarchy             = new Tracker_Hierarchy();
        $search_tracker_ids    = $tracker_ids;
        $processed_tracker_ids = array();
        while (!empty($search_tracker_ids)) {
            $hierarchy_dar         = $this->hierarchy_dao->searchTrackerHierarchy($search_tracker_ids);
            $processed_tracker_ids = array_merge($processed_tracker_ids, $search_tracker_ids);
            $search_tracker_ids    = array();
            foreach ($hierarchy_dar as $row) {
                $hierarchy->addRelationship($row['parent_id'], $row['child_id']);
                $search_tracker_ids[] = $row['parent_id'];
                $search_tracker_ids[] = $row['child_id'];
            }
            $search_tracker_ids = array_values(array_diff($search_tracker_ids, $processed_tracker_ids));
        }
        return $hierarchy;
    }
}

?>
