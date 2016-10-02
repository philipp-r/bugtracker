# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system. [Try the demo](https://demo.bugtrackr.eu/)

[![GPL License](https://img.shields.io/badge/license-GPL-blue.svg?style=plastic)](https://docs.bugtrackr.eu/license/)
[![Flattr this](https://img.shields.io/badge/_Flattr_this_--lightgrey.svg?style=social)](https://flattr.com/submit/auto?fid=y7wn6e&url=https%3A%2F%2Fgithub.com%2Fbugtrackr%2Fbumpy-booby)

Version 1.1

## Install

Download the [latest release](https://github.com/bugtrackr/bumpy-booby/releases/latest) and upload to your webserver.

The folder `./database` has to be writable for apache: `chmod -R 777 database`.

[See our wiki](https://docs.bugtrackr.eu/wiki/install/) for details!

## Configuration

You can do all changes by opening `./index.php?page=settings` in your browser. [See our wiki](https://docs.bugtrackr.eu/wiki/config/) for details!

To configure the [API](https://docs.bugtrackr.eu/api/) change the settings manually in `./database/config_api.php`. 
There is a sample configuration file `./sample_config/config_api.php`.

You can also edit the [Captcha](https://docs.bugtrackr.eu/wiki/captcha/) which is displayed when a user who is not logged in wants to create a new issue. 
You can do this with `./database/config_captcha.php` file. There is a sample configuration file `./sample_config/config_captcha.php`.

## API

The [API](https://docs.bugtrackr.eu/api/) has these features:

 * [Default API](https://docs.bugtrackr.eu/api/bumpybooby/) to create new issues, edit them, and more.
 * [Travis CI API](https://docs.bugtrackr.eu/api/travis-ci/) to create a new issue when a build with Travis CI fails.
 * [Badges](https://docs.bugtrackr.eu/api/badges/) that can be displayed in GitHub 'README.md' file.
 * [Import RSS Feeds](https://docs.bugtrackr.eu/api/rss/) to create new issues from RSS feeds.

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
