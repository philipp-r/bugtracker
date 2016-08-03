# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system. [Try the demo](http://bumpybooby.oss.spamty.eu/)

[![MIT License](https://img.shields.io/badge/license-MIT-blue.png)](https://github.com/Spamty/Bumpy-Booby/blob/master/LICENSE.md)
[![Open Issues](http://bugs.spamty.eu/index.php?page=api&project=bumpy-booby&XMODE=badge&api_username=Bumpy-Booby-GitHub-README&shields_label=open_issues)](https://bugs.spamty.eu/index.php?project=bumpy-booby&page=issues)
[![Closed Issues](http://bugs.spamty.eu/index.php?page=api&project=bumpy-booby&XMODE=badge&api_username=Bumpy-Booby-GitHub-README&open=closed&shields_label=closed_issues&shields_color=green)](https://bugs.spamty.eu/index.php?project=bumpy-booby&page=issues&open=closed)

[![Flattr this](https://img.shields.io/badge/_Flattr_this_--lightgrey.png?style=social)](https://flattr.com/submit/auto?fid=y7wn6e&url=https%3A%2F%2Fgithub.com%2FSpamty%2FBumpy-Booby)
[![Twitter](https://img.shields.io/twitter/follow/Spamty.svg?style=social&label=Follow&maxAge=2592000)](https://twitter.com/spamty)

## Install

Download the [latest release](https://github.com/Spamty/Bumpy-Booby/releases/latest) and upload to your webserver.

The folder `./database` has to be writable for apache: `chmod -R 777 database`.

[See our wiki](https://github.com/Spamty/Bumpy-Booby/wiki/Install) for details!

## Configuration

You can do all changes by opening `./index.php?page=settings` in your browser.

To configure the [API](https://github.com/Spamty/Bumpy-Booby/wiki/API) change the settings manually in `./database/config_api.php`. There is a sample configuration file `./sample_config/config_api.php`.

You can also edit the Captcha which is displayed when a user who is not logged in wants to create a new issue. you can do this with `./database/config_captcha.php` file. There is a sample configuration file `./sample_config/config_captcha.php`.

[See our wiki](https://github.com/Spamty/Bumpy-Booby/wiki/Configuration) for details!

## API

The API has some features:

 * [Default API](https://github.com/Spamty/Bumpy-Booby/wiki/Bumpy-Booby-API) to create new issues, edit them, and more.
 * [Travis CI API](https://github.com/Spamty/Bumpy-Booby/wiki/Travis-CI-API) to create a new issue when a build with Travis CI fails.
 * [Badges](https://github.com/Spamty/Bumpy-Booby/wiki/Badges) that can be displayed in GitHub 'README.md' file.
 * [Import RSS Feeds](https://github.com/Spamty/Bumpy-Booby/wiki/Import-RSS) to create new issues from RSS feeds.

[See our wiki](https://github.com/Spamty/Bumpy-Booby/wiki/API) for details!

## Bugs & feature requests

Report bugs & feature requests in our [issue tracker](https://bugs.spamty.eu/index.php?project=bumpy-booby&page=issues)
or [send us an email](https://3q3.de/spamty).
