# Sitegeist.FusionLinkPrototypes
## Missing Prototypes for easier linking to actions and modules.

By default the linking between backend modules or from backend modules has been cumbersome. 
Since modules use a subrequest the Neos UriBuilder created all links inside the module.

This package adds the prototypes `Sitegeist.FusionLinkPrototypes:ActionUri`, `Sitegeist.FusionLinkPrototypes:ActionLink` 
and `Sitegeist.FusionLinkPrototypes:ModuleUri`, `Sitegeist.FusionLinkPrototypes:ModuleLink` that always use the current 
main request to avoid this confusion.

!!! Those prototypes likely will end up in Neos eventually. The package here provides a replacement for older versions 
of Neos plus allows to play with the api and behavior before creating a core-pr !!!

### Authors & Sponsors

* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

## Installation

Sitegeist.FusionLinkPrototypes is available via packagist run `composer require sitegeist/fusionlinkprototypes`.
We use semantic versioning so every breaking change will increase the major-version number.

## Usage 

### `Sitegeist.FusionLinkPrototypes:ActionUri`

Built a URI to a controller action

- `package` (string) The package key (e.g. `My.Package`)
- `subpackage` (string) The subpackage, empty by default
- `controller` (string) The controller name (e.g. `Registration`)
- `action` (string) The action name (e.g. `new`)
- `arguments` (array) Arguments to the action by named key
- `format` (string) An optional request format (e.g. `html`)
- `section` (string) An optional fragment (hash) for the URI
- `additionalParams` (array) Additional URI query parameters by named key
- `addQueryString` (boolean) Whether to keep the query parameters of the current URI
- `argumentsToBeExcludedFromQueryString` (array) Query parameters to exclude for ``addQueryString``
- `absolute` (boolean) Whether to create an absolute URI

Example::

	uri = Sitegeist.FusionLinkPrototypes:ActionUri {
		package = 'My.Package'
		controller = 'Registration'
		action = 'new'
	}

### `Sitegeist.FusionLinkPrototypes:ActionLink`

Extends `Neos.Fusion:Tag` and adds an `attributes.href` defined as `Sitegeist.FusionLinkPrototypes:ActionUr`

Tag properties:
- `tagName` (string) Tag name of the HTML element, defaults to `a`
- `content` (string) The inner content of the element, will only be rendered if the tag is not self-closing and the closing tag is not omitted
- `attributes` (iterable) Tag attributes as key-value pairs. Default is `Neos.Fusion:DataStructure`. If a non iterable is returned the value is casted to string.
- `attributes.href` defined as `Sitegeist.FusionLinkPrototypes:ActionLink` 
- ... for more see the documentation of  `Neos.Fusion:Tag`
ActionUri properties:
- `package` (string) The package key (e.g. `My.Package`)
- `subpackage` (string) The subpackage, empty by default
- `controller` (string) The controller name (e.g. `Registration`)
- `action` (string) The action name (e.g. `new`)
- `arguments` (array) Arguments to the action by named key
- `format` (string) An optional request format (e.g. `html`)
- `section` (string) An optional fragment (hash) for the URI
- `additionalParams` (array) Additional URI query parameters by named key
- `addQueryString` (boolean) Whether to keep the query parameters of the current URI
- `argumentsToBeExcludedFromQueryString` (array) Query parameters to exclude for ``addQueryString``
- `absolute` (boolean) Whether to create an absolute URI

Example::

	link = Sitegeist.FusionLinkPrototypes:ActionLink {
        content = "Register new user"
		package = 'My.Package'
		controller = 'Registration'
		action = 'new'
	}

### `Sitegeist.FusionLinkPrototypes:ModuleUri`

Built a URI to a backend module. This allows to link between backend modules 

- `module` (string) The module path (e.g. `content` or `management/sites`)
- `controller` (string) The controller name (e.g. `Registration`)
- `action` (string) The action name (e.g. `new`)
- `arguments` (array) Arguments to the action by named key
- `format` (string) An optional request format (e.g. `html`)
- `section` (string) An optional fragment (hash) for the URI
- `additionalParams` (array) Additional URI query parameters by named key
- `addQueryString` (boolean) Whether to keep the query parameters of the current URI
- `argumentsToBeExcludedFromQueryString` (array) Query parameters to exclude for ``addQueryString``
- `absolute` (boolean) Whether to create an absolute URI

Example::

	uri = Sitegeist.FusionLinkPrototypes:ModuleUri {
		module = 'content'
		action = 'index'
		arguments = ${{node: node}}
	}

### `Sitegeist.FusionLinkPrototypes:ModuleLink`

Extends `Neos.Fusion:Tag` and adds an `attributes.href` defined as `Sitegeist.FusionLinkPrototypes:ModuleUri`

Tag properties:
- `tagName` (string) Tag name of the HTML element, defaults to `a`
- `content` (string) The inner content of the element, will only be rendered if the tag is not self-closing and the closing tag is not omitted
- `attributes` (iterable) Tag attributes as key-value pairs. Default is `Neos.Fusion:DataStructure`. If a non iterable is returned the value is casted to string.
- `attributes.href` defined as `Sitegeist.FusionLinkPrototypes:ActionLink`
- ... for more see the documentation of  `Neos.Fusion:Tag`
ModuleUri properties:
- `module` (string) The module path (e.g. `content` or `management/sites`)
- `controller` (string) The controller name (e.g. `Registration`)
- `action` (string) The action name (e.g. `new`)
- `arguments` (array) Arguments to the action by named key
- `format` (string) An optional request format (e.g. `html`)
- `section` (string) An optional fragment (hash) for the URI
- `additionalParams` (array) Additional URI query parameters by named key
- `addQueryString` (boolean) Whether to keep the query parameters of the current URI
- `argumentsToBeExcludedFromQueryString` (array) Query parameters to exclude for ``addQueryString``
- `absolute` (boolean) Whether to create an absolute URI

Example::

	link = Sitegeist.FusionLinkPrototypes:ModuleLink {
		content = "To the content module"
		module = 'content'
		action = 'index'
		arguments = ${{node: node}}
	}


## Contribution

We will gladly accept contributions. Please send us pull requests.
