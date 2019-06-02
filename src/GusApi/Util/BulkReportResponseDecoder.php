<?php

namespace GusApi\Util;

use GusApi\Exception\InvalidServerResponseException;
use GusApi\Type\Response\GetBulkReportResponseRaw;
use SimpleXMLElement;

class BulkReportResponseDecoder
{
    /**
     * @param GetBulkReportResponseRaw $bulkReportResponseRaw
     *
     * @throws InvalidServerResponseException
     *
     * @return array
     */
    public static function decode(GetBulkReportResponseRaw $bulkReportResponseRaw): array
    {
        $regons = [];

        if ('' === $bulkReportResponseRaw->getDanePobierzRaportZbiorczyResult()) {
            return $regons;
        }

        try {
            $xmlElementsResponse = new SimpleXMLElement($bulkReportResponseRaw->getDanePobierzRaportZbiorczyResult());

            foreach ($xmlElementsResponse->dane as $regon) {
                $regons[] = (string) $regon->regon;
            }

            return $regons;
        } catch (\Exception $e) {
            throw new InvalidServerResponseException('Invalid server response');
        }
    }
}
