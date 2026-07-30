<?php

return [
    /*
     * The default serializer to be used when performing a transformation. It
     * may be left empty to use Fractal's default one. This can either be a
     * string or a League\Fractal\Serializer\SerializerAbstract subclass.
     */
    'default_serializer' => '',

    /* The default paginator to be used when performing a transformation. It
     * may be left empty to use Fractal's default one. This can either be a
     * string or a League\Fractal\Paginator\PaginatorInterface subclass.
     */
    'default_paginator' => '',

    /*
     * League\Fractal\Serializer\JsonApiSerializer will use this value
     * as a prefix for generated links. Set to `null` to disable this.
     */
    'base_url' => null,

    /*
     * If you wish to override or extend the default Spatie\Fractal\Fractal
     * instance provide the name of the class you want to use.
     */
    'fractal_class' => Spatie\Fractal\Fractal::class,

    'auto_includes' => [

        /*
         * If enabled Fractal will automatically add the includes who's
         * names are present in the `include` request parameter.
         */
        'enabled' => true,

        /*
         * The name of key in the request to where we should look for the includes to include.
         */
        'request_key' => 'include',
    ],

    'auto_excludes' => [

        /*
         * If enabled Fractal will automatically add the excludes who's
         * names are present in the `exclude` request parameter.
         */
        'enabled' => true,

        /*
         * The name of key in the request to where we should look for the excludes to exclude.
         */
        'request_key' => 'exclude',
    ],

    'auto_fieldsets' => [

        /*
         * If enabled Fractal will automatically add the fieldsets who's
         * names are present in the `fields` request parameter.
         *
         * NOTE: This feature does not work if the "resource name" is not set.
         */
        'enabled' => false,

        /*
         * The name of key in the request, where we should look for the fieldsets to parse.
         */
        'request_key' => 'fields',
    ],
];
