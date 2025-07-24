<?php

/*
 * The MIT License
 *
 * Copyright (c) 2025 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace NTLAB\Lib\PhoneNumber;

/**
 * International Calling Codes.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class ICC
{
    /**
     * @var \NTLAB\Lib\PhoneNumber\Country[]
     */
    protected static $countries = null;

    /**
     * @var \NTLAB\Lib\PhoneNumber\Country[]
     */
    protected static $sortedCountries = null;

    // https://countrycode.org
    protected static $iccs = [
        ['id' => 'ad', 'country' => 'Andorra', 'code' => '376'],
        ['id' => 'ae', 'country' => 'United Arab Emirates', 'code' => '971'],
        ['id' => 'af', 'country' => 'Afghanistan', 'code' => '93'],
        ['id' => 'ag', 'country' => 'Antigua and Barbuda', 'code' => '1-268'],
        ['id' => 'ai', 'country' => 'Anguilla', 'code' => '1-264'],
        ['id' => 'al', 'country' => 'Albania', 'code' => '355'],
        ['id' => 'am', 'country' => 'Armenia', 'code' => '374'],
        ['id' => 'an', 'country' => 'Netherlands Antilles', 'code' => '599'],
        ['id' => 'ao', 'country' => 'Angola', 'code' => '244'],
        ['id' => 'aq', 'country' => 'Antarctica', 'code' => '672'],
        ['id' => 'ar', 'country' => 'Argentina', 'code' => '54'],
        ['id' => 'as', 'country' => 'American Samoa', 'code' => '1-684'],
        ['id' => 'at', 'country' => 'Austria', 'code' => '43'],
        ['id' => 'au', 'country' => 'Australia', 'code' => '61'],
        ['id' => 'aw', 'country' => 'Aruba', 'code' => '297'],
        ['id' => 'az', 'country' => 'Azerbaijan', 'code' => '994'],
        ['id' => 'ba', 'country' => 'Bosnia and Herzegovina', 'code' => '387'],
        ['id' => 'bb', 'country' => 'Barbados', 'code' => '1-246'],
        ['id' => 'bd', 'country' => 'Bangladesh', 'code' => '880'],
        ['id' => 'be', 'country' => 'Belgium', 'code' => '32'],
        ['id' => 'bf', 'country' => 'Burkina Faso', 'code' => '226'],
        ['id' => 'bg', 'country' => 'Bulgaria', 'code' => '359'],
        ['id' => 'bh', 'country' => 'Bahrain', 'code' => '973'],
        ['id' => 'bi', 'country' => 'Burundi', 'code' => '257'],
        ['id' => 'bj', 'country' => 'Benin', 'code' => '229'],
        ['id' => 'bl', 'country' => 'Saint Barthelemy', 'code' => '590'],
        ['id' => 'bm', 'country' => 'Bermuda', 'code' => '1-441'],
        ['id' => 'bn', 'country' => 'Brunei', 'code' => '673'],
        ['id' => 'bo', 'country' => 'Bolivia', 'code' => '591'],
        ['id' => 'br', 'country' => 'Brazil', 'code' => '55'],
        ['id' => 'bs', 'country' => 'Bahamas', 'code' => '1-242'],
        ['id' => 'bt', 'country' => 'Bhutan', 'code' => '975'],
        ['id' => 'bw', 'country' => 'Botswana', 'code' => '267'],
        ['id' => 'by', 'country' => 'Belarus', 'code' => '375'],
        ['id' => 'bz', 'country' => 'Belize', 'code' => '501'],
        ['id' => 'ca', 'country' => 'Canada', 'code' => '1'],
        ['id' => 'cc', 'country' => 'Cocos Islands', 'code' => '61'],
        ['id' => 'cd', 'country' => 'Democratic Republic of the Congo', 'code' => '243'],
        ['id' => 'cf', 'country' => 'Central African Republic', 'code' => '236'],
        ['id' => 'cg', 'country' => 'Republic of the Congo', 'code' => '242'],
        ['id' => 'ch', 'country' => 'Switzerland', 'code' => '41'],
        ['id' => 'ci', 'country' => 'Ivory Coast', 'code' => '225'],
        ['id' => 'ck', 'country' => 'Cook Islands', 'code' => '682'],
        ['id' => 'cl', 'country' => 'Chile', 'code' => '56'],
        ['id' => 'cm', 'country' => 'Cameroon', 'code' => '237'],
        ['id' => 'cn', 'country' => 'China', 'code' => '86'],
        ['id' => 'co', 'country' => 'Colombia', 'code' => '57'],
        ['id' => 'cr', 'country' => 'Costa Rica', 'code' => '506'],
        ['id' => 'cu', 'country' => 'Cuba', 'code' => '53'],
        ['id' => 'cv', 'country' => 'Cape Verde', 'code' => '238'],
        ['id' => 'cw', 'country' => 'Curacao', 'code' => '599'],
        ['id' => 'cx', 'country' => 'Christmas Island', 'code' => '61'],
        ['id' => 'cy', 'country' => 'Cyprus', 'code' => '357'],
        ['id' => 'cz', 'country' => 'Czech Republic', 'code' => '420'],
        ['id' => 'de', 'country' => 'Germany', 'code' => '49'],
        ['id' => 'dj', 'country' => 'Djibouti', 'code' => '253'],
        ['id' => 'dk', 'country' => 'Denmark', 'code' => '45'],
        ['id' => 'dm', 'country' => 'Dominica', 'code' => '1-767'],
        ['id' => 'do', 'country' => 'Dominican Republic', 'code' => '1-809'],
        ['id' => 'do', 'country' => 'Dominican Republic', 'code' => '1-829'],
        ['id' => 'do', 'country' => 'Dominican Republic', 'code' => '1-849'],
        ['id' => 'dz', 'country' => 'Algeria', 'code' => '213'],
        ['id' => 'ec', 'country' => 'Ecuador', 'code' => '593'],
        ['id' => 'ee', 'country' => 'Estonia', 'code' => '372'],
        ['id' => 'eg', 'country' => 'Egypt', 'code' => '20'],
        ['id' => 'eh', 'country' => 'Western Sahara', 'code' => '212'],
        ['id' => 'er', 'country' => 'Eritrea', 'code' => '291'],
        ['id' => 'es', 'country' => 'Spain', 'code' => '34'],
        ['id' => 'et', 'country' => 'Ethiopia', 'code' => '251'],
        ['id' => 'fi', 'country' => 'Finland', 'code' => '358'],
        ['id' => 'fj', 'country' => 'Fiji', 'code' => '679'],
        ['id' => 'fk', 'country' => 'Falkland Islands', 'code' => '500'],
        ['id' => 'fm', 'country' => 'Micronesia', 'code' => '691'],
        ['id' => 'fo', 'country' => 'Faroe Islands', 'code' => '298'],
        ['id' => 'fr', 'country' => 'France', 'code' => '33'],
        ['id' => 'ga', 'country' => 'Gabon', 'code' => '241'],
        ['id' => 'gb', 'country' => 'United Kingdom', 'code' => '44'],
        ['id' => 'gd', 'country' => 'Grenada', 'code' => '1-473'],
        ['id' => 'ge', 'country' => 'Georgia', 'code' => '995'],
        ['id' => 'gg', 'country' => 'Guernsey', 'code' => '44-1481'],
        ['id' => 'gh', 'country' => 'Ghana', 'code' => '233'],
        ['id' => 'gi', 'country' => 'Gibraltar', 'code' => '350'],
        ['id' => 'gl', 'country' => 'Greenland', 'code' => '299'],
        ['id' => 'gm', 'country' => 'Gambia', 'code' => '220'],
        ['id' => 'gn', 'country' => 'Guinea', 'code' => '224'],
        ['id' => 'gq', 'country' => 'Equatorial Guinea', 'code' => '240'],
        ['id' => 'gr', 'country' => 'Greece', 'code' => '30'],
        ['id' => 'gt', 'country' => 'Guatemala', 'code' => '502'],
        ['id' => 'gu', 'country' => 'Guam', 'code' => '1-671'],
        ['id' => 'gw', 'country' => 'Guinea-Bissau', 'code' => '245'],
        ['id' => 'gy', 'country' => 'Guyana', 'code' => '592'],
        ['id' => 'hk', 'country' => 'Hong Kong', 'code' => '852'],
        ['id' => 'hn', 'country' => 'Honduras', 'code' => '504'],
        ['id' => 'hr', 'country' => 'Croatia', 'code' => '385'],
        ['id' => 'ht', 'country' => 'Haiti', 'code' => '509'],
        ['id' => 'hu', 'country' => 'Hungary', 'code' => '36'],
        ['id' => 'id', 'country' => 'Indonesia', 'code' => '62'],
        ['id' => 'ie', 'country' => 'Ireland', 'code' => '353'],
        ['id' => 'il', 'country' => 'Israel', 'code' => '972'],
        ['id' => 'im', 'country' => 'Isle of Man', 'code' => '44-1624'],
        ['id' => 'in', 'country' => 'India', 'code' => '91'],
        ['id' => 'io', 'country' => 'British Indian Ocean Territory', 'code' => '246'],
        ['id' => 'iq', 'country' => 'Iraq', 'code' => '964'],
        ['id' => 'ir', 'country' => 'Iran', 'code' => '98'],
        ['id' => 'is', 'country' => 'Iceland', 'code' => '354'],
        ['id' => 'it', 'country' => 'Italy', 'code' => '39'],
        ['id' => 'je', 'country' => 'Jersey', 'code' => '44-1534'],
        ['id' => 'jm', 'country' => 'Jamaica', 'code' => '1-876'],
        ['id' => 'jo', 'country' => 'Jordan', 'code' => '962'],
        ['id' => 'jp', 'country' => 'Japan', 'code' => '81'],
        ['id' => 'ke', 'country' => 'Kenya', 'code' => '254'],
        ['id' => 'kg', 'country' => 'Kyrgyzstan', 'code' => '996'],
        ['id' => 'kh', 'country' => 'Cambodia', 'code' => '855'],
        ['id' => 'ki', 'country' => 'Kiribati', 'code' => '686'],
        ['id' => 'km', 'country' => 'Comoros', 'code' => '269'],
        ['id' => 'kn', 'country' => 'Saint Kitts and Nevis', 'code' => '1-869'],
        ['id' => 'kp', 'country' => 'North Korea', 'code' => '850'],
        ['id' => 'kr', 'country' => 'South Korea', 'code' => '82'],
        ['id' => 'kw', 'country' => 'Kuwait', 'code' => '965'],
        ['id' => 'ky', 'country' => 'Cayman Islands', 'code' => '1-345'],
        ['id' => 'kz', 'country' => 'Kazakhstan', 'code' => '7'],
        ['id' => 'la', 'country' => 'Laos', 'code' => '856'],
        ['id' => 'lb', 'country' => 'Lebanon', 'code' => '961'],
        ['id' => 'lc', 'country' => 'Saint Lucia', 'code' => '1-758'],
        ['id' => 'li', 'country' => 'Liechtenstein', 'code' => '423'],
        ['id' => 'lk', 'country' => 'Sri Lanka', 'code' => '94'],
        ['id' => 'lr', 'country' => 'Liberia', 'code' => '231'],
        ['id' => 'ls', 'country' => 'Lesotho', 'code' => '266'],
        ['id' => 'lt', 'country' => 'Lithuania', 'code' => '370'],
        ['id' => 'lu', 'country' => 'Luxembourg', 'code' => '352'],
        ['id' => 'lv', 'country' => 'Latvia', 'code' => '371'],
        ['id' => 'ly', 'country' => 'Libya', 'code' => '218'],
        ['id' => 'ma', 'country' => 'Morocco', 'code' => '212'],
        ['id' => 'mc', 'country' => 'Monaco', 'code' => '377'],
        ['id' => 'md', 'country' => 'Moldova', 'code' => '373'],
        ['id' => 'me', 'country' => 'Montenegro', 'code' => '382'],
        ['id' => 'mf', 'country' => 'Saint Martin', 'code' => '590'],
        ['id' => 'mg', 'country' => 'Madagascar', 'code' => '261'],
        ['id' => 'mh', 'country' => 'Marshall Islands', 'code' => '692'],
        ['id' => 'mk', 'country' => 'Macedonia', 'code' => '389'],
        ['id' => 'ml', 'country' => 'Mali', 'code' => '223'],
        ['id' => 'mm', 'country' => 'Myanmar', 'code' => '95'],
        ['id' => 'mn', 'country' => 'Mongolia', 'code' => '976'],
        ['id' => 'mo', 'country' => 'Macau', 'code' => '853'],
        ['id' => 'mp', 'country' => 'Northern Mariana Islands', 'code' => '1-670'],
        ['id' => 'mr', 'country' => 'Mauritania', 'code' => '222'],
        ['id' => 'ms', 'country' => 'Montserrat', 'code' => '1-664'],
        ['id' => 'mt', 'country' => 'Malta', 'code' => '356'],
        ['id' => 'mu', 'country' => 'Mauritius', 'code' => '230'],
        ['id' => 'mv', 'country' => 'Maldives', 'code' => '960'],
        ['id' => 'mw', 'country' => 'Malawi', 'code' => '265'],
        ['id' => 'mx', 'country' => 'Mexico', 'code' => '52'],
        ['id' => 'my', 'country' => 'Malaysia', 'code' => '60'],
        ['id' => 'mz', 'country' => 'Mozambique', 'code' => '258'],
        ['id' => 'na', 'country' => 'Namibia', 'code' => '264'],
        ['id' => 'nc', 'country' => 'New Caledonia', 'code' => '687'],
        ['id' => 'ne', 'country' => 'Niger', 'code' => '227'],
        ['id' => 'ng', 'country' => 'Nigeria', 'code' => '234'],
        ['id' => 'ni', 'country' => 'Nicaragua', 'code' => '505'],
        ['id' => 'nl', 'country' => 'Netherlands', 'code' => '31'],
        ['id' => 'no', 'country' => 'Norway', 'code' => '47'],
        ['id' => 'np', 'country' => 'Nepal', 'code' => '977'],
        ['id' => 'nr', 'country' => 'Nauru', 'code' => '674'],
        ['id' => 'nu', 'country' => 'Niue', 'code' => '683'],
        ['id' => 'nz', 'country' => 'New Zealand', 'code' => '64'],
        ['id' => 'om', 'country' => 'Oman', 'code' => '968'],
        ['id' => 'pa', 'country' => 'Panama', 'code' => '507'],
        ['id' => 'pe', 'country' => 'Peru', 'code' => '51'],
        ['id' => 'pf', 'country' => 'French Polynesia', 'code' => '689'],
        ['id' => 'pg', 'country' => 'Papua New Guinea', 'code' => '675'],
        ['id' => 'ph', 'country' => 'Philippines', 'code' => '63'],
        ['id' => 'pk', 'country' => 'Pakistan', 'code' => '92'],
        ['id' => 'pl', 'country' => 'Poland', 'code' => '48'],
        ['id' => 'pm', 'country' => 'Saint Pierre and Miquelon', 'code' => '508'],
        ['id' => 'pn', 'country' => 'Pitcairn', 'code' => '64'],
        ['id' => 'pr', 'country' => 'Puerto Rico', 'code' => '1-787'],
        ['id' => 'pr', 'country' => 'Puerto Rico', 'code' => '1-939'],
        ['id' => 'ps', 'country' => 'Palestine', 'code' => '970'],
        ['id' => 'pt', 'country' => 'Portugal', 'code' => '351'],
        ['id' => 'pw', 'country' => 'Palau', 'code' => '680'],
        ['id' => 'py', 'country' => 'Paraguay', 'code' => '595'],
        ['id' => 'qa', 'country' => 'Qatar', 'code' => '974'],
        ['id' => 're', 'country' => 'Reunion', 'code' => '262'],
        ['id' => 'ro', 'country' => 'Romania', 'code' => '40'],
        ['id' => 'rs', 'country' => 'Serbia', 'code' => '381'],
        ['id' => 'ru', 'country' => 'Russia', 'code' => '7'],
        ['id' => 'rw', 'country' => 'Rwanda', 'code' => '250'],
        ['id' => 'sa', 'country' => 'Saudi Arabia', 'code' => '966'],
        ['id' => 'sb', 'country' => 'Solomon Islands', 'code' => '677'],
        ['id' => 'sc', 'country' => 'Seychelles', 'code' => '248'],
        ['id' => 'sd', 'country' => 'Sudan', 'code' => '249'],
        ['id' => 'se', 'country' => 'Sweden', 'code' => '46'],
        ['id' => 'sg', 'country' => 'Singapore', 'code' => '65'],
        ['id' => 'sh', 'country' => 'Saint Helena', 'code' => '290'],
        ['id' => 'si', 'country' => 'Slovenia', 'code' => '386'],
        ['id' => 'sj', 'country' => 'Svalbard and Jan Mayen', 'code' => '47'],
        ['id' => 'sk', 'country' => 'Slovakia', 'code' => '421'],
        ['id' => 'sl', 'country' => 'Sierra Leone', 'code' => '232'],
        ['id' => 'sm', 'country' => 'San Marino', 'code' => '378'],
        ['id' => 'sn', 'country' => 'Senegal', 'code' => '221'],
        ['id' => 'so', 'country' => 'Somalia', 'code' => '252'],
        ['id' => 'sr', 'country' => 'Suriname', 'code' => '597'],
        ['id' => 'ss', 'country' => 'South Sudan', 'code' => '211'],
        ['id' => 'st', 'country' => 'Sao Tome and Principe', 'code' => '239'],
        ['id' => 'sv', 'country' => 'El Salvador', 'code' => '503'],
        ['id' => 'sx', 'country' => 'Sint Maarten', 'code' => '1-721'],
        ['id' => 'sy', 'country' => 'Syria', 'code' => '963'],
        ['id' => 'sz', 'country' => 'Swaziland', 'code' => '268'],
        ['id' => 'tc', 'country' => 'Turks and Caicos Islands', 'code' => '1-649'],
        ['id' => 'td', 'country' => 'Chad', 'code' => '235'],
        ['id' => 'tg', 'country' => 'Togo', 'code' => '228'],
        ['id' => 'th', 'country' => 'Thailand', 'code' => '66'],
        ['id' => 'tj', 'country' => 'Tajikistan', 'code' => '992'],
        ['id' => 'tk', 'country' => 'Tokelau', 'code' => '690'],
        ['id' => 'tl', 'country' => 'East Timor', 'code' => '670'],
        ['id' => 'tm', 'country' => 'Turkmenistan', 'code' => '993'],
        ['id' => 'tn', 'country' => 'Tunisia', 'code' => '216'],
        ['id' => 'to', 'country' => 'Tonga', 'code' => '676'],
        ['id' => 'tr', 'country' => 'Turkey', 'code' => '90'],
        ['id' => 'tt', 'country' => 'Trinidad and Tobago', 'code' => '1-868'],
        ['id' => 'tv', 'country' => 'Tuvalu', 'code' => '688'],
        ['id' => 'tw', 'country' => 'Taiwan', 'code' => '886'],
        ['id' => 'tz', 'country' => 'Tanzania', 'code' => '255'],
        ['id' => 'ua', 'country' => 'Ukraine', 'code' => '380'],
        ['id' => 'ug', 'country' => 'Uganda', 'code' => '256'],
        ['id' => 'us', 'country' => 'United States', 'code' => '1'],
        ['id' => 'uy', 'country' => 'Uruguay', 'code' => '598'],
        ['id' => 'uz', 'country' => 'Uzbekistan', 'code' => '998'],
        ['id' => 'va', 'country' => 'Vatican', 'code' => '379'],
        ['id' => 'vc', 'country' => 'Saint Vincent and the Grenadines', 'code' => '1-784'],
        ['id' => 've', 'country' => 'Venezuela', 'code' => '58'],
        ['id' => 'vg', 'country' => 'British Virgin Islands', 'code' => '1-284'],
        ['id' => 'vi', 'country' => 'U.S. Virgin Islands', 'code' => '1-340'],
        ['id' => 'vn', 'country' => 'Vietnam', 'code' => '84'],
        ['id' => 'vu', 'country' => 'Vanuatu', 'code' => '678'],
        ['id' => 'wf', 'country' => 'Wallis and Futuna', 'code' => '681'],
        ['id' => 'ws', 'country' => 'Samoa', 'code' => '685'],
        ['id' => 'xk', 'country' => 'Kosovo', 'code' => '383'],
        ['id' => 'ye', 'country' => 'Yemen', 'code' => '967'],
        ['id' => 'yt', 'country' => 'Mayotte', 'code' => '262'],
        ['id' => 'za', 'country' => 'South Africa', 'code' => '27'],
        ['id' => 'zm', 'country' => 'Zambia', 'code' => '260'],
        ['id' => 'zw', 'country' => 'Zimbabwe', 'code' => '263'],
    ];

    /**
     * Get countries.
     *
     * @return \NTLAB\Lib\PhoneNumber\Country[]
     */
    public static function getCountries()
    {
        if (null === static::$countries) {
            static::$countries = array_filter(array_map(fn ($a) => Country::from($a), static::$iccs));
        }

        return static::$countries;
    }

    /**
     * Get countries sorted by longest code first.
     *
     * @return \NTLAB\Lib\PhoneNumber\Country[]
     */
    public static function getCountriesSortedByCode()
    {
        if (null === static::$sortedCountries) {
            static::$sortedCountries = static::getCountries();
            usort(static::$sortedCountries, function ($a, $b) {
                $lenA = strlen($a->getCode());
                $lenB = strlen($b->getCode());
                if ($lenA === $lenB) {
                    return strcmp($a->getCode(), $b->getCode());
                }

                return $lenB - $lenA;
            });
        }

        return static::$sortedCountries;
    }

    /**
     * Get country calling codes.
     *
     * @return array<string, string>
     */
    public static function getCodes()
    {
        $iccs = [];
        foreach (static::getCountries() as $country) {
            $iccs[$country->getId()] = sprintf('%s (+%s)', $country->getName(), $country->getCode());
        }
        asort($iccs);

        return $iccs;
    }
}
