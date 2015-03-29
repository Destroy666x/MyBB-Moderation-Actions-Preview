<?php

/*
Name: Moderation Actions Preview
Author: Destroy666
Version: 1
Requirements: Plugin Library
Info: Plugin for MyBB forum software, coded for versions 1.8.x (may also work in 1.6.x/1.4.x after some changes).
It displays moderation actions sorted by date in postbit/profile (github-like).
6 new templates, 5 template edits, 5 new settings
Released under GNU GPL v3, 29 June 2007. Read the LICENSE.md file for more information.
Support: official MyBB forum - http://community.mybb.com/mods.php?action=profile&uid=58253 (don't PM me, post on forums)
Bug reports: my github - https://github.com/Destroy666x

© 2015 - date("Y")
*/

$l['moderation_actions_preview'] = 'Moderation Actions Preview';
$l['moderation_actions_preview_info'] = 'Displays moderation actions sorted by date in postbit/profile.';
$l['pluginlibrary_missing'] = '<strong>Note:</strong> Plugin Library is needed to create/delete new templates in this plugin. You can download it from <a href="https://github.com/frostschutz/MyBB-PluginLibrary/archive/master.zip">here</a>.';

$l['moderation_actions_preview_settings'] = 'Settings for the Moderation Actions Preview plugin.';
$l['moderation_actions_preview_ips'] = 'Display IPs?';
$l['moderation_actions_preview_ips_desc'] = 'Set to Yes to enable IP display. Only people with valid permissions will be able to see them.';
$l['moderation_actions_preview_avatars'] = 'Display Avatars?';
$l['moderation_actions_preview_avatars_desc'] = 'Set to Yes to enable avatar display.';
$l['moderation_actions_preview_avatars_posts_max'] = 'Maximal Avatar Dimensions in Posts';
$l['moderation_actions_preview_avatars_posts_max_desc'] = 'Enter maximal width and height of avatars in posts separated by the x character.';
$l['moderation_actions_preview_avatars_profile_max'] = 'Maximal Avatar Dimensions on Profiles';
$l['moderation_actions_preview_avatars_profile_max_desc'] = 'Enter maximal width and height of avatars on profiles separated by the x character.';
$l['moderation_actions_preview_profile_limit'] = 'Maximal Number of Displayed Moderation Actions on Profiles';
$l['moderation_actions_preview_profile_limit_desc'] = 'Enter a number representing the maximal displayed moderation actions on profiles. 0 for no limit.';
