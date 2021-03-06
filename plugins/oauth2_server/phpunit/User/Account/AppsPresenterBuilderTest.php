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
 */

declare(strict_types=1);

namespace Tuleap\OAuth2Server\User\Account;

use Mockery as M;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Tuleap\Authentication\Scope\AuthenticationScope;
use Tuleap\Authentication\Scope\AuthenticationScopeDefinition;
use Tuleap\OAuth2Server\App\AppFactory;
use Tuleap\OAuth2Server\App\OAuth2App;
use Tuleap\OAuth2Server\AuthorizationServer\OAuth2ScopeDefinitionPresenter;
use Tuleap\OAuth2Server\User\AuthorizedScopeFactory;
use Tuleap\Test\Builders\UserTestBuilder;
use Tuleap\User\Account\AccountTabPresenterCollection;

final class AppsPresenterBuilderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var AppsPresenterBuilder */
    private $builder;
    /**
     * @var M\LegacyMockInterface|M\MockInterface|EventDispatcherInterface
     */
    private $dispatcher;
    /**
     * @var M\LegacyMockInterface|M\MockInterface|AppFactory
     */
    private $app_factory;
    /**
     * @var M\LegacyMockInterface|M\MockInterface|AuthorizedScopeFactory
     */
    private $authorized_scope_factory;

    protected function setUp(): void
    {
        $this->dispatcher               = M::mock(EventDispatcherInterface::class);
        $this->app_factory              = M::mock(AppFactory::class);
        $this->authorized_scope_factory = M::mock(AuthorizedScopeFactory::class);
        $this->builder                  = new AppsPresenterBuilder(
            $this->dispatcher,
            $this->app_factory,
            $this->authorized_scope_factory
        );
    }

    public function testBuildTransformsAppsIntoPresenters(): void
    {
        $user = UserTestBuilder::anAnonymousUser()->build();
        $this->dispatcher->shouldReceive('dispatch')
            ->with(M::type(AccountTabPresenterCollection::class))
            ->once()
            ->andReturnArg(0);
        $jenkins_app = new OAuth2App(
            1,
            'Jenkins',
            'https://example.com',
            true,
            new \Project(['group_id' => 101, 'group_name' => 'Public project'])
        );
        $custom_app  = new OAuth2App(
            2,
            'My Custom REST Consumer',
            'https://example.com',
            true,
            new \Project(['group_id' => 102, 'group_name' => 'Private project'])
        );
        $this->app_factory->shouldReceive('getAppsAuthorizedByUser')
            ->with($user)
            ->once()
            ->andReturn([$jenkins_app, $custom_app]);

        $foobar_scope    = $this->buildFooBarScopeDefinition();
        $typevalue_scope = $this->buildTypeValueScopeDefinition();
        $this->authorized_scope_factory->shouldReceive('getAuthorizedScopes')
            ->once()
            ->with($user, $jenkins_app)
            ->andReturn([$foobar_scope]);
        $this->authorized_scope_factory->shouldReceive('getAuthorizedScopes')
            ->once()
            ->with($user, $custom_app)
            ->andReturn([$foobar_scope, $typevalue_scope]);

        $this->assertEquals(
            new AppsPresenter(
                new AccountTabPresenterCollection($user, AccountAppsController::URL),
                new AccountAppPresenter(
                    1,
                    'Jenkins',
                    'Public project',
                    new OAuth2ScopeDefinitionPresenter($foobar_scope->getDefinition())
                ),
                new AccountAppPresenter(
                    2,
                    'My Custom REST Consumer',
                    'Private project',
                    new OAuth2ScopeDefinitionPresenter($foobar_scope->getDefinition()),
                    new OAuth2ScopeDefinitionPresenter($typevalue_scope->getDefinition())
                )
            ),
            $this->builder->build($user)
        );
    }

    private function buildFooBarScopeDefinition(): AuthenticationScope
    {
        $foobar_scope      = M::mock(AuthenticationScope::class);
        $foobar_definition = new class implements AuthenticationScopeDefinition {
            public function getName(): string
            {
                return 'Foo Bar';
            }

            public function getDescription(): string
            {
                return 'Test scope';
            }
        };
        $foobar_scope->shouldReceive('getDefinition')->andReturn($foobar_definition);
        return $foobar_scope;
    }

    private function buildTypeValueScopeDefinition(): AuthenticationScope
    {
        $typevalue_scope      = M::mock(AuthenticationScope::class);
        $typevalue_definition = new class implements AuthenticationScopeDefinition {
            public function getName(): string
            {
                return 'Type Value';
            }

            public function getDescription(): string
            {
                return 'Other test scope';
            }
        };
        $typevalue_scope->shouldReceive('getDefinition')->andReturn($typevalue_definition);
        return $typevalue_scope;
    }
}
