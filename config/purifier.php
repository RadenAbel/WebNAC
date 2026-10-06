<?php

return [
    'encoding'         => 'UTF-8',
    'finalize'         => true,
    'ignoreNonStrings' => true,
    'cachePath'        => storage_path('app/purifier'),
    'cacheFileMode'    => 0755,

    'settings' => [
        'default' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'b,strong,i,em,u,a[href|title],ul,ol,li,p,br',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => true,
        ],

        'rich_text' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'p[class],br,h2[class],h3[class],strong,b,em,i,u,s,strike,span[style],ol,ul,li[class],a[href|title|target|rel]',
            'CSS.AllowedProperties'    => 'color,background-color',
            'Attr.AllowedClasses'      => 'ql-align-center,ql-align-right,ql-align-justify,ql-indent-1,ql-indent-2,ql-indent-3,ql-indent-4',
            'Attr.AllowedFrameTargets' => ['_blank'],
            'Attr.AllowedRel'          => ['noopener', 'noreferrer', 'nofollow'],
            'HTML.TargetNoopener'      => true,
            'HTML.TargetNoreferrer'    => true,
            'URI.AllowedSchemes'       => ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true],
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => false,
        ],
    ],
];
