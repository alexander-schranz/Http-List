<?php

declare(strict_types=1);

/*
 * This file is part of the CMS-IG HttpList project.
 *
 * (c) Alexander Schranz <alexander@sulu.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CmsIg\HttpList;

final class Queries
{
    /**
     * Regex fragments (without delimiters and anchors) matching the names of irrelevant query parameters.
     *
     * @return string[]
     */
    public static function getQueries(): array
    {
        return [
            // TYPO3 (legacy language parameter)
            'L',

            // Matomo / Piwik
            'mtm_.*',
            'matomo_.*',
            'piwik_.*',
            'pk_.*',
            '_stg_debug',

            // Google Analytics / Tag Manager
            'utm_.*',
            'gtm_debug',
            '_ga',
            '_gl',

            // Google Ads
            'gad',
            'gad_source',
            'gad_campaignid',
            'gbraid',
            'wbraid',
            'gclid',
            'gclsrc',
            'dclid',
            'ved',

            // Google Custom Search
            'cx',
            'ie',
            'cof',
            'siteurl',

            // Facebook / Instagram
            'fbclid',
            'igshid',

            // LinkedIn
            'li_fat_id',

            // TikTok
            'ttclid',

            // Twitter
            'twclid',

            // Yahoo
            'yclid',

            // Microsoft Bing Ads
            'msclkid',
            '_bta_.*',

            // Awin / Zanox
            'zanpid',

            // Rakuten
            'rtid',

            // Impact
            'irclickid',

            // Pinterest
            'epik',

            // Branch.io
            '_branch_match_id',

            // Mailchimp
            'mc_.*',

            // SMS campaigns
            'sms_click',
            'sms_source',
            'sms_uph',

            // eBay
            'mkcid',
            'mkevt',
            'mkrid',
            'mkwid',
            'toolid',

            // etracker
            'etcc_.*',

            // HubSpot
            'hsa_.*',
            '_hsenc',
            '_hsmi',
            '__hssc',
            '__hstc',
            '__hsfp',
            'hsCtaTracking',
            'submissionGuid',

            // Upsun URL normalization (no single tool named)
            'campid',
            'customid',
            'dm_i',
            'ef_id',
            'gdffi',
            'gdfms',
            'gdftrk',
            '_ke',
            '_kx',
            'nb_klid',
            'ndclid',
            'origin',
            'pcrid',
            'redirect_.*',
            'trk_.*',
            'sb_referer_host',
            'ScCid',
            'si',
            's_kwcid',
        ];
    }

    /**
     * One anchored regex (with delimiters) matching the names of all irrelevant query parameters.
     */
    public static function getQueriesRegex(): string
    {
        return Regex::combine(self::getQueries());
    }

    /**
     * Whether the given query parameter name is irrelevant.
     */
    public static function matches(string $name): bool
    {
        return 1 === \preg_match(self::getQueriesRegex(), $name);
    }
}
