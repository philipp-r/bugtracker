# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system.

[![Flattr this](https://button.flattr.com/flattr-badge-large.png)](https://flattr.com/submit/auto?fid=y7wn6e&url=https%3A%2F%2Fgithub.com%2FSpamty%2FBumpy-Booby)
[![MIT License](https://img.shields.io/badge/license-MIT-blue.png)](https://github.com/Spamty/Bumpy-Booby/blob/master/LICENSE.md)



## Running

### Installation

Copy all files, run `./` or `./index.php`, configure Bumpy Booby and enjoy!

You can delete all files that are listed in `./DELETE_LIST.txt`, they are useless.

The folder `./database` has to be writable for apache: `chmod -R 777 database`.

**Installation on Spamty server with webhook and "build-sites" by pushing to GitHub.com.**

### Configuration

You can do all changes by opening `./index.php?page=settings` in your browser. The configuration is stored in `./database/config.php`.

To configure the API you have to enable it on the settings page and then change the access settings manually in `./database/config_api.php`. There is a sample configuration file `./sample_config/config_api.php`. Have a look at `API.md` file for further information.

You can also edit the Captcha which is displayed when a user who is not logged in wants to create a new issue. you can do this with `./database/config_captcha.php` file. There is a sample configuration file `./sample_config/config_captcha.php`. Refer to this website for more information about changing the captcha: <https://www.phpcaptcha.org/documentation/customizing-securimage/>.

### Backup

Before any update, it's highly recommended to make a backup. You only need to save folder `./database/`.

### Requirements

Bumpy Booby doesn't support IE 6 & 7. It requires JavaScript to work properly.

## Bugs reports

Report bugs & feature requests for the original software here: <http://bumpy-booby.derivoile.fr>.

Report issues with this fork here: <https://bugs.spamty.eu/index.php?project=Bumpy-Booby&page=issues>. 
Or send us an email: <https://3q3.de/spamty>

## About Booby Bumpy

Bumpy Booby was created by Pierre Monchalin. 
This is a fork from <https://github.com/piero-la-lune/Bumpy-Booby>. Edited by Spamty <https://spamty.eu/>.

Bumpy Booby is distributed under the MIT License. See `./LICENSE.md` for more information.

We are using Securimage <http://www.phpcaptcha.org/>,<https://github.com/dapphp/securimage> by Drew Phillips for spam protection.
