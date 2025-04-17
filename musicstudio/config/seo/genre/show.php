<?php

return [
    [
        'property' => 'og:url',
        'content' =>  '{{URL.GENRE}}',
    ],
    [
        'property' => 'og:title',
        'content' => '{{GENRE.NAME}} - {{SITE_NAME}}',
    ],
    [
        'property' => 'og:description',
        'content' => '{{GENRE.DESCRIPTION}}',
    ],
    [
        'property' => 'og:type',
        'content' => 'website',
    ],
];