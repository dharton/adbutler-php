<?php

namespace AdButler;

use AdButler\Error\APIException;

/**
 * @property-read string object
 * @property-read string url
 * @property-read string data
 * @property-read int    meta
 */
class Stats extends ReadOnlyResource
{
    protected static $type = 'stats';
    protected static $url  = 'stats';

    /*
     * Overridden Methods
     */

    public static function retrieve( $queryParams = null, $id = null ) {
        if (!empty($queryParams)) {
            // TODO: validate Query Parameters
        } else {
            // TODO: throw error: no query params in the url
        }

        $queryParamsStringified = empty($queryParams) ? '' : '?'.http_build_query($queryParams); // join query params: 'key1=val1&key2=val2&key3=val3'
        $statsURLWithQueryParams = self::getResourceURL() . $queryParamsStringified;
        $data = self::getDecodedResponse('GET', $statsURLWithQueryParams, null, array());

        // inspect response if it has the correct type
        $isCorrectObjectType = key_exists('object', $data) && $data['object'] === self::$type;
        if (!$isCorrectObjectType) { // throw an error if it doesn't
            throw new APIException($data);
        }

        return is_null( self::$objectInstance ) // check if the object is already instantiated or not
            ? new Stats($data) // Not instantiated: static method call to instantiate an advertiser object with data
            : self::$objectInstance->setData( $data ); // Already instantiated: member method call to set data on the existing object and return it
    }

    /*
     * Resource specific methods
     */

}


//http://api.adbutler.com.baig.dev/v1/stats?type=publisher&from=2016-09-01T00:00:00+00:00&to=2016-10-15T16:00:00+00:00&period=year
//http://api.adbutler.com.baig.dev/v1/stats?type=publisher&from=2016-09-01T00:00:00+00:00&to=2016-10-15T16:00:00+00:00&period=year