# Bumpy Booby

Bumpy Booby is a simple, responsive and highly customizable PHP bug tracking system. 

**[The demo](https://demo.bugtrackr.eu/) is built using this branch.**

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

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
