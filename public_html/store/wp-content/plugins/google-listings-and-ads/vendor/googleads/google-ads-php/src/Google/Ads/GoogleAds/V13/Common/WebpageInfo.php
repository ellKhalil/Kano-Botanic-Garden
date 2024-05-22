<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v13/common/criteria.proto

namespace Google\Ads\GoogleAds\V13\Common;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents a criterion for targeting webpages of an advertiser's website.
 *
 * Generated from protobuf message <code>google.ads.googleads.v13.common.WebpageInfo</code>
 */
class WebpageInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * The name of the criterion that is defined by this parameter. The name value
     * will be used for identifying, sorting and filtering criteria with this type
     * of parameters.
     * This field is required for CREATE operations and is prohibited on UPDATE
     * operations.
     *
     * Generated from protobuf field <code>optional string criterion_name = 3;</code>
     */
    protected $criterion_name = null;
    /**
     * Conditions, or logical expressions, for webpage targeting. The list of
     * webpage targeting conditions are and-ed together when evaluated
     * for targeting. An empty list of conditions indicates all pages of the
     * campaign's website are targeted.
     * This field is required for CREATE operations and is prohibited on UPDATE
     * operations.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v13.common.WebpageConditionInfo conditions = 2;</code>
     */
    private $conditions;
    /**
     * Website criteria coverage percentage. This is the computed percentage
     * of website coverage based on the website target, negative website target
     * and negative keywords in the ad group and campaign. For instance, when
     * coverage returns as 1, it indicates it has 100% coverage. This field is
     * read-only.
     *
     * Generated from protobuf field <code>double coverage_percentage = 4;</code>
     */
    protected $coverage_percentage = 0.0;
    /**
     * List of sample urls that match the website target. This field is read-only.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v13.common.WebpageSampleInfo sample = 5;</code>
     */
    protected $sample = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $criterion_name
     *           The name of the criterion that is defined by this parameter. The name value
     *           will be used for identifying, sorting and filtering criteria with this type
     *           of parameters.
     *           This field is required for CREATE operations and is prohibited on UPDATE
     *           operations.
     *     @type array<\Google\Ads\GoogleAds\V13\Common\WebpageConditionInfo>|\Google\Protobuf\Internal\RepeatedField $conditions
     *           Conditions, or logical expressions, for webpage targeting. The list of
     *           webpage targeting conditions are and-ed together when evaluated
     *           for targeting. An empty list of conditions indicates all pages of the
     *           campaign's website are targeted.
     *           This field is required for CREATE operations and is prohibited on UPDATE
     *           operations.
     *     @type float $coverage_percentage
     *           Website criteria coverage percentage. This is the computed percentage
     *           of website coverage based on the website target, negative website target
     *           and negative keywords in the ad group and campaign. For instance, when
     *           coverage returns as 1, it indicates it has 100% coverage. This field is
     *           read-only.
     *     @type \Google\Ads\GoogleAds\V13\Common\WebpageSampleInfo $sample
     *           List of sample urls that match the website target. This field is read-only.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V13\Common\Criteria::initOnce();
        parent::__construct($data);
    }

    /**
     * The name of the criterion that is defined by this parameter. The name value
     * will be used for identifying, sorting and filtering criteria with this type
     * of parameters.
     * This field is required for CREATE operations and is prohibited on UPDATE
     * operations.
     *
     * Generated from protobuf field <code>optional string criterion_name = 3;</code>
     * @return string
     */
    public function getCriterionName()
    {
        return isset($this->criterion_name) ? $this->criterion_name : '';
    }

    public function hasCriterionName()
    {
        return isset($this->criterion_name);
    }

    public function clearCriterionName()
    {
        unset($this->criterion_name);
    }

    /**
     * The name of the criterion that is defined by this parameter. The name value
     * will be used for identifying, sorting and filtering criteria with this type
     * of parameters.
     * This field is required for CREATE operations and is prohibited on UPDATE
     * operations.
     *
     * Generated from protobuf field <code>optional string criterion_name = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setCriterionName($var)
    {
        GPBUtil::checkString($var, True);
        $this->criterion_name = $var;

        return $this;
    }

    /**
     * Conditions, or logical expressions, for webpage targeting. The list of
     * webpage targeting conditions are and-ed together when evaluated
     * for targeting. An empty list of conditions indicates all pages of the
     * campaign's website are targeted.
     * This field is required for CREATE operations and is prohibited on UPDATE
     * operations.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v13.common.WebpageConditionInfo conditions = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Conditions, or logical expressions, for webpage targeting. The list of
     * webpage targeting conditions are and-ed together when evaluated
     * for targeting. An empty list of conditions indicates all pages of the
     * campaign's website are targeted.
     * This field is required for CREATE operations and is prohibited on UPDATE
     * operations.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v13.common.WebpageConditionInfo conditions = 2;</code>
     * @param array<\Google\Ads\GoogleAds\V13\Common\WebpageConditionInfo>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setConditions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V13\Common\WebpageConditionInfo::class);
        $this->conditions = $arr;

        return $this;
    }

    /**
     * Website criteria coverage percentage. This is the computed percentage
     * of website coverage based on the website target, negative website target
     * and negative keywords in the ad group and campaign. For instance, when
     * coverage returns as 1, it indicates it has 100% coverage. This field is
     * read-only.
     *
     * Generated from protobuf field <code>double coverage_percentage = 4;</code>
     * @return float
     */
    public function getCoveragePercentage()
    {
        return $this->coverage_percentage;
    }

    /**
     * Website criteria coverage percentage. This is the computed percentage
     * of website coverage based on the website target, negative website target
     * and negative keywords in the ad group and campaign. For instance, when
     * coverage returns as 1, it indicates it has 100% coverage. This field is
     * read-only.
     *
     * Generated from protobuf field <code>double coverage_percentage = 4;</code>
     * @param float $var
     * @return $this
     */
    public function setCoveragePercentage($var)
    {
        GPBUtil::checkDouble($var);
        $this->coverage_percentage = $var;

        return $this;
    }

    /**
     * List of sample urls that match the website target. This field is read-only.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v13.common.WebpageSampleInfo sample = 5;</code>
     * @return \Google\Ads\GoogleAds\V13\Common\WebpageSampleInfo|null
     */
    public function getSample()
    {
        return $this->sample;
    }

    public function hasSample()
    {
        return isset($this->sample);
    }

    public function clearSample()
    {
        unset($this->sample);
    }

    /**
     * List of sample urls that match the website target. This field is read-only.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v13.common.WebpageSampleInfo sample = 5;</code>
     * @param \Google\Ads\GoogleAds\V13\Common\WebpageSampleInfo $var
     * @return $this
     */
    public function setSample($var)
    {
        GPBUtil::checkMessage($var, \Google\Ads\GoogleAds\V13\Common\WebpageSampleInfo::class);
        $this->sample = $var;

        return $this;
    }

}

