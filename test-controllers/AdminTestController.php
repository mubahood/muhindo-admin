<?php

namespace App\Http\Controllers;

use App\Models\User;
use Muhindo\Admin\Layout\Content;
use Muhindo\Admin\Form;
use Muhindo\Admin\Grid;
use Muhindo\Admin\Admin;

class AdminTestController
{
    public function index(Content $content)
    {
        return $content
            ->title('Bootstrap 5 Test')
            ->description('Testing Bootstrap 5 Integration')
            ->body($this->grid());
    }

    public function create(Content $content)
    {
        return $content
            ->title('Create Test')
            ->description('Testing Bootstrap 5 Form')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id', 'ID');
        $grid->column('name', 'Name');
        $grid->column('email', 'Email');
        $grid->column('created_at', 'Created');

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', 'Name')->required();
        $form->email('email', 'Email')->required();
        $form->password('password', 'Password')->required();
        $form->textarea('bio', 'Bio')->placeholder('Tell us about yourself');
        $form->select('role', 'Role')->options([
            'admin' => 'Administrator',
            'user' => 'User'
        ]);
        $form->switch('active', 'Active');
        $form->checkbox('terms', 'Agree to Terms');

        return $form;
    }
}
