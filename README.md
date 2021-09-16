# simplesamlphp-lambda-wrapper
AWS Lambda Wrapper for deploying SimpleSAMLphp as a Lambda function using Bref

!! Tested only with SimpleSAMLphp 1.19 !!

Usage:
* Clone this somewhere
* Use composer to fetch Bref
* Fetch simplesamlphp from the original source and unzip it in a new folder named simplesamlphp
* Configure simplesamlphp (config.php, authsources.php, metadata, cert, etc.)
* Don't forget to use composer to fetch predis if you use Redis as session store
* Adjust require('../<file') directives in a few files so it uses dirname(__FILE__).'/../<file>' instead
* Use `serverless deploy` to deploy to AWS
