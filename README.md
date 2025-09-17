# Muhindo Admin# Muhindo Admin



A powerful Laravel admin panel package that helps you build CRUD backends with just a few lines of code.A powerful Laravel admin panel package that helps you build CRUD backends with just a few lines of code.



## Features## Features



- 🚀 **Rapid Development** - Build admin panels quickly with minimal code- 🚀 **Rapid Development** - Build admin panels quickly with minimal code

- 🎨 **Beautiful UI** - Built on AdminLTE with responsive design- 🎨 **Beautiful UI** - Built on AdminLTE with responsive design

- 🔐 **Authentication** - Complete role-based access control (RBAC)- 🔐 **Authentication** - Complete role-based access control (RBAC)

- 📊 **Data Grid** - Advanced grid with filtering, sorting, and export- 📊 **Data Grid** - Advanced grid with filtering, sorting, and export

- 📝 **Form Builder** - Extensive form fields and validation- 📝 **Form Builder** - Extensive form fields and validation

- 🌳 **Tree View** - Hierarchical data management- 🌳 **Tree View** - Hierarchical data management

- 🎛️ **Dashboard** - Customizable admin dashboard- 🎛️ **Dashboard** - Customizable admin dashboard

- 🔧 **Extensible** - Easy to extend and customize- 🔧 **Extensible** - Easy to extend and customize



## Installation## Installation



Install via Composer:Install via Composer:



```bash```bash

composer require muhindo/muhindo-admincomposer require muhindo/muhindo-admin

``````



Publish the package:Publish the package:



```bash```bash

php artisan vendor:publish --provider="Muhindo\Admin\AdminServiceProvider"php artisan vendor:publish --provider="Muhindo\Admin\AdminServiceProvider"

``````



Run migrations:Run migrations:



```bash```bash

php artisan migratephp artisan migrate

``````



Install admin:Install admin:



```bash```bash

php artisan admin:installphp artisan admin:install

``````



## Quick Start## Quick Start



### Create an Admin Controller### Create an Admin Controller



```bash```bash

php artisan admin:make UserController --model=App\\Models\\Userphp artisan admin:make UserController --model=App\\Models\\User

``````



### Add Routes### Add Routes



```php```php

// app/Admin/routes.php// app/Admin/routes.php

$router->resource('users', UserController::class);$router->resource('users', UserController::class);

``````



### Example Controller### Example Controller



```php```php

<?php<?php



namespace App\Admin\Controllers;namespace App\Admin\Controllers;



use App\Models\User;use App\Models\User;

use Muhindo\Admin\Controllers\AdminController;use Muhindo\Admin\Controllers\AdminController;

use Muhindo\Admin\Form;use Muhindo\Admin\Form;

use Muhindo\Admin\Grid;use Muhindo\Admin\Grid;

use Muhindo\Admin\Show;use Muhindo\Admin\Show;



class UserController extends AdminControllerclass UserController extends AdminController

{{

    protected function grid()    protected function grid()

    {    {

        $grid = new Grid(new User());        $grid = new Grid(new User());

                

        $grid->column('id', __('ID'));        $grid->column('id', __('ID'));

        $grid->column('name', __('Name'));        $grid->column('name', __('Name'));

        $grid->column('email', __('Email'));        $grid->column('email', __('Email'));

        $grid->column('created_at', __('Created at'));        $grid->column('created_at', __('Created at'));

        # Muhindo Admin

        return $grid;

    }A powerful Laravel admin panel package that helps you build CRUD backends with just a few lines of code.

    

    protected function form()## Features

    {

        $form = new Form(new User());- 🚀 **Rapid Development** - Build admin panels quickly with minimal code

        - 🎨 **Beautiful UI** - Built on AdminLTE with responsive design

        $form->text('name', __('Name'))->required();- 🔐 **Authentication** - Complete role-based access control (RBAC)

        $form->email('email', __('Email'))->required();- 📊 **Data Grid** - Advanced grid with filtering, sorting, and export

        $form->password('password', __('Password'))->required();- 📝 **Form Builder** - Extensive form fields and validation

        - 🌳 **Tree View** - Hierarchical data management

        return $form;- 🎛️ **Dashboard** - Customizable admin dashboard

    }- 🔧 **Extensible** - Easy to extend and customize

}

```## Installation



## RequirementsInstall via Composer:



- PHP ^8.0```bash

- Laravel ^9.0|^10.0|^11.0|^12.0composer require muhindo/muhindo-admin

```

## Documentation

Publish the package:

For detailed documentation, visit [Documentation Link] (coming soon)

```bash

## Contributingphp artisan vendor:publish --provider="Muhindo\Admin\AdminServiceProvider"

```

Contributions are welcome! Please feel free to submit a Pull Request.

Run migrations:

## License

```bash

This project is open-sourced software licensed under the [MIT license](LICENSE).php artisan migrate

```

## Credits

Install admin:

This package is inspired by and based on the excellent [laravel-admin](https://github.com/z-song/laravel-admin) package.
```bash
php artisan admin:install
```

## Quick Start

### Create an Admin Controller

```bash
php artisan admin:make UserController --model=App\\Models\\User
```

### Add Routes

```php
// app/Admin/routes.php
$router->resource('users', UserController::class);
```

### Example Controller

```php
<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Muhindo\Admin\Controllers\AdminController;
use Muhindo\Admin\Form;
use Muhindo\Admin\Grid;
use Muhindo\Admin\Show;

class UserController extends AdminController
{
    protected function grid()
    {
        $grid = new Grid(new User());
        
        $grid->column('id', __('ID'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('created_at', __('Created at'));
        
        return $grid;
    }
    
    protected function form()
    {
        $form = new Form(new User());
        
        $form->text('name', __('Name'))->required();
        $form->email('email', __('Email'))->required();
        $form->password('password', __('Password'))->required();
        
        return $form;
    }
}
```

## Requirements

- PHP ^8.0
- Laravel ^9.0|^10.0|^11.0|^12.0

## Documentation

For detailed documentation, visit [Documentation Link] (coming soon)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

This package is inspired by and based on the excellent [laravel-admin](https://github.com/z-song/laravel-admin) package.

Right to left support
------------
just go to this path `<YOUR_PROJECT_PATH>\vendor\encore\muhindo-admin\src\Traits\HasAssets.php` and modify `$baseCss` array for loading right to left (rtl) version of bootstap and AdminLTE css files.    
**bootstrap.min.css** change it to **bootstrap.rtl.min.css**    
**AdminLTE.min.css** change it to **AdminLTE.rtl.min.css**  

## Extensions

| Extension                                        | Description                              | muhindo-admin                              |
| ------------------------------------------------ | ---------------------------------------- |---------------------------------------- |
| [helpers](https://github.com/muhindo-admin-extensions/helpers)             | Several tools to help you in development | ~1.5 |
| [media-manager](https://github.com/muhindo-admin-extensions/media-manager) | Provides a web interface to manage local files          | ~1.5 |
| [api-tester](https://github.com/muhindo-admin-extensions/api-tester) | Help you to test the local laravel APIs          |~1.5 |
| [scheduling](https://github.com/muhindo-admin-extensions/scheduling) | Scheduling task manager for muhindo-admin          |~1.5 |
| [redis-manager](https://github.com/muhindo-admin-extensions/redis-manager) | Redis manager for muhindo-admin          |~1.5 |
| [backup](https://github.com/muhindo-admin-extensions/backup) | An admin interface for managing backups          |~1.5 |
| [log-viewer](https://github.com/muhindo-admin-extensions/log-viewer) | Log viewer for laravel           |~1.5 |
| [config](https://github.com/muhindo-admin-extensions/config) | Config manager for muhindo-admin          |~1.5 |
| [reporter](https://github.com/muhindo-admin-extensions/reporter) | Provides a developer-friendly web interface to view the exception          |~1.5 |
| [wangEditor](https://github.com/muhindo-admin-extensions/wangEditor) | A rich text editor based on [wangeditor](http://www.wangeditor.com/)         |~1.6 |
| [summernote](https://github.com/muhindo-admin-extensions/summernote) | A rich text editor based on [summernote](https://summernote.org/)          |~1.6 |
| [china-distpicker](https://github.com/muhindo-admin-extensions/china-distpicker) | 一个基于[distpicker](https://github.com/fengyuanchen/distpicker)的中国省市区选择器          |~1.6 |
| [simplemde](https://github.com/muhindo-admin-extensions/simplemde) | A markdown editor based on [simplemde](https://github.com/sparksuite/simplemde-markdown-editor)          |~1.6 |
| [phpinfo](https://github.com/muhindo-admin-extensions/phpinfo) | Integrate the `phpinfo` page into muhindo-admin          |~1.6 |
| [php-editor](https://github.com/muhindo-admin-extensions/php-editor) <br/> [python-editor](https://github.com/muhindo-admin-extensions/python-editor) <br/> [js-editor](https://github.com/muhindo-admin-extensions/js-editor)<br/> [css-editor](https://github.com/muhindo-admin-extensions/css-editor)<br/> [clike-editor](https://github.com/muhindo-admin-extensions/clike-editor)| Several programing language editor extensions based on code-mirror          |~1.6 |
| [star-rating](https://github.com/muhindo-admin-extensions/star-rating) | Star Rating extension for muhindo-admin          |~1.6 |
| [json-editor](https://github.com/muhindo-admin-extensions/json-editor) | JSON Editor for Laravel-admin          |~1.6 |
| [grid-lightbox](https://github.com/muhindo-admin-extensions/grid-lightbox) | Turn your grid into a lightbox & gallery          |~1.6 |
| [daterangepicker](https://github.com/muhindo-admin-extensions/daterangepicker) | Integrates daterangepicker into muhindo-admin          |~1.6 |
| [material-ui](https://github.com/muhindo-admin-extensions/material-ui) | Material-UI extension for muhindo-admin          |~1.6 |
| [sparkline](https://github.com/muhindo-admin-extensions/sparkline) | Integrates jQuery sparkline into muhindo-admin          |~1.6 |
| [chartjs](https://github.com/muhindo-admin-extensions/chartjs) | Use Chartjs in muhindo-admin          |~1.6 |
| [echarts](https://github.com/muhindo-admin-extensions/echarts) | Use Echarts in muhindo-admin          |~1.6 |
| [simditor](https://github.com/muhindo-admin-extensions/simditor) | Integrates simditor full-rich editor into muhindo-admin          |~1.6 |
| [cropper](https://github.com/muhindo-admin-extensions/cropper) | A simple jQuery image cropping plugin.          |~1.6 |
| [composer-viewer](https://github.com/muhindo-admin-extensions/composer-viewer) | A web interface of composer packages in laravel.          |~1.6 |
| [data-table](https://github.com/muhindo-admin-extensions/data-table) | Advanced table widget for muhindo-admin |~1.6 |
| [watermark](https://github.com/muhindo-admin-extensions/watermark) | Text watermark for muhindo-admin |~1.6 |
| [google-authenticator](https://github.com/ylic/muhindo-admin-google-authenticator) | Google authenticator |~1.6 |



## Contributors
 This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].
<a href="graphs/contributors"><img src="https://opencollective.com/muhindo-admin/contributors.svg?width=890&button=false" /></a>
 ## Backers
 Thank you to all our backers! 🙏 [[Become a backer](https://opencollective.com/muhindo-admin#backer)]
 <a href="https://opencollective.com/muhindo-admin#backers" target="_blank"><img src="https://opencollective.com/muhindo-admin/backers.svg?width=890"></a>
 ## Sponsors
 Support this project by becoming a sponsor. Your logo will show up here with a link to your website. [[Become a sponsor](https://opencollective.com/muhindo-admin#sponsor)]
 <a href="https://opencollective.com/muhindo-admin/sponsor/0/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/0/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/1/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/1/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/2/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/2/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/3/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/3/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/4/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/4/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/5/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/5/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/6/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/6/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/7/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/7/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/8/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/8/avatar.svg"></a>
<a href="https://opencollective.com/muhindo-admin/sponsor/9/website" target="_blank"><img src="https://opencollective.com/muhindo-admin/sponsor/9/avatar.svg"></a>

Other
------------
`muhindo-admin` based on following plugins or services:

+ [Laravel](https://laravel.com/)
+ [AdminLTE](https://adminlte.io/)
+ [Datetimepicker](http://eonasdan.github.io/bootstrap-datetimepicker/)
+ [font-awesome](http://fontawesome.io)
+ [moment](http://momentjs.com/)
+ [Google map](https://www.google.com/maps)
+ [Tencent map](http://lbs.qq.com/)
+ [bootstrap-fileinput](https://github.com/kartik-v/bootstrap-fileinput)
+ [jquery-pjax](https://github.com/defunkt/jquery-pjax)
+ [Nestable](http://dbushell.github.io/Nestable/)
+ [toastr](http://codeseven.github.io/toastr/)
+ [X-editable](http://github.com/vitalets/x-editable)
+ [bootstrap-number-input](https://github.com/wpic/bootstrap-number-input)
+ [fontawesome-iconpicker](https://github.com/itsjavi/fontawesome-iconpicker)
+ [sweetalert2](https://github.com/sweetalert2/sweetalert2)

License
------------
`muhindo-admin` is licensed under [The MIT License (MIT)](LICENSE).
