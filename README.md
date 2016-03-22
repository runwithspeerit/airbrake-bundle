# AmiAirbrakeBundle

[![Build Status](https://api.travis-ci.org/aminin/airbrake-bundle.svg)](https://travis-ci.org/aminin/airbrake-bundle)
[![Coding Style](https://img.shields.io/badge/phpcs-PSR--2-brightgreen.svg)](http://www.php-fig.org/psr/psr-2/)

[Airbrake.io](https://airbrake.io) & [Errbit](https://github.com/errbit/errbit) integration for Symfony2.

## Prerequisites

This version of the bundle requires Symfony 2.3+

## Installation

### Step 1: Download AmiAirbrakeBundle using composer

Add AmiAirbrakeBundle in your composer.json:

```shell
$ composer require aminin/airbrake-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ami\AirbrakeBundle\AmiAirbrakeBundle(),
    );
}
```

### Step 3: Configure the AmiAirbrakeBundle

Add the following configuration to your `config.yml` file

```
# app/config/config.yml
ami_airbrake:
    project_id:  YOUR-PROJECT-ID
    project_key: YOUR-API-KEY
```

## Configuration reference

```
ami_airbrake:
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

This bundle is under the MIT license. See the complete license in the bundle:

```
Resources/meta/LICENSE
```
