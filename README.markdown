# Introduction

This is a simple little PHP5 class that enables you use the Akismet anti-spam service in your PHP5 application.

# Download

Check out the git repository:

	git clone git@github.com:achingbrain/php5-akismet.git

# Installation

Once you have cloned the repo (see Download, above) copy the file at src/main/php/net/achingbrain/Akismet.class.php to somewhere accessible to your scripts. Use include or a derivative to import it into your script.

Alternatively if you are running a version of PHP greater than 5.3, grab the [phar file](http://achingbrain.github.com/maven-repo/releases/net/achingbrain/php5-akismet/0.5/php5-akismet-0.5.phar) and use the following code:

	<?php
		include 'phar:///path/to/php5-akismet-0.5.phar/net/achingbrain/Akismet.class.php';
	?>

# Documentation

See the [PHPDocs](http://achingbrain.github.com/maven-repo/documentation/php5-akismet/apidocs).

# Usage

Before you can use Akismet, you need a WordPress API key (they are free and getting one takes about five minutes). Once you have one, take a look at the code below:

	$WordPressAPIKey = 'aoeu1aoue';
	$MyBlogURL = 'http://www.example.com/blog/';
	
	$akismet = new Akismet($MyBlogURL ,$WordPressAPIKey);
	$akismet->setCommentAuthor($name);
	$akismet->setCommentAuthorEmail($email);
	$akismet->setCommentAuthorURL($url);
	$akismet->setCommentContent($comment);
	$akismet->setPermalink('http://www.example.com/blog/alex/someurl/');
	
	if($akismet->isCommentSpam())
	  // store the comment but mark it as spam (in case of a mis-diagnosis)
	else
	  // store the comment normally

That's just about it. In the event that the filter wrongly tags messages, you can at a later date create a new object and populate it from your database, overriding fields where necessary and then use the following two methods to train it:

	$akismet->submitSpam();

and

	$akismet->submitHam();

to submit mis-diagnosed spam and ham, which improves the system for everybody. See the included documentation for a complete run-down of all available methods.

## Changelog

### Version 0.5

* Deployed to GitHub instead of achingbrain.net for better collaboration in future
* Converted project to use Maven for unit testing and documentation generation
* Unit tests & documentaiton
* Allowed overriding of user agent when submitting ham/spam (thanks Steven)

### Version 0.4

* Performance – changed HTTP version from 1.1 to 1.0 (with thanks to Jan De Poorter).
* Performance – No longer issues a separate HTTP request to check validity of the API key with every instantiation.
* Added a new public method 'isKeyValid' to manually check validity of the API key passed to the constructor.
* The method 'isCommentSpam' (rather than the constructor) will now throw an exception if the API key is invalid.
* Tidied up internal structure a bit.

### Version 0.3

Internal testing version

### Version 0.2

Initial release

### Version 0.1

Internal testing version