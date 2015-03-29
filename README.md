**Moderation Actions Preview**
===============

![Moderation Actions Preview](https://raw.github.com/Destroy666x/MyBB-Moderation-Actions-Preview/master/preview1.png "Preview")

**Name**: Moderation Actions Preview  
**Author**: Destroy666  
**Version**: 1.0  

**Info**:
---------

Plugin for MyBB forum software, coded for versions 1.8.x (may also work in 1.6.x/1.4.x after some changes).  
It displays moderation actions sorted by date in postbit/profile (github-like).  
6 new templates, 5 template edits, 5 new settings  
Released under GNU GPL v3, 29 June 2007. Read the LICENSE.md file for more information.  

**Support/bug reports**: 
------------------------

**Support**: official MyBB forum - http://community.mybb.com/mods.php?action=profile&uid=58253 (don't PM me, post on forums)  
**Bug reports**: my github - https://github.com/Destroy666x  

**Note 1**: this plugin entirely depends on MyBB logs displayed in MyBB, so many of them may be missing (for example forumdisplay.php inline thread moderation actions). They won't be displayed as long as MyBB doesn't correct that. So reports about them will be ignored in places connected with the plugin, feel free to post them here though: http://community.mybb.com/forum-157.html  
**Note 2**: avatar maximal dimensions settings won't work until this MyBB bug gets fixed: http://community.mybb.com/thread-164490.html Reports for it also will be ignored.  
**Note 3**: moderation actions are displayed for users in groups with Moderator CP -> **Can view moderator logs?** option ticked. You can enable it together with the **Yes, users of this group can access the moderator CP** option disabled if you don't want users to be able to access logs in Mod CP.  

**Changelog**:
--------------

**1.0** - initial release  

**Requirements**:
-----------------

Plugin Library is required for template installation.  
You can download it here: https://github.com/frostschutz/MyBB-PluginLibrary/archive/master.zip  
Installation guide: https://github.com/frostschutz/MyBB-PluginLibrary/blob/master/README.txt  
After uploading it ignore the compatibility warning.  

**Installation**:
-----------------

1. Get Plugin Library (check Requirements section for more info).
2. Upload everything from upload folder to your forum root (where index.php, forumdisplay.php etc. are located).
3. Install and activate plugin in ACP -> Configuration -> Plugins.
4. Configure it.

**Templates troubleshooting**:
------------------------------

* Postbit - add **{$post['moderation_actions_bef']}** at the beginning and **{$post['moderation_actions_aft']}** and the end of postbit and postbit_classic templates
* Profile - add **{$moderation_actions}** to any profile template (member_profile by default)

**Translations**:
-----------------

Feel free to submit translations to github in Pull Requests. Also, if you want them to be included on the MyBB mods site, ask me to provide you the contributor status for my project.

**Donations**:
-------------

Donations will motivate me to work on further MyBB plugins. Feel free to use the button in the ACP Plugins section anytime.  
Thanks in advance for any input.