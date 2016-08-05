# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system.

I recommend to use the `master` branch. This one is used to deploy our custom [issue tracker](https://bb.bugtrackr.eu/).

Version 1.0.1

## Install

Installation on our server with webhook and "build-sites" by pushing to GitHub.com. **TO DO**

### .htaccess files

There are no .htaccess files in this branch. Add this to the apache config:
```
<Directory ~ "^/var/www/(classes|database|languages|pages)/">
	Allow from none
	Deny from all
</Directory>
<Directory "/var/www/classes/api/">
	Allow from none
	Deny from all
	# allow API key generator
	<FilesMatch "^keygen\.php$">
		Allow from all
	</FilesMatch>
	<FilesMatch "^keygen-travisci\.php$">
		Allow from all
	</FilesMatch>
</Directory>
<Directory "/var/www/classes/securimage/">
	<FilesMatch "^.*$">
		Allow from all
	</FilesMatch>
</Directory>
```

## Configuration

You can do all changes by opening `./index.php?page=settings` in your browser.

To configure the [API](https://docs.bugtrackr.eu/wiki/api/) change the settings manually in `./database/config_api.php`. There is a sample configuration file `./sample_config/config_api.php`.

You can also edit the Captcha which is displayed when a user who is not logged in wants to create a new issue. you can do this with `./database/config_captcha.php` file. There is a sample configuration file `./sample_config/config_captcha.php`.

[See our wiki](https://docs.bugtrackr.eu/wiki/config/) for details!

## API

The API has some features:

 * [Default API](https://docs.bugtrackr.eu/api/bumpybooby/) to create new issues, edit them, and more.
 * [Travis CI API](https://docs.bugtrackr.eu/api/travis-ci/) to create a new issue when a build with Travis CI fails.
 * [Badges](https://docs.bugtrackr.eu/api/badges/) that can be displayed in GitHub 'README.md' file.
 * [Import RSS Feeds](https://docs.bugtrackr.eu/api/rss/) to create new issues from RSS feeds.

[See our wiki](https://docs.bugtrackr.eu/api/) for details!

## Bugs & feature requests

Report bugs & feature requests in our [issue tracker](https://bb.bugtrackr.eu/index.php?project=bumpy-booby&page=issues).
