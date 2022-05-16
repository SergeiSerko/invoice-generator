<?php

namespace App\Service\Order\Types;

// TODO: migrate to php8 enum type
class InvoiceFormatEnumType
{
    const JSON = 'json';
    const XML = 'xml';
    // const YAML = 'yaml'; // TODO: Implement YAML support - Custom FOS Rest View handler
    // const HTML = 'html'; // TODO: Implement HTML support - using template engine and wrapper class for Invoice transformation

    const VALUES = [
        self::JSON,
        self::XML,
        // self::YAML,
        // self::HTML,
    ];

    const MIME = [
        self::JSON => 'application/json',
        self::XML => 'application/xml',
        // self::YAML => 'application/yaml',
        // self::HTML => 'text/html',
    ];
}