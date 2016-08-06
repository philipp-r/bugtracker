# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system. [Try the demo](https://demo.bugtrackr.eu/)

[![MIT License](https://img.shields.io/badge/license-MIT-blue.png)](https://docs.bugtrackr.eu/license/)
[![Open Issues](https://bb.bugtrackr.eu/index.php?page=api&project=bumpy-booby&XMODE=badge&api_username=Bumpy-Booby-GitHub-README&shields_label=open_issues)](https://bb.bugtrackr.eu/index.php?project=bumpy-booby&page=issues)
[![Closed Issues](https://bb.bugtrackr.eu/index.php?page=api&project=bumpy-booby&XMODE=badge&api_username=Bumpy-Booby-GitHub-README&open=closed&shields_label=closed_issues&shields_color=green)](https://bb.bugtrackr.eu/index.php?project=bumpy-booby&page=issues&open=closed)

[![Flattr this](https://img.shields.io/badge/_Flattr_this_--lightgrey.png?style=social)](https://flattr.com/submit/auto?fid=y7wn6e&url=https%3A%2F%2Fgithub.com%2Fbugtrackr%2Fbumpy-booby)

Version 1.1

## Install

Download the [latest release](https://github.com/bugtrackr/bumpy-booby/releases/latest) and upload to your webserver.

The folder `./database` has to be writable for apache: `chmod -R 777 database`.

[See our wiki](https://docs.bugtrackr.eu/wiki/install/) for details!

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
