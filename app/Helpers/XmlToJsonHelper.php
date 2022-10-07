<?php

namespace App\Helpers;

use App\Helpers\Helpers;

class XmlToJsonHelper extends Helpers
{
    public static function run($xml)
    {
        return json_decode(json_encode(simplexml_load_string(self::removeNamespaceFromXML($xml))), true);
    }
}
