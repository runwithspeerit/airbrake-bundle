# SpeeritAirbrakeBundle

This is a fork of the original https://github.com/aminin/airbrake-bundle bundle big thanks to its developer/s

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b478929b-5ec1-4ff8-80f8-32d59ef5e759/small.png)](https://insight.sensiolabs.com/projects/b478929b-5ec1-4ff8-80f8-32d59ef5e759)
[![Build Status](https://travis-ci.org/runwithspeerit/airbrake-bundle.svg?branch=master)](https://travis-ci.org/runwithspeerit/airbrake-bundle)
[![Latest Stable Version](https://poser.pugx.org/speerit/airbrake-bundle/v/stable)](https://packagist.org/packages/speerit/airbrake-bundle)
[![Total Downloads](https://poser.pugx.org/speerit/airbrake-bundle/downloads)](https://packagist.org/packages/speerit/airbrake-bundle)
[![Latest Unstable Version](https://poser.pugx.org/speerit/airbrake-bundle/v/unstable)](https://packagist.org/packages/speerit/airbrake-bundle)
[![License](https://poser.pugx.org/speerit/airbrake-bundle/license)](https://packagist.org/packages/speerit/airbrake-bundle)
[![Monthly Downloads](https://poser.pugx.org/speerit/airbrake-bundle/d/monthly)](https://packagist.org/packages/speerit/airbrake-bundle)
[![Daily Downloads](https://poser.pugx.org/speerit/airbrake-bundle/d/daily)](https://packagist.org/packages/speerit/airbrake-bundle)

## Prerequisites

This version of the bundle requires Symfony 2.3+

## Installation

### Step 1: Download SpeeritAirbrakeBundle using composer

Add SpeeritAirbrakeBundle in your composer.json:

```shell
$ composer require speerit/airbrake-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Speerit\AirbrakeBundle\SpeeritAirbrakeBundle(),
    );
}
```

### Step 3: Configure the SpeeritAirbrakeBundle

Add the following configuration to your `config.yml` file

```yml
# app/config/config.yml
speerit_airbrake:
    project_id:  YOUR-PROJECT-ID
    project_key: YOUR-API-KEY
```

## Configuration reference

```yml
speerit_airbrake:
    # This parameter is required
    # For Errbit the exact value of project_id doesn't matter
    project_id: YOUR-PROJECT-ID

    # Omit this key if you need to enable/disable the bundle temporarily 
    # If not given, this bundle will ignore all exceptions and won't send any data to remote.
    project_key: YOUR-API-KEY

    # By default, it is set to api.airbrake.io.
    # A host is a web address containing a scheme ("http" or "https"), a host and a port.
    # You can omit the scheme ("https" will be assumed) and the port (80 or 443 will be assumed).
    host: http://errbit.localhost:8000

    # You might want to ignore some exceptions such as http not found, access denied etc.
    # By default this bundle ignores all HttpException instances. (includes HttpNotFoundException, AccessDeniedException)
    # To log all exceptions leave this array empty.
    ignored_exceptions: ["Symfony\Component\HttpKernel\Exception\HttpException"]
```

## Usage

Once configured, bundle will automatically send exceptions/errors to airbrake server.

## License

This bundle is under the MIT license. See the complete license in the [Resources/meta/LICENSE](Resources/meta/LICENSE)
