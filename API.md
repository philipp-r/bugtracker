# Bumpy Booby API

API can be tested with Mac App Paw and *api.paw* file.

## Enable the API

To enable the Bumpy Booby API log in and go to *Settings -> API* and choose *Enabled*.

Then create a new group named `bbapi` if it not exists yet.
Give the group "bbapi" permission for every project you want to use with API and for *New issue*.





## Default API

The API has different modes. This is the default mode. To use `travisci` mode for Travis CI webhooks or `github` mode see below. 

### Request

Send a HTTP POST request with content type `application/x-www-form-urlencoded`. To this URL:

```
https://example.com/index.php?project=PROJECTNAME&page=api
```

Replace `PROJECTNAME` with the project you want to use. This is required even if you only have the default project.

### Authentication

Create a new user with password and add him to group "bbapi". This user can now use the API but he cannot login.

Pass `api_username` with the user you created in "bbapi" group and `api_password` parameter with the user's password as HTTP POST data.

### POST parameters

The following parameters can be passed to the API with the HTTP POST request:

 * `action` (required): Set this to `new_issue` to create a new issue. Other values are not supported yet.
 * `issue_summary` (required): Set the title/summary of the issue.
 * `issue_text` (required): Issue content.
 * `issue_status`: Status of the issue. Default is the `default` status.
 * `issue_assignedto`
 * `issue_dependencies`: List of related issues. Format example `#1, #3, #8`.
 * `issue_labels`: List of labels. Format example `urgent, private`.

### Response

The API returns a JSON formatted response.

 * `status`: Value is 1 for success and 0 if an error occurred.
 * `statusDetails`: A description of the error or a success message.
 * `ID`: The ID of the newly created issue. This is only returned if the request was successful.

Example of an successful request response:

```
{
  "status":1,
  "statusDetails":"Bumpy Booby returned: 1",
  "ID":25
}
```




## Travis CI API

The API has different modes: `travisci` is to use Travis CI webhooks (docs: <https://docs.travis-ci.com/user/notifications/#Webhook-notification>). 
You can choose this mode by setting the the GET parameter `XMODE` of your request to `travisci`. This parameter is not required if you use the default mode (see above).

### Request

Add the URL to your `.travis.yml` file for a webhook:

```
notifications:
  webhooks:
    urls:
      - https://example.com/index.php?project=PROJECTNAME&page=api&XMODE=travisci
    on_success: [always|never|change] # default: always
    on_failure: [always|never|change] # default: always
    on_start: [always|never|change] # default: never
```

Webhooks are delivered with a `application/x-www-form-urlencoded` content type using HTTP POST, with the body including a `payload` parameter that contains the JSON webhook payload in a URL-encoded format.
Example payload: <https://gist.github.com/roidrage/9272064#file-gistfile1-json>

See also <https://docs.travis-ci.com/user/notifications/#Webhook-notification>

### Authentication

When Travis CI makes the POST request, a header named `Authorization` is included. Its value is the SHA2 hash of the GitHub username (see below), the name of the repository, and your Travis CI token.

```
sha256('USERNAME/REPOSITORYTRAVIS_TOKEN')
```

Create a new user with the name `travis-REPOSITORY` where you replace *REPOSITORY* with the name of your GitHub repository. 
The user has to use the *Authorization* header as password (the sha256 hash above).
Add this user to the group "bbapi".

### Response

Same response as for default API (see above).




## GitHub API

The API has different modes: `github` is to use GitHub webhooks.
You can choose this mode by setting the the GET parameter `XMODE` of your request to `github`. This parameter is not required if you use the default mode (see above).

### Request

Use this URL for your webhook:

```
http://example.com/index.php?project=PROJECTNAME&page=api&XMODE=github&githubpassword=ABC
```

Webhooks are delivered with a `application/json` content type using HTTP POST. The body is the JSON `payload` that depends on the event.
All payloads: <https://developer.github.com/v3/activity/events/types/>

HTTP requests made to your webhook's configured URL endpoint will contain several special headers:

 * `X-GitHub-Event`: Name of the event that triggered this delivery.
 * `X-Hub-Signature`: HMAC hex digest of the payload, using the hook's secret as the key (if configured).
 * `X-GitHub-Delivery`: Unique ID for this delivery.


### Authentication

GitHub webhook sends a header called `X-Hub-Signature` which is generated with:

```
hash_hmac( 'sha1', JSON-PAYLOAD, WEBHOOK-SECRET );
```

Create a new user with the name `github-REPOSITORY` where you replace *REPOSITORY* with the name of your GitHub repository. 
The user has to use the *secret* of the webhook as **email address** (just a dirty workaround until I have a better solution, but your secret has to contain an @-sign to pass the validation in *classes/Settings.class.php*). Choose a password for the user which will be passed as GET parameter `githubpassword`.
Add this user to the group "bbapi".

### Response

Same response as for default API (see above).
