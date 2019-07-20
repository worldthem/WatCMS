<?php
/* usage:

     $cCode = getCountryFromIP($ip);           // returns country code by default
     $cCode = getCountryFromIP($ip, "code");   // you can specify code - optional
     $cAbbr = getCountryFromIP($ip, "AbBr");   // returns country abbreviation - case insensitive
     $cName = getCountryFromIP($ip, " NamE "); // full name of country - spaces are trimmed

     $ip must be of the form "192.168.1.100"
     $type can be "code", "abbr", "name", or omitted

  ip cacheing:

     this function has a simple cache that works pretty well when you are calling
     getCountryFromIP thousands of times in the same script and IPs are repeated e.g.
     while parsing access logs. Without caching, each IP would be searched everytime
     you called this function. The only time caching would slow down performance
     is if you have 100k+ unique IP addresses. But then you should use a dedicated
     box for GeoLocation anyway and of course feel free to optimize this script.
*/

 
 

// can use direct hash because max # possible IPAddress = max size of cache array
// realistically, cache size will be much much smaller
 

function getCountryFromIP($data=[], $ip, $type = "code")
{
  $geoipaddrfrom = $data['geoipaddrfrom'];
  $geoipaddrupto = $data['geoipaddrupto'];
  $geoipctry = $data['geoipctry'];
  $geoipcntry = $data['geoipcntry'];
  $geoipcountry = $data['geoipcountry'];
  $geoipcount = $data['geoipcount'];
  $geoipcache = $data['geoipcache'];  
  

  if(strpos($ip, ".") === false)
    return "";

  $ip = substr("0000000000" . sprintf("%u", ip2long($ip)), -10);
  $ipn = base64_encode($ip);

  if(isset($geoipcache[$ipn])) // search in cache
  {
    $ct = $geoipcache[$ipn];
  }
  else // search in IP Address array
  {
    $from = 0;
    $upto = $geoipcount;
    $ct   = "ZZ"; // default: Reserved or Not Found

    // simple binary search within the array for given text-string within IP range
    while($upto > $from)
    {
      $idx = $from + intval(($upto - $from)/2);
      $loip = substr("0000000000" . $geoipaddrfrom[$idx], -10);
      $hiip = substr("0000000000" . $geoipaddrupto[$idx], -10);

      if($loip <= $ip && $hiip >= $ip)
      {
        $ct = $geoipctry[$idx];
        break;
      }
      else if($loip > $ip)
      {
        if($upto == $idx)
          break;
        $upto = $idx;
      }
      else if($hiip < $ip)
      {
        if($from == $idx)
          break;
        $from = $idx;
      }
    }

    // cache the country code
    $geoipcache[$ipn] = $ct;
  }

  $type = trim(strtolower($type));

  if($type == "abbr")
    $ct = $geoipcntry[$ct];
  else if($type == "name")
    $ct = $geoipcountry[$ct];

  return $ct;
}