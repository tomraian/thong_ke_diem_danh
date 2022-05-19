<?php

namespace App\Helper;

class Helper
{
    public function correctDateTime($dateTime)
    {
        # integer digits for Julian date
        $julDate = floor($dateTime);
        # The fractional digits for Julian Time
        $julTime = $dateTime - $julDate;
        # Converts to Timestamp
        $timeStamp = ($julDate > 0) ? ($julDate - 25569) * 86400 + $julTime * 86400 : $julTime * 86400;
        return [
            "date-time" => date("/-m/Y H:i:s", $timeStamp),
            "date" => date("d/m/Y", $timeStamp),
            "time" => date("H:i:s", $timeStamp)
        ];
    }
}