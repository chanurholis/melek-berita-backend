<?php

namespace App\Helpers;

class Helpers
{
    protected static function removeNamespaceFromXML($xml)
    {
        $toRemove = ['rap', 'turss', 'crim', 'cred', 'j', 'rap-code', 'evic'];
        $nameSpaceDefRegEx = '(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?';
        foreach ($toRemove as $remove) {
            $xml = str_replace('<' . $remove . ':', '<', $xml);
            $xml = str_replace('</' . $remove . ':', '</', $xml);
            $xml = str_replace($remove . ':commentText', 'commentText', $xml);
            $pattern = "/xmlns:{$remove}{$nameSpaceDefRegEx}/";
            $xml = preg_replace($pattern, '', $xml, 1);
        }
        return $xml;
    }
}
