<?php
declare(strict_types=1);

namespace Sitegeist\FusionLinkPrototypes\FusionObjects;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Routing\UriBuilder;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class ModuleUriImplementation extends AbstractFusionObject
{
    /**
     * @Flow\Inject
     * @var UriBuilder
     */
    protected $uriBuilder;

    /**
     * The module to link, submodule are added with a slash
     *
     * @return string|null
     */
    public function getModule(): ?string
    {
        return $this->fusionValue('module');
    }

    /**
     * Target controller action name
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
    public function getAdditionalParams(): ?array
    {
        return array_merge($this->fusionValue('additionalParams'), $this->fusionValue('arguments'));
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

        $currentModuleArgument = $mainRequest->getArgument('module');
        $currentModule = is_array($currentModuleArgument) ? $currentModuleArgument['module'] ?? '' : '';
        $module = $this->getModule() ?? $currentModule;

        $moduleArguments = ['module' => $module];
        $arguments = $this->getArguments();
        if ($arguments !== null && $arguments !== []) {
            $moduleArguments['moduleArguments'] = $arguments;
        }

        $moduleController = $this->getController();
        if ($moduleController !== null) {
            $moduleArguments['moduleArguments']['@controller'] = $moduleController;
        }

        $moduleAction = $this->getAction();
        if ($moduleAction !== null) {
            $moduleArguments['moduleArguments']['@action'] = $moduleAction;
        }

        $format = $this->getFormat();
        if ($format !== null) {
            $this->uriBuilder->setFormat($format);
        }

        $additionalParams = $this->getAdditionalParams();
        if ($additionalParams !== null && $additionalParams !== []) {
            $this->uriBuilder->setArguments($additionalParams);
        }

        $argumentsToBeExcludedFromQueryString = $this->getArgumentsToBeExcludedFromQueryString();
        if ($argumentsToBeExcludedFromQueryString !== null && $argumentsToBeExcludedFromQueryString !== []) {
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
                'index',
                $moduleArguments,
                'Backend\Module',
                'Neos.Neos'
            );
        } catch (\Exception $exception) {
            return $this->runtime->handleRenderingException($this->path, $exception);
        }
    }
}
