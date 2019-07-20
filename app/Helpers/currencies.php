<?php

$arr_currency_option =['default'=>_l('Main Currency').'|checkbox|yes', 'type'=>_l('Currency position').'|select|left:right:left with space:right with space','rate'=>_l('Rate(to main currency)').' |text|1' ];   

$currencies = [
            'AED' =>array_merge($enable_txt,['name'=>'AED|none','code'=>'&#1583;.&#1573;|text|is'] ,$arr_currency_option), // ?
        	'AFN' =>array_merge($enable_txt,['name'=>'AFN|none','code'=>'&#65;&#102;|text|is'] ,$arr_currency_option),
        	'ALL' =>array_merge($enable_txt,['name'=>'ALL|none','code'=>'&#76;&#101;&#107;|text|is'] ,$arr_currency_option),
        	'AMD' =>array_merge($enable_txt,['name'=>'AMD|none','code'=>'|text|is'] ,$arr_currency_option),
        	'ANG' =>array_merge($enable_txt,['name'=>'ANG|none','code'=>'&#402;|text|is'] ,$arr_currency_option),
        	'AOA' =>array_merge($enable_txt,['name'=>'AOA|none','code'=>'&#75;&#122;|text|is'] ,$arr_currency_option), // ?
        	'ARS' =>array_merge($enable_txt,['name'=>'ARS|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'AUD' =>array_merge($enable_txt,['name'=>'AUD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'AWG' =>array_merge($enable_txt,['name'=>'AWG|none','code'=>'&#402;|text|is'] ,$arr_currency_option),
        	'AZN' =>array_merge($enable_txt,['name'=>'AZN|none','code'=>'&#1084;&#1072;&#1085;|text|is'] ,$arr_currency_option),
        	'BAM' =>array_merge($enable_txt,['name'=>'BAM|none','code'=>'&#75;&#77;|text|is'] ,$arr_currency_option),
        	'BBD' =>array_merge($enable_txt,['name'=>'BBD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'BDT' =>array_merge($enable_txt,['name'=>'BDT|none','code'=>'&#2547;|text|is'] ,$arr_currency_option), // ?
        	'BGN' =>array_merge($enable_txt,['name'=>'BGN|none','code'=>'&#1083;&#1074;|text|is'] ,$arr_currency_option),
        	'BHD' =>array_merge($enable_txt,['name'=>'BHD|none','code'=>'.&#1583;.&#1576;|text|is'] ,$arr_currency_option), // ?
        	'BIF' =>array_merge($enable_txt,['name'=>'BIF|none','code'=>'&#70;&#66;&#117;|text|is'] ,$arr_currency_option), // ?
        	'BMD' =>array_merge($enable_txt,['name'=>'BMD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'BND' =>array_merge($enable_txt,['name'=>'BND|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'BOB' =>array_merge($enable_txt,['name'=>'BOB|none','code'=>'&#36;&#98;|text|is'] ,$arr_currency_option),
        	'BRL' =>array_merge($enable_txt,['name'=>'BRL|none','code'=>'&#82;&#36;|text|is'] ,$arr_currency_option),
        	'BSD' =>array_merge($enable_txt,['name'=>'BSD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'BTN' =>array_merge($enable_txt,['name'=>'BTN|none','code'=>'&#78;&#117;&#46;|text|is'] ,$arr_currency_option), // ?
        	'BWP' =>array_merge($enable_txt,['name'=>'BWP|none','code'=>'&#80;|text|is'] ,$arr_currency_option),
        	'BYR' =>array_merge($enable_txt,['name'=>'BYR|none','code'=>'&#112;&#46;|text|is'] ,$arr_currency_option),
        	'BZD' =>array_merge($enable_txt,['name'=>'BZD|none','code'=>'&#66;&#90;&#36;|text|is'] ,$arr_currency_option),
        	'CAD' =>array_merge($enable_txt,['name'=>'CAD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'CDF' =>array_merge($enable_txt,['name'=>'CDF|none','code'=>'&#70;&#67;|text|is'] ,$arr_currency_option),
        	'CHF' =>array_merge($enable_txt,['name'=>'CHF|none','code'=>'&#67;&#72;&#70;|text|is'] ,$arr_currency_option),
        	'CLF' =>array_merge($enable_txt,['name'=>'CLF|none','code'=>'|text|is'] ,$arr_currency_option), // ?
        	'CLP' =>array_merge($enable_txt,['name'=>'CLP|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'CNY' =>array_merge($enable_txt,['name'=>'CNY|none','code'=>'&#165;|text|is'] ,$arr_currency_option),
        	'COP' =>array_merge($enable_txt,['name'=>'COP|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'CRC' =>array_merge($enable_txt,['name'=>'CRC|none','code'=>'&#8353;|text|is'] ,$arr_currency_option),
        	'CUP' =>array_merge($enable_txt,['name'=>'CUP|none','code'=>'&#8396;|text|is'] ,$arr_currency_option),
        	'CVE' =>array_merge($enable_txt,['name'=>'CVE|none','code'=>'&#36;|text|is'] ,$arr_currency_option), // ?
        	'CZK' =>array_merge($enable_txt,['name'=>'CZK|none','code'=>'&#75;&#269;|text|is'] ,$arr_currency_option),
        	'DJF' =>array_merge($enable_txt,['name'=>'DJF|none','code'=>'&#70;&#100;&#106;|text|is'] ,$arr_currency_option), // ?
        	'DKK' =>array_merge($enable_txt,['name'=>'DKK|none','code'=>'&#107;&#114;|text|is'] ,$arr_currency_option),
        	'DOP' =>array_merge($enable_txt,['name'=>'DOP|none','code'=>'&#82;&#68;&#36;|text|is'] ,$arr_currency_option),
        	'DZD' =>array_merge($enable_txt,['name'=>'DZD|none','code'=>'&#1583;&#1580;|text|is'] ,$arr_currency_option), // ?
        	'EGP' =>array_merge($enable_txt,['name'=>'EGP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'ETB' =>array_merge($enable_txt,['name'=>'ETB|none','code'=>'&#66;&#114;|text|is'] ,$arr_currency_option),
        	'EUR' =>array_merge($enable_txt,['name'=>'EUR|none','code'=>'&#8364;|text|is'] ,$arr_currency_option),
        	'FJD' =>array_merge($enable_txt,['name'=>'FJD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'FKP' =>array_merge($enable_txt,['name'=>'FKP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'GBP' =>array_merge($enable_txt,['name'=>'GBP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'GEL' =>array_merge($enable_txt,['name'=>'GEL|none','code'=>'&#4314;|text|is'] ,$arr_currency_option), // ?
        	'GHS' =>array_merge($enable_txt,['name'=>'GHS|none','code'=>'&#162;|text|is'] ,$arr_currency_option),
        	'GIP' =>array_merge($enable_txt,['name'=>'GIP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'GMD' =>array_merge($enable_txt,['name'=>'GMD|none','code'=>'&#68;|text|is'] ,$arr_currency_option), // ?
        	'GNF' =>array_merge($enable_txt,['name'=>'GNF|none','code'=>'&#70;&#71;|text|is'] ,$arr_currency_option), // ?
        	'GTQ' =>array_merge($enable_txt,['name'=>'GTQ|none','code'=>'&#81;|text|is'] ,$arr_currency_option),
        	'GYD' =>array_merge($enable_txt,['name'=>'GYD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'HKD' =>array_merge($enable_txt,['name'=>'HKD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'HNL' =>array_merge($enable_txt,['name'=>'HNL|none','code'=>'&#76;|text|is'] ,$arr_currency_option),
        	'HRK' =>array_merge($enable_txt,['name'=>'HRK|none','code'=>'&#107;&#110;|text|is'] ,$arr_currency_option),
        	'HTG' =>array_merge($enable_txt,['name'=>'HTG|none','code'=>'&#71;|text|is'] ,$arr_currency_option), // ?
        	'HUF' =>array_merge($enable_txt,['name'=>'HUF|none','code'=>'&#70;&#116;|text|is'] ,$arr_currency_option),
        	'IDR' =>array_merge($enable_txt,['name'=>'IDR|none','code'=>'&#82;&#112;|text|is'] ,$arr_currency_option),
        	'ILS' =>array_merge($enable_txt,['name'=>'ILS|none','code'=>'&#8362;|text|is'] ,$arr_currency_option),
        	'INR' =>array_merge($enable_txt,['name'=>'INR|none','code'=>'&#8377;|text|is'] ,$arr_currency_option),
        	'IQD' =>array_merge($enable_txt,['name'=>'IQD|none','code'=>'&#1593;.&#1583;|text|is'] ,$arr_currency_option), // ?
        	'IRR' =>array_merge($enable_txt,['name'=>'IRR|none','code'=>'&#65020;|text|is'] ,$arr_currency_option),
        	'ISK' =>array_merge($enable_txt,['name'=>'ISK|none','code'=>'&#107;&#114;|text|is'] ,$arr_currency_option),
        	'JEP' =>array_merge($enable_txt,['name'=>'JEP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'JMD' =>array_merge($enable_txt,['name'=>'JMD|none','code'=>'&#74;&#36;|text|is'] ,$arr_currency_option),
        	'JOD' =>array_merge($enable_txt,['name'=>'JOD|none','code'=>'&#74;&#68;|text|is'] ,$arr_currency_option), // ?
        	'JPY' =>array_merge($enable_txt,['name'=>'JPY|none','code'=>'&#165;|text|is'] ,$arr_currency_option),
        	'KES' =>array_merge($enable_txt,['name'=>'KES|none','code'=>'&#75;&#83;&#104;|text|is'] ,$arr_currency_option), // ?
        	'KGS' =>array_merge($enable_txt,['name'=>'KGS|none','code'=>'&#1083;&#1074;|text|is'] ,$arr_currency_option),
        	'KHR' =>array_merge($enable_txt,['name'=>'KHR|none','code'=>'&#6107;|text|is'] ,$arr_currency_option),
        	'KMF' =>array_merge($enable_txt,['name'=>'KMF|none','code'=>'&#67;&#70;|text|is'] ,$arr_currency_option), // ?
        	'KPW' =>array_merge($enable_txt,['name'=>'KPW|none','code'=>'&#8361;|text|is'] ,$arr_currency_option),
        	'KRW' =>array_merge($enable_txt,['name'=>'KRW|none','code'=>'&#8361;|text|is'] ,$arr_currency_option),
        	'KWD' =>array_merge($enable_txt,['name'=>'KWD|none','code'=>'&#1583;.&#1603;|text|is'] ,$arr_currency_option), // ?
        	'KYD' =>array_merge($enable_txt,['name'=>'KYD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'KZT' =>array_merge($enable_txt,['name'=>'KZT|none','code'=>'&#1083;&#1074;|text|is'] ,$arr_currency_option),
        	'LAK' =>array_merge($enable_txt,['name'=>'LAK|none','code'=>'&#8365;|text|is'] ,$arr_currency_option),
        	'LBP' =>array_merge($enable_txt,['name'=>'LBP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'LKR' =>array_merge($enable_txt,['name'=>'LKR|none','code'=>'&#8360;|text|is'] ,$arr_currency_option),
        	'LRD' =>array_merge($enable_txt,['name'=>'LRD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'LSL' =>array_merge($enable_txt,['name'=>'LSL|none','code'=>'&#76;|text|is'] ,$arr_currency_option), // ?
        	'LTL' =>array_merge($enable_txt,['name'=>'LTL|none','code'=>'&#76;&#116;|text|is'] ,$arr_currency_option),
        	'LVL' =>array_merge($enable_txt,['name'=>'LVL|none','code'=>'&#76;&#115;|text|is'] ,$arr_currency_option),
        	'LYD' =>array_merge($enable_txt,['name'=>'LYD|none','code'=>'&#1604;.&#1583;|text|is'] ,$arr_currency_option), // ?
        	'MAD' =>array_merge($enable_txt,['name'=>'MAD|none','code'=>'&#1583;.&#1605;.|text|is'] ,$arr_currency_option), //?
        	'MDL' =>array_merge($enable_txt,['name'=>'MDL|none','code'=>'&#76;|text|is'] ,$arr_currency_option),
        	'MGA' =>array_merge($enable_txt,['name'=>'MGA|none','code'=>'&#65;&#114;|text|is'] ,$arr_currency_option), // ?
        	'MKD' =>array_merge($enable_txt,['name'=>'MMK|none','code'=>'&#1076;&#1077;&#1085;|text|is'] ,$arr_currency_option),
        	'MMK' =>array_merge($enable_txt,['name'=>'MMK|none','code'=>'&#75;|text|is'] ,$arr_currency_option),
        	'MNT' =>array_merge($enable_txt,['name'=>'MNT|none','code'=>'&#8366;|text|is'] ,$arr_currency_option),
        	'MOP' =>array_merge($enable_txt,['name'=>'MOP|none','code'=>'&#77;&#79;&#80;&#36;|text|is'] ,$arr_currency_option), // ?
        	'MRO' =>array_merge($enable_txt,['name'=>'MRO|none','code'=>'&#85;&#77;|text|is'] ,$arr_currency_option), // ?
        	'MUR' =>array_merge($enable_txt,['name'=>'MUR|none','code'=>'&#8360;|text|is'] ,$arr_currency_option), // ?
        	'MVR' =>array_merge($enable_txt,['name'=>'MVR|none','code'=>'.&#1923;|text|is'] ,$arr_currency_option), // ?
        	'MWK' =>array_merge($enable_txt,['name'=>'MWK|none','code'=>'&#77;&#75;|text|is'] ,$arr_currency_option),
        	'MXN' =>array_merge($enable_txt,['name'=>'MXN|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'MYR' =>array_merge($enable_txt,['name'=>'MYR|none','code'=>'&#82;&#77;|text|is'] ,$arr_currency_option),
        	'MZN' =>array_merge($enable_txt,['name'=>'MZN|none','code'=>'&#77;&#84;|text|is'] ,$arr_currency_option),
        	'NAD' =>array_merge($enable_txt,['name'=>'NAD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'NGN' =>array_merge($enable_txt,['name'=>'NGN|none','code'=>'&#8358;|text|is'] ,$arr_currency_option),
        	'NIO' =>array_merge($enable_txt,['name'=>'NIO|none','code'=>'&#67;&#36;|text|is'] ,$arr_currency_option),
        	'NOK' =>array_merge($enable_txt,['name'=>'NOK|none','code'=>'&#107;&#114;|text|is'] ,$arr_currency_option),
        	'NPR' =>array_merge($enable_txt,['name'=>'NPR|none','code'=>'&#8360;|text|is'] ,$arr_currency_option),
        	'NZD' =>array_merge($enable_txt,['name'=>'NZD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'OMR' =>array_merge($enable_txt,['name'=>'OMR|none','code'=>'&#65020;|text|is'] ,$arr_currency_option),
        	'PAB' =>array_merge($enable_txt,['name'=>'PAB|none','code'=>'&#66;&#47;&#46;|text|is'] ,$arr_currency_option),
        	'PEN' =>array_merge($enable_txt,['name'=>'PEN|none','code'=>'&#83;&#47;&#46;|text|is'] ,$arr_currency_option),
        	'PGK' =>array_merge($enable_txt,['name'=>'PGK|none','code'=>'&#75;|text|is'] ,$arr_currency_option), // ?
        	'PHP' =>array_merge($enable_txt,['name'=>'PHP|none','code'=>'&#8369;|text|is'] ,$arr_currency_option),
        	'PKR' =>array_merge($enable_txt,['name'=>'PKR|none','code'=>'&#8360;|text|is'] ,$arr_currency_option),
        	'PLN' =>array_merge($enable_txt,['name'=>'PLN|none','code'=>'&#122;&#322;|text|is'] ,$arr_currency_option),
        	'PYG' =>array_merge($enable_txt,['name'=>'PYG|none','code'=>'&#71;&#115;|text|is'] ,$arr_currency_option),
        	'QAR' =>array_merge($enable_txt,['name'=>'QAR|none','code'=>'&#65020;|text|is'] ,$arr_currency_option),
        	'RON' =>array_merge($enable_txt,['name'=>'RON|none','code'=>'&#108;&#101;&#105;|text|is'] ,$arr_currency_option),
        	'RSD' =>array_merge($enable_txt,['name'=>'RSD|none','code'=>'&#1044;&#1080;&#1085;&#46;|text|is'] ,$arr_currency_option),
        	'RUB' =>array_merge($enable_txt,['name'=>'RUB|none','code'=>'&#1088;&#1091;&#1073;|text|is'] ,$arr_currency_option),
        	'RWF' =>array_merge($enable_txt,['name'=>'RWF|none','code'=>'&#1585;.&#1587;|text|is'] ,$arr_currency_option),
        	'SAR' =>array_merge($enable_txt,['name'=>'SAR|none','code'=>'&#65020;|text|is'] ,$arr_currency_option),
        	'SBD' =>array_merge($enable_txt,['name'=>'SBD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'SCR' =>array_merge($enable_txt,['name'=>'SCR|none','code'=>'&#8360;|text|is'] ,$arr_currency_option),
        	'SDG' =>array_merge($enable_txt,['name'=>'SDG|none','code'=>'&#163;|text|is'] ,$arr_currency_option), // ?
        	'SEK' =>array_merge($enable_txt,['name'=>'SEK|none','code'=>'&#107;&#114;|text|is'] ,$arr_currency_option),
        	'SGD' =>array_merge($enable_txt,['name'=>'SGD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'SHP' =>array_merge($enable_txt,['name'=>'SHP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'SLL' =>array_merge($enable_txt,['name'=>'SLL|none','code'=>'&#76;&#101;|text|is'] ,$arr_currency_option), // ?
        	'SOS' =>array_merge($enable_txt,['name'=>'SOS|none','code'=>'&#83;|text|is'] ,$arr_currency_option),
        	'SRD' =>array_merge($enable_txt,['name'=>'SRD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'STD' =>array_merge($enable_txt,['name'=>'STD|none','code'=>'&#68;&#98;|text|is'] ,$arr_currency_option), // ?
        	'SVC' =>array_merge($enable_txt,['name'=>'SVC|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'SYP' =>array_merge($enable_txt,['name'=>'SYP|none','code'=>'&#163;|text|is'] ,$arr_currency_option),
        	'SZL' =>array_merge($enable_txt,['name'=>'SZL|none','code'=>'&#76;|text|is'] ,$arr_currency_option), // ?
        	'THB' =>array_merge($enable_txt,['name'=>'THB|none','code'=>'&#3647;|text|is'] ,$arr_currency_option),
        	'TJS' =>array_merge($enable_txt,['name'=>'TJS|none','code'=>'&#84;&#74;&#83;|text|is'] ,$arr_currency_option), // ? TJS (guess)
        	'TMT' =>array_merge($enable_txt,['name'=>'TMT|none','code'=>'&#109;|text|is'] ,$arr_currency_option),
        	'TND' =>array_merge($enable_txt,['name'=>'TND|none','code'=>'&#1583;.&#1578;|text|is'] ,$arr_currency_option),
        	'TOP' =>array_merge($enable_txt,['name'=>'TOP|none','code'=>'&#84;&#36;|text|is'] ,$arr_currency_option),
        	'TRY' =>array_merge($enable_txt,['name'=>'TRY|none','code'=>'&#8356;|text|is'] ,$arr_currency_option), // New Turkey Lira (old symbol used)
        	'TTD' =>array_merge($enable_txt,['name'=>'TTD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'TWD' =>array_merge($enable_txt,['name'=>'TWD|none','code'=>'&#78;&#84;&#36;|text|is'] ,$arr_currency_option),
        	'TZS' =>array_merge($enable_txt,['name'=>'TZS|none','code'=>'|text|is'] ,$arr_currency_option),
        	'UAH' =>array_merge($enable_txt,['name'=>'UAH|none','code'=>'&#8372;|text|is'] ,$arr_currency_option),
        	'UGX' =>array_merge($enable_txt,['name'=>'UGX|none','code'=>'&#85;&#83;&#104;|text|is'] ,$arr_currency_option),
        	'USD' =>array_merge($enable_txt,['name'=>'USD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'UYU' =>array_merge($enable_txt,['name'=>'UYU|none','code'=>'&#36;&#85;|text|is'] ,$arr_currency_option),
        	'UZS' =>array_merge($enable_txt,['name'=>'UZS|none','code'=>'&#1083;&#1074;|text|is'] ,$arr_currency_option),
        	'VEF' =>array_merge($enable_txt,['name'=>'VEF|none','code'=>'&#66;&#115;|text|is'] ,$arr_currency_option),
        	'VND' =>array_merge($enable_txt,['name'=>'VND|none','code'=>'&#8363;|text|is'] ,$arr_currency_option),
        	'VUV' =>array_merge($enable_txt,['name'=>'VUV|none','code'=>'&#86;&#84;|text|is'] ,$arr_currency_option),
        	'WST' =>array_merge($enable_txt,['name'=>'WST|none','code'=>'&#87;&#83;&#36;|text|is'] ,$arr_currency_option),
        	'XAF' =>array_merge($enable_txt,['name'=>'XAF|none','code'=>'&#70;&#67;&#70;&#65;|text|is'] ,$arr_currency_option),
        	'XCD' =>array_merge($enable_txt,['name'=>'XCD|none','code'=>'&#36;|text|is'] ,$arr_currency_option),
        	'XDR' =>array_merge($enable_txt,['name'=>'XDR|none','code'=>'|text|is'] ,$arr_currency_option),
        	'XOF' =>array_merge($enable_txt,['name'=>'XOF|none','code'=>'|text|is'] ,$arr_currency_option),
        	'XPF' =>array_merge($enable_txt,['name'=>'XPF|none','code'=>'&#70;|text|is'] ,$arr_currency_option),
        	'YER' =>array_merge($enable_txt,['name'=>'YER|none','code'=>'&#65020;|text|is'] ,$arr_currency_option),
        	'ZAR' =>array_merge($enable_txt,['name'=>'ZAR|none','code'=>'&#82;|text|is'] ,$arr_currency_option),
        	'ZMK' =>array_merge($enable_txt,['name'=>'ZMK|none','code'=>'&#90;&#75;|text|is'] ,$arr_currency_option), // ?
        	'ZWL' =>array_merge($enable_txt,['name'=>'ZWL|none','code'=>'&#90;&#36;|text|is'] ,$arr_currency_option),
         ]; 
 
 $currencies['title'] =_l('Currency');        