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
            'L',
            // Matomo
            'mtm_campaign',
            'mtm_keyword',
            'mtm_kwd',
            'mtm_source',
            'mtm_medium',
            'mtm_content',
            'mtm_cid',
            'mtm_group',
            'mtm_placement',
            // Piwik
            'pk_campaign',
            'pk_kwd',
            '_stg_debug',
            // Google
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_term',
            'utm_content',
            'utm_id',
            'utm_source_platform',
            'utm_creative_format',
            'utm_marketing_tactic',
            'gtm_debug',
            '_ga',
            '_gl',
            // Google ads
            'gad',
            'gad_source',
            'gad_campaignid',
            'gbraid',
            'wbraid',
            'gclid',
            'gclsrc',
            'dclid',
            // Facebook
            'fbclid',
            // LinkedIn
            'li_fat_id',
            // TikTok
            'ttclid',
            // Twitter
            'twclid',
            // Yahoo
            'yclid',
            // Awin / Zanox
            'zanpid',
            // Mailchimp
            'mc_cid',
            'mc_eid',
            // Instagram
            'igshid',
            // Impact
            'irclickid',
            // Pinterest
            'epik',
            // Branch.io
            '_branch_match_id',
            // etracker
            'etcc_[a-z]+',
            // Microsoft Bing Ads.
            'msclkid',
            // HubSpot Ad Tracking Parameters
            'hsa_acc',
            'hsa_ad',
            'hsa_cam',
            'hsa_grp',
            'hsa_kw',
            'hsa_mt',
            'hsa_net',
            'hsa_src',
            'hsa_tgt',
            'hsa_ver',
            'hsa_ol',
            'hsa_la',
            // HubSpot Email Tracking Parameters
            '_hsenc',
            '_hsmi',
            // HubSpot CTA Tracking Parameters
            '__hssc',
            '__hstc',
            '__hsfp',
            'hsCtaTracking',
            // HubSpot Form Tracking Parameters
            'submissionGuid',
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
