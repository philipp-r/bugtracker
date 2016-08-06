<?php

class Trad {

		# Words

	const W_ISSUE = 'Fall';
	const W_OPEN = 'Offen';
	const W_OPENED = 'Geöffnet';
	const W_CLOSED = 'Geschlossen';
	const W_REOPENED = 'Wiedereröffnet';
	const W_COMMENTED = 'Kommentiert';
	const W_NOBODY = 'niemand';
	const W_SOMEONE = 'jemand';
	const W_ENABLED = 'Aktiviert';
	const W_DISABLED = 'Deaktiviert';
	const W_NOTFOUND = 'Nicht gefunden';
	const W_FORBIDDEN = 'Verboten';
	const W_MENU = 'Menü';

	const W_EXAMPLE = 'Beispiel';
	const W_HEX = 'Hex';
	const W_RENDERING = 'Rendering';
	const W_ID = 'ID';
	const W_DISPLAY_NAME = 'Angezeigter Name';
	
	const W_SECONDE = 'Sekunde';
	const W_MINUTE = 'Minute';
	const W_HOUR = 'Stunde';
	const W_DAY = 'Tag';
	const W_WEEK = 'Woche';
	const W_MONTH = 'Monat';
	const W_YEAR = 'Jahr';
	const W_DECADE = 'Dekade';
	const W_SECONDE_P = 'Sekunden';
	const W_MINUTE_P = 'Minuten';
	const W_HOUR_P = 'Stunden';
	const W_DAY_P = 'Tage';
	const W_WEEK_P = 'Wochen';
	const W_MONTH_P = 'Monate';
	const W_YEAR_P = 'Jahre';
	const W_DECADE_P = 'Dekaden';

	const W_PREVIOUS = 'Vorherige';
	const W_NEXT = 'Nächste';
	const W_MORE = 'MEHR';
	const W_CURRENT = 'Seite %nb1% von %nb2%';

	const W_NOT_LOGGED = 'Nicht eingeloggt';

	const W_SUSPENSION = '…';
	const W_EXTRACT = '“%text%”';

	const W_USER = 'Benutzer';
	const W_DEVELOPPER = 'Entwickler';
	const W_SUPERUSER = 'Superuser';
	const W_S_NEW = 'Neu';
	const W_S_CONFIRMED = 'Bestätigt';
	const W_S_ASSIGNED = 'Zugewiesen an %user%';
	const W_S_RESOLVED = 'Erledigt';
	const W_S_REJECTED = 'Zurückgewiesen';
	const W_L_URGENT = 'Dringend';
	const W_L_IMPROVEMENT = 'Verbesserung';
	const W_L_PRIVATE = 'Privat';

	const W_PROFILEPIC = 'Profilbild';

	const W_RSS = 'RSS Feed';
	const W_VERSION = 'Version';

		# Verbes

	const V_UPDATE = 'Aktualisieren';
	const V_UPDATE_DETAILS = 'Details aktualisieren';
	const V_UPDATE_CONTENT = 'Inhalt aktualisieren';
	const V_UPDATE_AND = 'aktualisieren & %adjective%';
	const V_CANCEL = 'Abbrechen';
	const V_PREVIEW = 'Vorschau';
	const V_COMMENT = 'Kommentieren';
	const V_SUBMIT = 'Senden';
	const V_SELECT_FILE = 'Wähle eine Datei...';
	const V_UPLOADING = 'Hochladen...';
	const V_SAVE_CONFIG = 'Einstellungen speichern';
	const V_APPLY = 'Anwenden';
	const V_EDIT = 'Bearbeiten';
	const V_SIGNUP = 'Registrieren';
	const V_CONTINUE = 'Weiter';
	const V_REMOVE_ISSUE = 'Fall löschen';
	const V_CLOSE = 'schließen';
	const V_REOPEN = 'wiedereröffnen';
	const V_EXPORT = 'Daten exportieren';

		# Sentencies

	const S_NOLABEL = '-';
	const S_NODEPENDENCY = '-';
	const S_COMMENT_LEAVE = 'Schreibe einen Kommentar:';
	const S_AGO = 'vor %duration% %pediod%';
	const S_ISSUE_ABOUT = 'Über diesen Fall:';
	const S_UPLOAD_ADD = 'Hänge eine Datei an:';
	const S_WELCOME = 'Willkommen, %user%';
	const S_NEVER = 'Niemals';
	const S_ME = 'Über Aktualisierungen in Fällen zu denen ich beigetragen habe';
	const S_ALWAYS = 'Über alle Aktualisierungen';
	const S_START_NOTIF = 'Werde über Aktualisierungen benachrichtigt';
	const S_STOP_NOTIF = 'Werde nicht mehr benachrichtigt';
	const S_NOTFOUND = 'Die Seite nach der du suchst existiert nicht mehr...';
	const S_FORBIDDEN = 'Du darfst auf diese Seite nicht zugreifen. Bitte melde dich an.';

	const S_VIEW_PARTICIPATION = 'Siehe seine Aktivitäten';
	const S_VIEW_STATUS = 'Siehe Fälle “%status%”.';

	const S_ISSUE_CREATED = 'von %user% %time%';
	const S_ISSUE_UPDATED = '%adj% von %user% %time%.';
	const S_ISSUE_STATUS_UPDATED = 'Status aktualisiert zu %status% von %user% %time%.';

	const S_RSS_ISSUE_UPDATED = '%adj% von %user%.';
	const S_RSS_ISSUE_STATUS_UPDATED = 'Status aktualisiert zu “%status%” von %user%.';

	const S_INTRO_INSTALL = 'Bitte konfiguriere Bumpy Booby:';
	const S_FIRST_ISSUE_TITLE = 'Wie geht es dir?';
	const S_FIRST_ISSUE = 'Ich bin dein erster Fall! Nachdem du dich angemeldet hast, kannst du mich bearbeiten oder löschen.';

	const S_NO_USER = 'Keine Benutzer gefunden.';
	const S_NO_ISSUE = 'Keine Fälle gefunden.';
	const S_MATCHING_ISSUES = '%nb% passende Fälle';
	const S_NO_ACTIVITY = 'Keine aktuelle Aktivität.';
	const S_NO_UPLOAD = 'Keine hochgeladenen Dateien.';
	const S_SIZE_REMAINING = 'Es verbleiben %remain% von den erlaubten %total%.';
	const S_NO_PROJECT = 'Kein Projekt.';

	const S_SEARCH = '#12, @Benutzer, Wörter...';
	const S_COPYRIGHT = 'Betrieben mit %name%.';
	const S_UPGRADE = 'Get latest version from <a href="https://github.com/bugtrackr/bumpy-booby/releases/latest">GitHub</a> to <a href="https://docs.bugtrackr.eu/wiki/upgrade/">upgrade</a>.';

	const S_LAST_UPDATES = 'Kürzliche Aktualisierungen...';

	const S_STAY_LOGGEDIN = 'Angemeldet bleiben';

	const S_DEFAULT_DEFPROJ_DESC = 'Dies ist das standard Projekt, auf das jeder Zugriff hat.';
	const S_DEFAULT_2NDPROJ_DESC = 'Das könnte dein zweites Projekt sein. Hier dürfen nur angemeldete Nutzer lesen und schreiben.';

		# Alerts

	const A_ERROR_DIRECTORY = '<strong>Fehler:</strong> Konnte das Verzeichnis “%name%” nicht erstellen.';
	const A_ERROR_FILE = '<strong>Fehler:</strong> Konnte Datei “%name%” nicht lesen.';
	const A_ERROR_FILE_WRITE = '<strong>Fehler:</strong> Konnte nicht in Datei “%name%” schreiben.';
	const A_ERROR_FATAL = 'Entschuldigung, etwas ist schiefgelaufen. Bitte kontaktiere den Administrator, wenn das Problem weiterhin besteht.';
	const A_ERROR = '<strong>%title%:</strong><br /><br />%message%<br /><br />Datei “<strong>%file%</strong>” in Zeile <strong>%line%</strong>.';

	const A_SUCCESS_INSTALL = '<strong>Done:</strong> Bumpy Booby is now completely configured.';
	const A_ERROR_INSTALL = '<strong>Error:</strong> Bumpy Booby is already configured. Please remove the config file if you want to reset the configuration.';
	const A_MODIF_SAVED = 'Modifications were saved.';

	const A_ERROR_FORM = 'An error occured. Please send again the form.';
	const A_ERROR_TOKEN = 'Wrong token. Please send again the form.';
	const A_ERROR_EMPTY = 'You have to specify a username and a password.';
	const A_ERROR_SAME_USERNAME = 'This username is not available.';
	const A_SUCCESS_SIGNUP = '<strong>Done:</strong> You can now log in.';

	const A_CONFIRM_DELETE_COMMENT = 'Are you sure you want to delete this comment?';
	const A_SUCCESS_DELETE_COMMENT = 'The comment was deleted.';
	const A_CONFIRM_DELETE_ISSUE = 'Are you sure you want to delete this issue?';
	const A_SUCCESS_DELETE_ISSUE = 'The issue was deleted.';
	const A_CONFIRM_DELETE_UPLOAD = 'Are you sure you want to delete this file?';
	const A_CONFIRM_DELETE_PROJECT = 'Are you sure you want to delete this project? All the corresponding issues will be lost.';

	const A_LOGGED = 'You are now logged in.';
	const A_LOGGED_OUT = 'You are now logged out.';
	const A_ERROR_CONNEXION = '<strong>Error:</strong> Wrong username or password.';
	const A_ERROR_CONNEXION_WAIT = '<strong>Error:</strong> Wrong username or password. Please wait %duration% %period% before trying again.';
	const A_ERROR_LOGIN_WAIT = 'Please wait %duration% %period% before trying again. This a protection against malicious attacks.';

	const A_ERROR_UPLOAD = 'An error occured. Please try again.';
	const A_ERROR_UPLOAD_SIZE = 'File exceeds the maximum allowed size (%nb% max).';
	const A_ERROR_UPLOAD_FULL = 'You don\'t have enought disk space to upload this file : %nb% remaining.';

	const A_PLEASE_LOGIN_ISSUES = 'Please log in to see the issues.';
	const A_PLEASE_LOGIN_COMMENT = 'Please log in to post a comment. No account yet? Create one: it\'s free and really fast !';
	const A_PLEASE_LOGIN_ISSUE = 'Please log in to submit an issue. No account yet? Create one: it\'s free and really fast !';
	const A_SHOULD_LOGIN = 'If you have an account, please log in. If not, consider creating one: it\'s free and really fast !';

	const A_IE = 'Your browser is obsolete: <a href="http://www.browserchoice.eu">upgrade or change it</a>.';

		# Mails

	const M_NEW_COMMENT_O = '[%title% — %project% — Issue #%id%] New comment';
	const M_NEW_COMMENT = 'Hi, %username%!

The issue #%id% — “%summary%” has just been commented by %by%. You can read the new comment here:
	%url%.

If you don\'t want to receive further notifications on this issue, an option is available (after logging) via the link above.

-----
This is an automated email, please do not reply.
	';

	const M_NEW_ISSUE_O = '[%title% — %project%] New issue';
	const M_NEW_ISSUE = 'Hi, %username%!

The issue #%id% — “%summary%” has just been submited by %by%. You can read it here:
	%url%.

If you don\'t want to receive further notifications on this issue, an option is available (after logging) via the link above.

-----
This is an automated email, please do not reply.
	';

		# Titles

	const T_INSTALLATION = 'Installation';
	const T_SETTINGS = 'Settings';
	const T_GLOBAL_SETTINGS = 'Global settings';
	const T_APPEARANCE = 'Appearance';
	const T_ISSUES = 'Issues';
	const T_GROUPS = 'Groups';
	const T_USERS = 'Users';
	const T_BROWSE_ISSUES = 'Browse issues';
	const T_BROWSE_ALL_ISSUES = 'Browse all issues';
	const T_ALL_ISSUES_DESCRIPTION = 'This are all open issues for all projects';
	const T_NEW_ISSUE = 'New issue';
	const T_ALL_ISSUES = 'All issues';
	const T_PROJECTS = 'Projects';
	const T_DASHBOARD = 'Dashboard';
	const T_LAST_UPDATES = 'Last updates';
	const T_LAST_ACTIVITY = 'Last activity';
	const T_UPLOADS = 'Uploads';
	const T_SEARCH = 'Search';
	const T_LINK_CONTACT = 'Contact Us';
	const T_LINK_LEGALNOTICE = 'Legal Notice';
	const T_LINK_PRIVACYPOLICY = 'Privacy Policy';
	const T_API_SETTINGS = 'API';
	const T_API_ACCESS_SETTINGS = 'API access';
	const T_API_ACCESS_HELP = 'Configure API access in <em>/database/config_api.php</em> file. For more info see API.md file.';
	const T_INFO = 'Info';

		# FORMS

	const F_USERNAME = 'Username:';
	const F_PASSWORD = 'Password:';
	const F_USERNAME2 = 'Username';
	const F_PASSWORD2 = 'Password';
	const F_NAME = 'Name:';
	const F_URL = 'Url:';
	const F_URL_CDN = 'CDN Url:';
	const F_URL_REWRITING = 'Url rewriting:';
	const F_INTRO = 'Introduction:';
	const F_DESCRIPTION = 'Description:';
	const F_EMAIL = 'Email:';
	const F_LINK_CONTACT = 'Link to external contact page (can be left empty):';
	const F_LINK_LEGALNOTICE = 'Link to legal notice (can be left empty):';
	const F_LINK_PRIVACYPOLICY = 'Link to privacy policy (can be left empty):';
	const F_MAX_UPLOAD = 'Maximum size per upload:';
	const F_ALLOCATED_SPACE = 'Allocated space per user:';
	const F_GROUP = 'Group:';
	const F_NOTIFICATIONS = 'Be notified:';
	const F_PROJECT_X = 'Project “%name%”:';
	const F_LANGUAGE = 'Language:';
	const F_LOGS = 'Logs:';

	const F_ISSUES_PAGE = 'Issues per page:';
	const F_ISSUES_PAGE_SEARCH = 'Issues per page (search):';
	const F_PREVIEW_ISSUE = 'Previews length (issues):';
	const F_PREVIEW_SEARCH = 'Previews length (search):';
	const F_PREVIEW_PROJECT = 'Previews length (projects):';
	const F_LAST_EDITS = 'Number of issues displayed on dashboards:';
	const F_LAST_ACTIVITY = 'Number of issues displayed on user pages:';

	const F_ADD_PROJECT = 'New project';
	const F_ADD_COLOR = 'New color';
	const F_ADD_STATUS = 'New status';
	const F_ADD_LABEL = 'New label';
	const F_ADD_GROUP = 'New group';
	const F_ADD_USER = 'New user';

	const F_SORT_BY = 'Sort by:';
	const F_SORT_ID = 'ID';
	const F_SORT_MOD = 'last update';
	const F_SORT_DESC = 'descending';
	const F_SORT_ASC = 'ascending';
	const F_FILTER_STATUSES = 'Filter statuses:';
	const F_FILTER_STATES = 'Filter states:';
	const F_FILTER_LABELS = 'Filter labels:';
	const F_FILTER_USERS = 'Filter users:';

	const F_WRITE = 'Write:';
	const F_SUMMARY = 'Summary';
	const F_CONTENT = 'Content';

	const F_STATUS = 'Status:';
	const F_RELATED = 'Related:';
	const F_LABELS2 = 'Labels:';

	const F_GENERAL_SETTINGS = 'General settings:';
	const F_PROJECTS = 'Projects:';
	const F_DATABASE = 'Database:';
	const F_UPLOADS = 'Uploads:';
	const F_COLORS = 'Manage colors:';
	const F_DISPLAY = 'Manage display :';
	const F_STATUSES = 'Manage statuses:';
	const F_LABELS = 'Manage labels:';
	const F_GROUPS = 'Manage groups:';
	const F_PERMISSIONS = 'Manage permissions:';
	const F_USERS = 'Manage users:';
	
	const F_INVALID_CAPTCHA = 'The CAPTCHA you entered was wrong. Please try again.';

	const F_TIP_NAME = 'It will be displayed on the header of each page.';
	const F_TIP_URL_REWRITING = 'Leave this field empty to disable url rewriting. Otherwise, it should contain the path to Bumpy Booby folder (started and ended with a "/"), relative to the domain name.';
	const F_TIP_URL_CDN = 'Leave this field empty to disable CDN. Otherwise, it has to contain the URL of your CDN (for example <em>https://cdn.rawgit.com/bugtrackr/bumpy-booby/master/</em>, feel free to use this one). Make sure to host all files from <em>/public</em> folder on your CDN.';
	const F_TIP_INTRO = 'It will be displayed on the home page. It will be parsed with the Markdown syntax. Note: if there is only one project named “%name%”, the home page is automatically redirected to the project dashboard, and this text will not be displayed.';
	const F_TIP_EMAIL = 'Leave this field empty to disable email notifications. Otherwise, this address will be used as sender when sending an email notification.';
	const F_TIP_PASSWORD = 'Leave it empty if you don\'t want to change the password.';
	const F_TIP_USER_EMAIL = 'Required only if you want to receive notifications.';
	const F_TIP_NOTIFICATIONS = 'This a default setting: you will be able to change it for each issue.';
	const F_TIP_NOTIFICATIONS_DISABLED = 'Note: notifications are currently disabled by the administrator.';
	const F_TIP_DESCRIPTION = 'It will be displayed on the project dashboard. It will be parsed with the markdown syntax.';

	const F_TIP_MAX_UPLOAD = 'Each uploaded file can\'t exceed this size.';
	const F_TIP_ALLOCATED_SPACE = 'A user can\'t upload other files once he reached this limit.<br /><em>Attention:</em> if none logged users are allowed to upload files (this is not the default setting), this limit does not apply to them.';

	const F_TIP_ID_STATUS = '<b>Tip:</b> be careful when changing the IDs, because each issue keeps its old status ID (except if this ID does not exist anymore: in this case, the default status will be used).';
	const F_TIP_ID_LABEL = '<b>Tip:</b> be careful when changing the IDs, because each label of one issue keeps its old ID (except if this ID does not exist anymore: in this case, the label is removed from the issue).';
	const F_TIP_ID_GROUP = '<b>Tip:</b> be careful when changing the IDs, because each user keeps its old group ID (except if this ID does not exist anymore: in this case, the default group will be used).';

	const F_API_ENABLE = 'Enable the API';

	const HELP_MARKDOWN = '
		<h2>Markdown syntax:</h2>

		<p>Paragraphs:</p>
<pre><code class="blank no-highlight">Paragraphs are separated by one or more blank lines.
That\'s why this text will be displayed in the same line that the previous phrase, no matter the line break.

To start a new line without creating a new paragraph:  
insert 2 spaces before the line break, just like here.</code></pre>
		<p>Emphasis:</p>
<pre><code class="blank no-highlight">*Italic text*  
_Itatic text again_  

**Bold text**  
__Bold text again__  </code></pre>

		<p>Links:</p>
<pre><code class="blank no-highlight">This is [an example](http://example.com) of inline link.  
This is another one : &lt;http://example.com&gt;.</code></pre>

		<p>Images:</p>
<pre><code class="blank no-highlight">![I am an image.](http://example.com/image.png)</code></pre>

		<p>Headers:</p>
<pre><code class="blank no-highlight"># Top Level title
## Second level title
### Third level title
#### Fourth level title</code></pre>

		<p>Lists:</p>
<pre><code class="blank no-highlight">- one item
* another one

1. first item
2. second item</code></pre>

		<p>Blockquotes:</p>
<pre><code class="blank no-highlight">> I am a blockquote with two paragraphs.
>
> I am the second paragraph.</code></pre>

		<p>Code blocks:</p>
<pre><code class="blank no-highlight">This is an `inline code block`.</code></pre>
<pre><code class="blank no-highlight">    &lt;?php echo "I am a code block, because I am indented
    with 4 spaces"; ?&gt;</code></pre>
<pre><code class="blank no-highlight">```
&lt;?php echo "I am a code block."; ?&gt;
```

```php
&lt;?php echo "Supported languages are : bash, cs, ruby, diff, javascript, css, xml, http, java, php, python, sql, ini, perl, json, cpp, markdown, no-highlight"; ?&gt;
```</code></pre>
	';


	private static $permissions = array(
		'home' => array(
			'title' => 'Home:',
			'description' => 'Can access to the home page and view list of all open issues for his projects.'
		),
		'dashboard' => array(
			'title' => 'Dashboards:',
			'description' => 'Can access to the projects dashboards.'
		),
		'issues' =>  array(
			'title' => 'View issues:',
			'description' => 'Can view public issues.'
		),
		'private_issues' => array(
			'title' => 'View private issues:',
			'description' => 'Can view issues tagged as private.'
		),
		'search' => array(
			'title' => 'Search:',
			'description' => 'Can search issues or users.'
		),
		'new_issue' => array(
			'title' => 'New issue:',
			'description' => 'Can submit a new issue.'
		),
		'edit_issue' => array(
			'title' => 'Edit issues:',
			'description' => 'Can edit the text of all the issues and delete them.'
		),
		'update_issue' => array(
			'title' => 'Update issues:',
			'description' => 'Can update issues : change status, add labels, close and reopen, ...'
		),
		'post_comment' => array(
			'title' => 'Post a comment:',
			'description' => 'Can post a comment.'
		),
		'edit_comment' => array(
			'title' => 'Edit comments:',
			'description' => 'Can edit all the comments (users can edit their own comments anyway).'
		),
		'view_user' => array(
			'title' => 'User profiles:',
			'description' => 'Can view all the user profiles.'
		),
		'upload' => array(
			'title' => 'Post a file:',
			'description' => 'Can attach files to a comment or a new issue.'
		),
		'view_upload' => array(
			'title' => 'View uploads:',
			'description' => 'Can access to all the uploaded files.'
		),
		'settings' => array(
			'title' => 'Change settings:',
			'description' => 'Can access this page and modify all the global settings.'
		),
		'signup' => array(
			'title' => 'Sign up:',
			'description' => 'Can sign up.'
		),
		'view_errors' => array(
			'title' => 'View fatal errors:',
			'description' => 'Can view the description of fatal errors.'
		)
	);

	public static function permissions($id, $type = 'description') {
		return self::$permissions[$id][$type];
	}

	private static $settings = array(
		'validate_url' => 'The url is not valid.',
		'validate_email' => 'The email is not valid.',
		'private_label_removed' => 'You can\'t remove the private label or change its ID, but you can rename it.',
		'default_status_removed' => 'You can\'t remove the default status or change its ID, but you can rename it.',
		'default_group_removed' => 'You can\'t remove the default group or change its ID, but you can rename it.',
		'default_group_superuser_removed' => 'You can\'t remove the superuser group or change its ID, but you can rename it.',
		'validate_same_username' => 'Warning : two users have the same username.',
		'validate_same_project_name' => 'Two projects can\'t have the same name. One has been automatically renamed.',
		'language_modified' => 'Refresh this page to view it in the new language.'
	);

	public static function settings($id) {
		return self::$settings[$id];
	}

	private static $errors = array(
		E_ERROR => 'Fatal error',
		E_WARNING => 'Warning',
		E_PARSE => 'Parse error',
		E_NOTICE => 'Notice',
		E_STRICT => 'Advice',
		E_DEPRECATED => 'Deprecated',
		'default' => 'Error'
	);
	public static function errors($no) {
		return (isset(self::$errors[$no])) ? self::$errors[$no] : self::$errors['default'];
	}
}

?>