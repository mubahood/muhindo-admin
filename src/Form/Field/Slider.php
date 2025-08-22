<?php

namespace Muhindo\Admin\Form\Field;

use Muhindo\Admin\Form\Field;

class Slider extends Field
{
    protected static $css = [
        '/vendor/muhindo-admin/AdminLTE/plugins/ionslider/ion.rangeSlider.css',
        '/vendor/muhindo-admin/AdminLTE/plugins/ionslider/ion.rangeSlider.skinNice.css',
    ];

    protected static $js = [
        '/vendor/muhindo-admin/AdminLTE/plugins/ionslider/ion.rangeSlider.min.js',
    ];

    protected $options = [
        'type'     => 'single',
        'prettify' => false,
        'hasGrid'  => true,
    ];

    public function render()
    {
        $option = json_encode($this->options);

        $this->script = "$('{$this->getElementClassSelector()}').ionRangeSlider($option);";

        return parent::render();
    }
}
