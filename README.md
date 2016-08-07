# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system. 

**[The demo](https://demo.bugtrackr.eu/) is built using this branch.**

Version 1.0.2

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

Report bugs & feature requests in our [issue tracker](https://bb.bugtrackr.eu/index.php?project=bumpy-booby&page=issues).
