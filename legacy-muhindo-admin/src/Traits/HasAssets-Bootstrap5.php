<?php

namespace Muhindo\Admin\Traits;

trait HasAssets
{
    /**
     * @var array
     */
    public static $script = [];

    /**
     * @var array
     */
    public static $deferredScript = [];

    /**
     * @var array
     */
    public static $style = [];

    /**
     * @var array
     */
    public static $css = [];

    /**
     * @var array
     */
    public static $js = [];

    /**
     * @var array
     */
    public static $html = [];

    /**
     * @var array
     */
    public static $headerJs = [];

    /**
     * @var string
     */
    public static $manifest = 'vendor/laravel-admin/minify-manifest.json';

    /**
     * @var array
     */
    public static $manifestData = [];

    /**
     * Minify config.
     *
     * @var array
     */
    public static $minifyConfig = [
        'cached' => false,
        'css' => [
            'patchwork' => false,
            'filters' => 'CssImportFilter,CssRewriteFilter,CssMinFilter',
            'output' => 'vendor/laravel-admin/laravel-admin.css',
        ],
        'js' => [
            'filters' => 'JSMinFilter',
            'output' => 'vendor/laravel-admin/laravel-admin.js',
        ],
    ];

    /**
     * @var array
     */
    public static $minifyIgnores = [];

    /**
     * UPDATED FOR BOOTSTRAP 5 - Priority 2.1 Migration
     * @var array
     */
    public static $baseCss = [
        // NEW: Bootstrap 5.3.3 (replaces Bootstrap 3.3.5)
        'vendor/laravel-admin/bootstrap5/css/bootstrap.min.css',
        
        // Font Awesome - keeping current version (works with Bootstrap 5)
        'vendor/laravel-admin/font-awesome/css/font-awesome.min.css',
        
        // Core admin styles - will need updates for Bootstrap 5 compatibility
        'vendor/laravel-admin/laravel-admin/laravel-admin.css',
        
        // Progress and notification libraries - Bootstrap 5 compatible
        'vendor/laravel-admin/nprogress/nprogress.css',
        'vendor/laravel-admin/sweetalert2/dist/sweetalert2.css',
        'vendor/laravel-admin/nestable/nestable.css',
        'vendor/laravel-admin/toastr/build/toastr.min.css',
        
        // TODO: Replace with Bootstrap 5 compatible editable
        'vendor/laravel-admin/bootstrap3-editable/css/bootstrap-editable.css',
        
        // Google fonts - unchanged
        'vendor/laravel-admin/google-fonts/fonts.css',
        
        // TODO: AdminLTE 4.0 - will replace current AdminLTE 2.3.2
        'vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css',
    ];

    /**
     * UPDATED FOR BOOTSTRAP 5 - Priority 2.1 Migration
     * @var array
     */
    public static $baseJs = [
        // NEW: Bootstrap 5.3.3 bundle (includes Popper.js, replaces Bootstrap 3 JS)
        'vendor/laravel-admin/bootstrap5/js/bootstrap.bundle.min.js',
        
        // AdminLTE plugins - keeping compatible ones
        'vendor/laravel-admin/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js',
        
        // TODO: AdminLTE 4.0 app.js - will replace current app.min.js
        'vendor/laravel-admin/AdminLTE/dist/js/app.min.js',
        
        // PJAX and utilities - Bootstrap 5 compatible
        'vendor/laravel-admin/jquery-pjax/jquery.pjax.js',
        'vendor/laravel-admin/nprogress/nprogress.js',
        'vendor/laravel-admin/nestable/jquery.nestable.js',
        'vendor/laravel-admin/toastr/build/toastr.min.js',
        
        // TODO: Replace with Bootstrap 5 compatible editable
        'vendor/laravel-admin/bootstrap3-editable/js/bootstrap-editable.min.js',
        
        'vendor/laravel-admin/sweetalert2/dist/sweetalert2.min.js',
        'vendor/laravel-admin/laravel-admin/laravel-admin.js',
    ];

    /**
     * jQuery - keeping current version for compatibility
     * @var string
     */
    public static $jQuery = 'vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js';

    /**
     * Add css or get all css.
     *
     * @param null $css
     * @param bool $minify
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function css($css = null, $minify = true)
    {
        static::ignoreMinify($css, $minify);

        if (!is_null($css)) {
            return self::$css = array_merge(self::$css, (array) $css);
        }

        if (!$css = static::getMinifiedCss()) {
            $css = array_merge(static::$css, static::baseCss());
        }

        $css = array_filter(array_unique($css));

        return view('admin::partials.css', compact('css'));
    }

    /**
     * @param null $css
     * @param bool $minify
     *
     * @return array|null
     */
    public static function baseCss($css = null, $minify = true)
    {
        static::ignoreMinify($css, $minify);

        if (!is_null($css)) {
            return static::$baseCss = $css;
        }

        $skin = config('admin.skin', 'skin-blue-light');

        array_unshift(static::$baseCss, "vendor/laravel-admin/AdminLTE/dist/css/skins/{$skin}.min.css");

        return static::$baseCss;
    }

    /**
     * Add js or get all js.
     *
     * @param null $js
     * @param bool $minify
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function js($js = null, $minify = true)
    {
        static::ignoreMinify($js, $minify);

        if (!is_null($js)) {
            return self::$js = array_merge(self::$js, (array) $js);
        }

        if (!$js = static::getMinifiedJs()) {
            $js = array_merge(static::baseJs(), static::$js);
        }

        $js = array_filter(array_unique($js));

        return view('admin::partials.js', compact('js'));
    }

    /**
     * @param null $js
     * @param bool $minify
     *
     * @return array|null
     */
    public static function baseJs($js = null, $minify = true)
    {
        static::ignoreMinify($js, $minify);

        if (!is_null($js)) {
            return static::$baseJs = $js;
        }

        return static::$baseJs;
    }

    /**
     * @param string $script
     *
     * @return array|void
     */
    public static function script($script = '')
    {
        if (!empty($script)) {
            return self::$script = array_merge(self::$script, (array) $script);
        }

        return view('admin::partials.script', ['script' => array_unique(self::$script)]);
    }

    /**
     * @param string $script
     *
     * @return array|void
     */
    public static function deferredScript($script = '')
    {
        if (!empty($script)) {
            return self::$deferredScript = array_merge(self::$deferredScript, (array) $script);
        }

        return view('admin::partials.script', ['script' => array_unique(self::$deferredScript)]);
    }

    /**
     * @param string $style
     *
     * @return array|void
     */
    public static function style($style = '')
    {
        if (!empty($style)) {
            return self::$style = array_merge(self::$style, (array) $style);
        }

        return view('admin::partials.style', ['style' => array_unique(self::$style)]);
    }

    /**
     * @param string $html
     *
     * @return array|void
     */
    public static function html($html = '')
    {
        if (!empty($html)) {
            return self::$html = array_merge(self::$html, (array) $html);
        }

        return view('admin::partials.html', ['html' => array_unique(self::$html)]);
    }

    /**
     * @param string $js
     *
     * @return array|void
     */
    public static function headerJs($js = '')
    {
        if (!empty($js)) {
            return self::$headerJs = array_merge(self::$headerJs, (array) $js);
        }

        return view('admin::partials.js', ['js' => array_unique(self::$headerJs)]);
    }

    /**
     * @return string
     */
    public static function jQuery()
    {
        return static::asset(static::$jQuery);
    }

    /**
     * @param null $css
     * @param bool $minify
     */
    public static function ignoreMinify($css, $minify)
    {
        if (!$minify) {
            foreach ((array) $css as $file) {
                static::$minifyIgnores[] = $file;
            }
        }
    }

    /**
     * @return array
     */
    public static function getMinifiedCss()
    {
        $css = static::baseCss();

        $css = array_filter($css, function ($css) {
            return !in_array($css, static::$minifyIgnores);
        });

        if (!config('admin.minify_assets.cached') || empty($css)) {
            return;
        }

        $key = 'laravel-admin.css';

        $manifest = static::$manifestData ?: static::getManifest();

        if (array_key_exists($key, $manifest)) {
            return [$manifest[$key]];
        }
    }

    /**
     * @return array
     */
    public static function getMinifiedJs()
    {
        $js = static::baseJs();

        $js = array_filter($js, function ($js) {
            return !in_array($js, static::$minifyIgnores);
        });

        if (!config('admin.minify_assets.cached') || empty($js)) {
            return;
        }

        $key = 'laravel-admin.js';

        $manifest = static::$manifestData ?: static::getManifest();

        if (array_key_exists($key, $manifest)) {
            return [$manifest[$key]];
        }
    }

    /**
     * @param $file
     *
     * @return string
     */
    public static function asset($file): string
    {
        if (is_null($file)) {
            return '';
        }

        $manifest = static::$manifestData ?: static::getManifest();

        if (array_key_exists($file, $manifest)) {
            return $manifest[$file];
        }

        return $file.'?v='.static::getVersion();
    }

    /**
     * @return array
     */
    public static function getManifest()
    {
        if (static::$manifestData) {
            return static::$manifestData;
        }

        $manifestPath = public_path(static::$manifest);

        if (is_file($manifestPath)) {
            static::$manifestData = json_decode(
                file_get_contents($manifestPath),
                true
            );
        }

        return static::$manifestData ?: [];
    }

    /**
     * Get laravel-admin version.
     *
     * @return string
     */
    public static function getVersion(): string
    {
        return config('admin.version') ?: '1.0.0';
    }
}
