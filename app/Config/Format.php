<?php

namespace Config;

use BadMethodCallException;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Format\FormatterInterface;
use CodeIgniter\Format\JSONFormatter;
use CodeIgniter\Format\XMLFormatter;
use InvalidArgumentException;

use function array_key_exists;
use function class_exists;

use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;

class Format extends BaseConfig
{
    /*
    |--------------------------------------------------------------------------
    | Available Response Formats
    |--------------------------------------------------------------------------
    |
    | When you perform content negotiation with the request, these are the
    | available formats that your application supports. This is currently
    | only used with the API\ResponseTrait. A valid Formatter must exist
    | for the specified format.
    |
    | These formats are only checked when the data passed to the respond()
    | method is an array.
    |
    */
    public $supportedResponseFormats = [
        'application/json',
        'application/xml', // machine-readable XML
        'text/xml', // human-readable XML
    ];

    /*
    |--------------------------------------------------------------------------
    | Formatters
    |--------------------------------------------------------------------------
    |
    | Lists the class to use to format responses with of a particular type.
    | For each mime type, list the class that should be used. Formatters
    | can be retrieved through the getFormatter() method.
    |
    */
    public $formatters = [
        'application/json' => JSONFormatter::class,
        'application/xml'  => XMLFormatter::class,
        'text/xml'         => XMLFormatter::class,
    ];
    
    /*
    |--------------------------------------------------------------------------
    | Formatters Options
    |--------------------------------------------------------------------------
    |
    | Additional Options to adjust default formatters behaviour.
    | For each mime type, list the additional options that should be used.
    |
    */
    public $formatterOptions = [
        'application/json' => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        'application/xml'  => 0,
        'text/xml'         => 0,
    ];
    //--------------------------------------------------------------------

    /**
     * A Factory method to return the appropriate formatter for the given mime type.
     *
     * @return FormatterInterface
     */
    public function getFormatter(string $mime)
    {
        if (! array_key_exists($mime, $this->formatters)) {
            throw new InvalidArgumentException('No Formatter defined for mime type: ' . $mime);
        }

        $class = $this->formatters[$mime];

        if (! class_exists($class)) {
            throw new BadMethodCallException($class . ' is not a valid Formatter.');
        }

        return new $class();
    }

    //--------------------------------------------------------------------
}
