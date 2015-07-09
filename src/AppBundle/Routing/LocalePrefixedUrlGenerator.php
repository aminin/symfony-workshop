<?php

namespace AppBundle\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Generator\UrlGenerator as BaseUrlGenerator;

/**
 * UrlGenerator generates URL based on a set of routes.
 */
class LocalePrefixedUrlGenerator extends BaseUrlGenerator
{
    /**
     * @throws MissingMandatoryParametersException When route has some missing mandatory parameters
     * @throws InvalidParameterException When a parameter value is not correct
     */
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, array $requiredSchemes = [])
    {
        $baseUrl = $this->getContext()->getBaseUrl();

        if ($name[0] != '_' && $locale = $this->getContext()->getParameter('_locale')) {
            $this->getContext()->setBaseUrl($baseUrl . '/' . $locale);
        }

        $result = parent::doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);

        $this->getContext()->setBaseUrl($baseUrl);

        return $result;
    }
}