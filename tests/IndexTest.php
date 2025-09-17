<?php

use Muhindo\Admin\Auth\Database\Administrator;

class IndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->be(Administrator::first(), 'admin');
    }

    public function testIndex()
    {
        $this->visit('admin/')
            ->see('Dashboard')
            ->see('Description...')

            ->see('Environment')
            ->see('PHP version')
            ->see('Laravel version')

            ->see('Available extensions')
            ->seeLink('muhindo-admin-ext/helpers', 'https://github.com/muhindo-admin-extensions/helpers')
            ->seeLink('muhindo-admin-ext/backup', 'https://github.com/muhindo-admin-extensions/backup')
            ->seeLink('muhindo-admin-ext/media-manager', 'https://github.com/muhindo-admin-extensions/media-manager')

            ->see('Dependencies')
            ->see('php')
//            ->see('>=7.0.0')
            ->see('laravel/framework');
    }

    public function testClickMenu()
    {
        $this->visit('admin/')
            ->click('Users')
            ->seePageis('admin/auth/users')
            ->click('Roles')
            ->seePageis('admin/auth/roles')
            ->click('Permission')
            ->seePageis('admin/auth/permissions')
            ->click('Menu')
            ->seePageis('admin/auth/menu')
            ->click('Operation log')
            ->seePageis('admin/auth/logs');
    }
}
