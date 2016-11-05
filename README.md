# Bumpy Booby

I recommend to use the `master` branch. 
This one was used to deploy our custom issue tracker - but we are now using [GitHub issues](https://github.com/bugtrackr/bumpy-booby/issues).

Version 1.1

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

## Bugs & feature requests

See GitHub issues.
