# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system. 

**[The demo](https://bumpybooby.herokuapp.com/) is built using this branch.**

Version 1.1

## Install

Auto deploy on Heroku.

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

## GNU GPL License

Copyright (C) 2016 for the software by 
[bugtrackr team](https://github.com/bugtrackr) & 
[contributors](https://github.com/bugtrackr/bumpy-booby/graphs/contributors)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.