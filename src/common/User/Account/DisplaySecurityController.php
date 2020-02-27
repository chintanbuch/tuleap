<?php
/**
 * Copyright (c) Enalean, 2020-Present. All Rights Reserved.
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
 *
 */

declare(strict_types=1);

namespace Tuleap\User\Account;

use CSRFSynchronizerToken;
use HTTPRequest;
use Psr\EventDispatcher\EventDispatcherInterface;
use TemplateRenderer;
use TemplateRendererFactory;
use Tuleap\Layout\BaseLayout;
use Tuleap\Layout\IncludeAssets;
use Tuleap\Layout\JavascriptAsset;
use Tuleap\Request\DispatchableWithBurningParrot;
use Tuleap\Request\DispatchableWithRequest;
use Tuleap\Request\ForbiddenException;

final class DisplaySecurityController implements DispatchableWithRequest, DispatchableWithBurningParrot
{
    public const URL = '/account/security';
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
     * @var CSRFSynchronizerToken
     */
    private $csrf_token;
    /**
     * @var TemplateRenderer
     */
    private $renderer;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        TemplateRendererFactory $renderer_factory,
        CSRFSynchronizerToken $csrf_token
    ) {

        $this->dispatcher = $dispatcher;
        $this->renderer   = $renderer_factory->getRenderer(__DIR__ . '/templates');
        $this->csrf_token = $csrf_token;
    }

    /**
     * @inheritDoc
     */
    public function process(HTTPRequest $request, BaseLayout $layout, array $variables)
    {
        $user = $request->getCurrentUser();
        if ($user->isAnonymous()) {
            throw new ForbiddenException();
        }

        $layout->addCssAsset(new AccountCssAsset());

        $layout->addJavascriptAsset(
            new JavascriptAsset(
                new IncludeAssets(
                    __DIR__ . '/../../../www/assets/account/scripts',
                    '/assets/account/scripts',
                ),
                'security.js'
            )
        );


        $tabs = $this->dispatcher->dispatch(new AccountTabPresenterCollection($user, self::URL));
        assert($tabs instanceof AccountTabPresenterCollection);

        $password_pre_update = $this->dispatcher->dispatch(new PasswordPreUpdateEvent($user));
        assert($password_pre_update instanceof PasswordPreUpdateEvent);

        $layout->header(['title' => _('Security'), 'main_classes' => DisplayKeysTokensController::MAIN_CLASSES]);
        $this->renderer->renderToPage(
            'security',
            new SecurityPresenter(
                $tabs,
                $this->csrf_token,
                $user,
                $password_pre_update
            )
        );
        $layout->footer([]);
    }

    public static function getCSRFToken(): CSRFSynchronizerToken
    {
        return new CSRFSynchronizerToken(self::URL);
    }
}
