<?php

declare(strict_types=1);

namespace AllInOneManagement\Lightkeeper\Config;

class DefaultColumns
{
    public static $defaultColumns = [
        // accessibility
        'accessibility' => [
            [
                'cols' => 1,
                'label' => 'Image Alts',
                'tooltip' => 'Image elements have [alt] attributes',
                'sortKey' => 'length:details.items',
                'key' => 'report.audits.image-alt',
            ],
            [
                'cols' => 1,
                'label' => 'Link Names',
                'tooltip' => 'Links do not have a discernible name',
                'sortKey' => 'length:details.items',
                'key' => 'report.audits.link-name',
            ],
        ],
        // best practices
        'best-practices' => [
            [
                'cols' => 2,
                'label' => 'Errors',
                'tooltip' => 'No browser errors logged to the console',
                'sortKey' => 'length:details.items',
                'key' => 'report.audits.errors-in-console',
            ],
            [
                'cols' => 2,
                'label' => 'Inspector Issues',
                'tooltip' => 'No issues in the `Issues` panel in Chrome Devtools',
                'sortKey' => 'length:details.items',
                'key' => 'report.audits.inspector-issues',
            ],
            [
                'cols' => 2,
                'label' => 'Images Responsive',
                'tooltip' => 'Serves images with appropriate resolution',
                'sortKey' => 'length:details.items',
                'key' => 'report.audits.image-size-responsive',
            ],
            [
                'cols' => 2,
                'label' => 'Image Aspect Ratio',
                'tooltip' => 'Displays images with correct aspect ratio',
                'sortKey' => 'length:details.items',
                'key' => 'report.audits.image-aspect-ratio',
            ],
        ],
        // seo
        'seo' => [
            [
                'cols' => 1,
                'label' => 'Indexable',
                'tooltip' => 'Page isn\u2019t blocked from indexing',
                'key' => 'report.audits.is-crawlable',
            ],
            ['cols' => 1, 'label' => 'Internal link', 'sortable' => true, 'key' => 'seo.internalLinks'],
            ['cols' => 1, 'label' => 'External link', 'sortable' => true, 'key' => 'seo.externalLinks'],
            [
                'cols' => 1,
                'label' => 'Tap Targets',
                'tooltip' => 'Tap targets are sized appropriately',
                'key' => 'report.audits.tap-targets',
            ],
            [
                'cols' => 2,
                'label' => 'Description',
                'key' => 'seo.description',
            ],
            [
                'cols' => 2,
                'label' => 'Share Image',
                'key' => 'seo.og.image',
            ],
        ],
        'pwa' => [
            [
                'cols' => 2,
                'label' => 'Manifest',
                'key' => 'report.audits.installable-manifest',
            ],
            ['cols' => 1, 'label' => 'Service Worker', 'key' => 'report.audits.service-worker'],
            ['cols' => 1, 'label' => 'Splash Screen', 'key' => 'report.audits.splash-screen'],
            [
                'cols' => 2,
                'label' => 'Viewport',
                'key' => 'report.audits.viewport',
            ],
            [
                'cols' => 2,
                'label' => 'Content Width',
                'key' => 'report.audits.content-width',
            ],
        ],
    ];
}
