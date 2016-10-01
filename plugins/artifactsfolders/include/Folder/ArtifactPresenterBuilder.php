<?php
/**
 * Copyright (c) Enalean, 2016. All Rights Reserved.
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

namespace Tuleap\ArtifactsFolders\Folder;

use PFUser;
use Tracker_Artifact;
use Tracker_ArtifactFactory;
use Tracker_FormElement_Field_ArtifactLink;
use Tuleap\Tracker\FormElement\Field\ArtifactLink\Nature\NatureDao;
use Tuleap\ArtifactsFolders\Nature\NatureIsFolderPresenter;
use Tuleap\Tracker\FormElement\Field\ArtifactLink\Nature\NatureIsChildLinkRetriever;

class ArtifactPresenterBuilder
{
    /**
     * @var NatureDao
     */
    private $nature_dao;

    /**
     * @var Tracker_ArtifactFactory
     */
    private $artifact_factory;

    public function __construct(
        NatureDao $nature_dao,
        Tracker_ArtifactFactory $artifact_factory
    ) {
        $this->nature_dao       = $nature_dao;
        $this->artifact_factory = $artifact_factory;
    }

    /** @return ArtifactPresenter[] */
    public function buildInFolder(PFUser $user, Tracker_Artifact $folder)
    {
        $linked_artifacts_ids = $this->nature_dao->getReverseLinkedArtifactIds(
            $folder->getId(),
            NatureIsFolderPresenter::NATURE_IN_FOLDER,
            PHP_INT_MAX,
            0
        );

        return $this->getListOfArtifactRepresentation($user, $linked_artifacts_ids);
    }

    /** @return ArtifactPresenter[] */
    public function buildIsChild(PFUser $user, Tracker_Artifact $artifact)
    {
        $linked_artifacts_ids = $this->nature_dao->getForwardLinkedArtifactIds(
            $artifact->getId(),
            Tracker_FormElement_Field_ArtifactLink::NATURE_IS_CHILD,
            PHP_INT_MAX,
            0
        );

        return $this->getListOfArtifactRepresentation($user, $linked_artifacts_ids);
    }

    private function getListOfArtifactRepresentation(PFUser $user, $list_of_artifact_ids)
    {
        $artifact_representations = array();
        foreach ($list_of_artifact_ids as $artifact_id) {
            $artifact = $this->artifact_factory->getArtifactByIdUserCanView($user, $artifact_id);
            if ($artifact) {
                $artifact_representations[] = $this->getArtifactRepresentation($user, $artifact);
            }
        }

        return $artifact_representations;
    }

    private function getArtifactRepresentation(PFUser $user, Tracker_Artifact $artifact)
    {
        $artifact_representation = new ArtifactPresenter();
        $artifact_representation->build($user, $artifact);

        return $artifact_representation;
    }
}
