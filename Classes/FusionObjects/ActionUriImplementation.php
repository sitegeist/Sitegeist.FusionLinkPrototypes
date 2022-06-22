<?php
declare(strict_types=1);

namespace Sitegeist\FusionLinkPrototypes\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Routing\UriBuilder;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class ActionUriImplementation extends AbstractFusionObject
{
    /**
     * @Flow\Inject
     * @var UriBuilder
     */
    protected $uriBuilder;

    /**
     * Key of the target package
     *
     * @return string|null
     */
    public function getPackage(): ?string
    {
        return $this->fusionValue('package');
    }

    /**
     * Key of the target sub package
     *
     * @return string|null
     */
    public function getSubpackage(): ?string
    {
        return $this->fusionValue('subpackage');
    }

    /**
     * Target controller name
     *
     * @return string|null
     */
    public function getController(): ?string
    {
        return $this->fusionValue('controller');
    }

    /**
     * Target controller action name
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->fusionValue('action');
    }

    /**
     * Controller arguments
     *
     * @return mixed[]|null
     */
    public function getArguments(): ?array
    {
        $arguments = $this->fusionValue('arguments');
        return is_array($arguments) ? $arguments: [];
    }

    /**
     * The requested format, for example "html"
     *
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->fusionValue('format');
    }

    /**
     * The anchor to be appended to the URL
     *
     * @return string|null
     */
    public function getSection(): ?string
    {
        return (string)$this->fusionValue('section');
    }

    /**
     * Additional query parameters that won't be prefixed like $arguments (overrule $arguments)
     *
     * @return mixed[]|null
     */
    public function getAdditionalParams()
    {
        return $this->fusionValue('additionalParams');
    }


    /**
     * Arguments to be removed from the URI. Only active if addQueryString = true
     *
     * @return mixed[]|null
     */
    public function getArgumentsToBeExcludedFromQueryString(): ?array
    {
        return $this->fusionValue('argumentsToBeExcludedFromQueryString');
    }

    /**
     * If true, the current query parameters will be kept in the URI
     *
     * @return boolean|null
     */
    public function isAddQueryString(): ?bool
    {
        return (boolean)$this->fusionValue('addQueryString');
    }

    /**
     * If true, an absolute URI is rendered
     *
     * @return boolean|null
     */
    public function isAbsolute(): ?bool
    {
        return (boolean)$this->fusionValue('absolute');
    }

    public function evaluate(): string
    {
        $mainRequest = $this->runtime->getControllerContext()->getRequest()->getMainRequest();
        $this->uriBuilder->setRequest($mainRequest);

        $format = $this->getFormat();
        if ($format !== null) {
            $this->uriBuilder->setFormat($format);
        }

        $additionalParams = $this->getAdditionalParams();
        if ($additionalParams !== null) {
            $this->uriBuilder->setArguments($additionalParams);
        }

        $argumentsToBeExcludedFromQueryString = $this->getArgumentsToBeExcludedFromQueryString();
        if ($argumentsToBeExcludedFromQueryString !== null) {
            $this->uriBuilder->setArgumentsToBeExcludedFromQueryString($argumentsToBeExcludedFromQueryString);
        }

        $absolute = $this->isAbsolute();
        if ($absolute === true) {
            $this->uriBuilder->setCreateAbsoluteUri(true);
        }

        $section = $this->getSection();
        if ($section !== null) {
            $this->uriBuilder->setSection($section);
        }

        $addQueryString = $this->isAddQueryString();
        if ($addQueryString === true) {
            $this->uriBuilder->setAddQueryString(true);
        }

        try {
            return $this->uriBuilder->uriFor(
                $this->getAction() ?? $mainRequest->getControllerActionName(),
                $this->getArguments() ?? [],
                $this->getController(),
                $this->getPackage(),
                $this->getSubpackage()
            );
        } catch (\Exception $exception) {
            return $this->runtime->handleRenderingException($this->path, $exception);
        }
    }
}
