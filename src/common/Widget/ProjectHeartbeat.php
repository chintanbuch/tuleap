<?php
/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
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

namespace Tuleap\Widget;

use ForgeConfig;
use HTTPRequest;
use TemplateRendererFactory;
use Tuleap\Layout\IncludeAssets;
use Widget;

class ProjectHeartbeat extends Widget
{
    public const NAME = 'projectheartbeat';

    public function __construct()
    {
        parent::__construct(self::NAME);
    }

    public function getTitle()
    {
        return _('Heartbeat');
    }

    public function getDescription()
    {
        return _('Displays the 30 last updated or created items in the project.');
    }

    public function getIcon()
    {
        return "fa-heartbeat";
    }

    public function getContent()
    {
        $renderer = TemplateRendererFactory::build()->getRenderer(
            ForgeConfig::get('tuleap_dir') . '/src/templates/widgets'
        );

        $request = HTTPRequest::instance();

        return $renderer->renderToString(
            'project-heartbeat',
            new ProjectHeartbeatPresenter(
                $request->getProject(),
                $request->getCurrentUser()
            )
        );
    }

    public function getJavascriptDependencies()
    {
        $include_assets = new IncludeAssets(ForgeConfig::get('tuleap_dir') . '/src/www/assets', '/assets');

        return array(
            array('file' => $include_assets->getFileURL('widget-project-heartbeat.js'))
        );
    }
}
