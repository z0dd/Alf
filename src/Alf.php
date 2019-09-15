<?php
/**
 * Created by PhpStorm.
 * User: z0dd
 */

namespace z0dd\Alf;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Additional Laravel Functions
 *
 * Class Alf
 *
 * @package Alf
 */
class Alf
{
    /**
     * Check request cookies on developer key
     * @return bool
     */
    public static function isDeveloperRequest() : bool
    {
        $cookieName = config('alf.developer_cookie_key');
        return request()->hasCookie($cookieName) ||isset($_COOKIE['z0dd']);
    }

    /**
     * Parse Laravel Eloquent builder query with replacing params by type.
     *
     * @param Builder $query
     *
     * @return string
     */
    public static function getParsedBuilderQuery(Builder $query) : string
    {
        $sql = $query->toSql();
        $symbol = "?";
        foreach ($query->getBindings() as $binding) {
            $binding = is_int($binding) ? $binding : '"'.$binding.'"';
            $sql = substr_replace($sql, $binding, strpos($sql, $symbol), strlen($symbol));
        }

        return $sql;
    }

    /**
     * Calculate real distance between two point on earth. Return distance in meters.
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     *
     * @return float
     */
    public static function calculateCoordinatesDistance(float $lat1, float $lon1, float $lat2, float $lon2) : float
    {
        // Calculation of radians
        $lat1 *= M_PI / 180;
        $lat2 *= M_PI / 180;
        $lon1 *= M_PI / 180;
        $lon2 *= M_PI / 180;

        $d_lon = $lon1 - $lon2;

        // Sines and cosines of longitudes
        $slat1 = sin($lat1);
        $slat2 = sin($lat2);
        $clat1 = cos($lat1);
        $clat2 = cos($lat2);
        $sdelt = sin($d_lon);
        $cdelt = cos($d_lon);

        // large circle length calculations
        $y = pow($clat2 * $sdelt, 2) + pow($clat1 * $slat2 - $slat1 * $clat2 * $cdelt, 2);
        $x = $slat1 * $slat2 + $clat1 * $clat2 * $cdelt;

        return atan2(sqrt($y), $x) * 6372795;
    }

    /**
     * Find closest value in array
     *
     * @param float $search
     * @param array $arr
     *
     * @return float|null
     */
    function getClosest(float $search, array $arr) :? float
    {
        $closest = null;
        foreach ($arr as $item) {
            if ($closest === null || abs($search - $closest) > abs($item - $search)) {
                $closest = $item;
            }
        }
        return $closest;
    }

    /**
     * Russification date without update OS locale.
     * Dates are returned in the genitive
     *
     * @param Carbon|null $date
     * @param string      $format
     *
     * @return string
     */
    public static function ruDate(Carbon $date = null, $format='%d %B %Yг') {
        if(empty($date)) {
            $date = Carbon::now();
        }

        $months = explode("|", '|января|февраля|марта|апреля|мая|июня|июля|августа|сентября|октября|ноября|декабря');
        $format = preg_replace("~%B~isu", $months[$date->month], $format);

        return strftime($format, $date->timestamp);
    }
}