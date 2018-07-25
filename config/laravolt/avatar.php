<?php
/*
 * Set specific configuration variables here
 */

$original = [
    '#f44336',
    '#E91E63',
    '#9C27B0',
    '#673AB7',
    '#3F51B5',
    '#2196F3',
    '#03A9F4',
    '#00BCD4',
    '#009688',
    '#4CAF50',
    '#8BC34A',
    '#CDDC39',
    '#FFC107',
    '#FF9800',
    '#FF5722',
];

$material = [
    '#f44336',
    '#e91f62',
    '#9c28b0',
    '#673bb7',
    '#3e50b5',
    '#2296f3',
    '#0ea9f4',
    '#1dbcd5',
    '#199687',
    '#4caf4f',
    '#8ac349',
    '#cddd39',
    '#ffeb3b',
    '#fec106',
    '#fd9703',
    '#fc5623',
    '#785447',
    '#9e9e9e',
    '#5f7c8b',
];

$material_light = [
    '#ef999a',
    '#f48eb1',
    '#ce93d8',
    '#b39ddb',
    '#9ea8db',
    '#90cafa',
    '#80d4fa',
    '#80deeb',
    '#7fcbc4',
    '#a4d6a7',
    '#c5e1a5',
    '#e6ef9c',
    '#fff59d',
    '#ffe081',
    '#fecc80',
    '#fdab91',
    '#bdaaa4',
    '#eeeeee',
    '#b0bec6',
];

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    | Avatar use Intervention Image library to process image.
    | Meanwhile, Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */
    'driver'    => 'gd',

    // Initial generator class
    'generator' => \Laravolt\Avatar\Generator\DefaultGenerator::class,

    // Whether all characters supplied must be replaced with their closest ASCII counterparts
    'ascii'    => false,

    // Image shape: circle or square
    'shape' => 'circle',

    // Image width, in pixel
    'width'    => 100,

    // Image height, in pixel
    'height'   => 100,

    // Number of characters used as initials. If name consists of single word, the first N character will be used
    'chars'    => 2,

    // font size
    'fontSize' => 48,

    // convert initial letter in uppercase
    'uppercase' => false,

    // Fonts used to render text.
    // If contains more than one fonts, randomly selected based on name supplied
    'fonts'    => [__DIR__.'/../fonts/OpenSans-Bold.ttf', __DIR__.'/../fonts/rockwell.ttf'],

    // List of foreground colors to be used, randomly selected based on name supplied
    'foregrounds'   => $material_light,

    // List of background colors to be used, randomly selected based on name supplied
    'backgrounds'   => $material,

    'border'    => [
        'size'  => 1,

        // border color, available value are:
        // 'foreground' (same as foreground color)
        // 'background' (same as background color)
        // or any valid hex ('#aabbcc')
        'color' => 'foreground',
    ],
];
