Readme
------
This module lets users delete comments on nodes they create without giving them full comment administration access. Permissions are on a per node type basis, so it's a great way to, e.g., allow users to administer comments on their own blogs.

Once the global approval permission is turned on, users with the appropriate role will have new options on their user edit page. By default, the approval queue is off (friendlier that way) and users must turn it on themselves.

Additionally, you can configure this module to force comments on selected node types to be approved before they get published. As with delete rights, this is administered by users so you don't have to do it yourself.

Send comments to Gwen Park at: http://drupal.org/user/99925.

Requirements
------------
This module requires Drupal 6.x and the comment module.

Installation
------------
1. Copy the usercomment directory and its contents to the Drupal modules directory, probably /sites/all/modules/.

2. Enable the User Comment module in the modules admin page /admin/build/modules.

3. Enable the appropriate permissions on the user access admin page /admin/user/permissions.

4. Update the default approval email on the usercomment admin page /admin/content/comments/usercomment.

The "delete" functionality appears as a comment link courtesy of hook_link().

Upgrading from a previous version
----------------------------------
1. Copy the usercomment directory and its contents to the Drupal modules directory, probably /sites/all/modules/.

2. Some of the user access option names may have changed, so please set them appropriately on the user permissions page.

Settings
--------
There are some user settings available on the user edit form.

Credits
-------
Written by Gwen Park.

TODO
----
1. Get rid of the hacks:
   * hard coded comment sql queries
