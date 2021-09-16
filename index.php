<?php

// SimpleSAMLphp Wrapper for running in a Lambda function with Bref
// VERY QUICKLY Tested with SimpleSAMLphp 1.19
// Needs more testing for production use, however it is very promising! :)

$requestContext = json_decode($_SERVER['LAMBDA_REQUEST_CONTEXT'], true);
$rootInclude = $requestContext['http']['path'];

// Set this to an environment variable that contains your CloudFront domain, e.g. abc.cloudfront.net or your custom domain
$fqdn = 'abc.cloudfront.net';

// Because we are behind CloudFront
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = '443';
$_SERVER['SERVER_NAME'] = $fqdn;
$_SERVER['HTTP_HOST'] = $fqdn;
$_ENV['SERVER_NAME'] = $_SERVER['SERVER_NAME'];
$_ENV['HTTP_HOST'] = $_SERVER['HTTP_HOST'];

if (strpos($rootInclude, '/module.php/', 0) !== false) {
    // Fix pathinfo for modules
    $_SERVER['PATH_INFO'] = str_replace('/module.php/','/',$_SERVER['PATH_INFO']);
    include 'simplesamlphp/www/module.php';
} else {
    switch ($rootInclude) {
        case '/admin/hostnames.php':
            include 'simplesamlphp/www/admin/hostnames.php';
            break;
        case '/admin/metadata-converter.php':
            include 'simplesamlphp/www/admin/metadata-converter.php';
            break;
        case '/admin/phpinfo.php':
            include 'simplesamlphp/www/admin/phpinfo.php';
            break;
        case '/admin/msandbox.php':
            include 'simplesamlphp/www/admin/sandbox.php';
            break;
        case '/shib13/idp/metadata.php':
            include 'simplesamlphp/www/shib13/idp/metadata.php';
            break;
        case '/shib13/idp/SSOService.php':
            include 'simplesamlphp/www/shib13/idp/SSOService.php';
            break;
        case '/saml2/idp/ArtifactResolutionService.php':
            include 'simplesamlphp/www/saml2/idp/ArtifactResolutionService.php';
            break;
        case '/saml2/idp/initSLO.php':
            include 'simplesamlphp/www/saml2/idp/initSLO.php';
            break;
        case '/saml2/idp/metadata.php':
            // Somehow does not work... For now, we change the includes properly
            //set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__).'/simplesamlphp/www');
            //set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__).'/simplesamlphp/www/saml2/idp');
            include 'simplesamlphp/www/saml2/idp/metadata.php';
            break;
        case '/saml2/idp/SingleLogoutService.php':
            include 'simplesamlphp/www/saml2/idp/SingleLogoutService.php';
            break;
        case '/saml2/idp/SSOService.php':
            include 'simplesamlphp/www/saml2/idp/SSOService.php';
            break;
        case '/logout.php':
            include 'simplesamlphp/www/logout.php';
            break;
        case '/errorreport.php':
            include 'simplesamlphp/www/errorreport.php';
            break;
        default:
            include 'simplesamlphp/www/index.php';
            break;
    }
}
