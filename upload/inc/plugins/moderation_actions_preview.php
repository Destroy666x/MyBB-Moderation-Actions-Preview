<?php

/*
Name: Moderation Actions Preview
Author: Destroy666
Version: 1.1
Requirements: Plugin Library
Info: Plugin for MyBB forum software, coded for versions 1.8.x (may also work in 1.6.x/1.4.x after some changes).
It displays moderation actions sorted by date in posts/announcements/profiles (github-like).
7 new templates, 6 template edits, 6 new settings
Released under GNU GPL v3, 29 June 2007. Read the LICENSE.md file for more information.
Support: official MyBB forum - http://community.mybb.com/mods.php?action=profile&uid=58253 (don't PM me, post on forums)
Bug reports: my github - https://github.com/Destroy666x

© 2015 - date("Y")
*/

if(!defined('IN_MYBB'))
{
	die('What are you doing?!');
}

// PluginLibrary for new templates
if(!defined('PLUGINLIBRARY'))
{
    define('PLUGINLIBRARY', MYBB_ROOT.'inc/plugins/pluginlibrary.php');
}

function moderation_actions_preview_info()
{
    global $db, $lang;
	
	$lang->load('moderation_actions_preview_acp');
	
	// Plugin Library notice
	$moderation_actions_preview_pl = !file_exists(PLUGINLIBRARY) ? $lang->pluginlibrary_missing.'<br />' : '';
	
	// Configuration link
	$moderation_actions_preview_cfg = '<br />';
	$gid = $db->fetch_field($db->simple_select('settinggroups', 'gid', "name='moderation_actions_preview'"), 'gid');
	
	if($gid)
		$moderation_actions_preview_cfg = '<a href="index.php?module=config&amp;action=change&amp;gid='.$gid.'">'.$lang->configuration.'</a>
<br />
<br />';
	
	return array(
		'name'			=> $lang->moderation_actions_preview,
		'description'	=> $lang->moderation_actions_preview_info.'<br />
'.$moderation_actions_preview_pl.$moderation_actions_preview_cfg.'
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ZRC6HPQ46HPVN">
<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" style="border: 0;" name="submit" alt="Donate">
<img alt="" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" style="border: 0; width: 1px; height: 1px;">
</form>',
		'website'		=> 'https://github.com/Destroy666x',
		'author'		=> 'Destroy666',
		'authorsite'	=> 'https://github.com/Destroy666x',
		'version'		=> 1.1,
		'codename'		=> 'moderation_actions_preview',
		'compatibility'	=> '18*'
    );
}

function moderation_actions_preview_activate()
{ 
	global $db, $lang;
	
	$lang->load('moderation_actions_preview_acp');
	
	// Modify templates
	require_once MYBB_ROOT.'/inc/adminfunctions_templates.php';
	find_replace_templatesets('postbit', '#'.preg_quote('{$ignore_bit}').'#i', "{\$post['moderation_actions_bef']}
{\$ignore_bit}");
	find_replace_templatesets('postbit_classic', '#'.preg_quote('{$ignore_bit}').'#i', "{\$post['moderation_actions_bef']}
{\$ignore_bit}");
	find_replace_templatesets('postbit', '#'.preg_quote("{\$post['button_delete_pm']}
	</div>
</div>
</div>").'#', "{\$post['button_delete_pm']}
	</div>
</div>
</div>
{\$post['moderation_actions_aft']}");
	find_replace_templatesets('postbit_classic', '#'.preg_quote("{\$post['button_delete_pm']}
	</div>
</div>
</div>").'#', "{\$post['button_delete_pm']}
	</div>
</div>
</div>
{\$post['moderation_actions_aft']}");
	find_replace_templatesets('member_profile', '#'.preg_quote('{$signature}').'#i', '{$signature}
			{$moderation_actions}');
	find_replace_templatesets('usercp', '#'.preg_quote('{$latest_warnings}').'#i', '{$latest_warnings}
{$moderation_actions}');
	
	// Settings
	if(!$db->fetch_field($db->simple_select('settinggroups', 'COUNT(1) AS cnt', "name ='moderation_actions_preview'"), 'cnt'))
	{
		$moderation_actions_preview_settinggroup = array(
			'gid'			=> NULL,
			'name'			=> 'moderation_actions_preview',
			'title'			=> $db->escape_string($lang->moderation_actions_preview),
			'description'	=> $db->escape_string($lang->moderation_actions_preview_settings),
			'disporder'		=> 666,
			'isdefault'		=> 0
		); 
		
		$db->insert_query('settinggroups', $moderation_actions_preview_settinggroup);
		$gid = (int)$db->insert_id();
		
		$d = -1;
		
		$moderation_actions_preview_settings[] = array(
			'name'			=> 'moderation_actions_preview_ips',
			'title'			=> $db->escape_string($lang->moderation_actions_preview_ips),
			'description'	=> $db->escape_string($lang->moderation_actions_preview_ips_desc),
			'optionscode'	=> 'yesno',
			'value'			=> 1
		);
		
		$moderation_actions_preview_settings[] = array(
			'name'			=> 'moderation_actions_preview_avatars',
			'title'			=> $db->escape_string($lang->moderation_actions_preview_avatars),
			'description'	=> $db->escape_string($lang->moderation_actions_preview_avatars_desc),
			'optionscode'	=> 'yesno',
			'value'			=> 1
		);
		
		$moderation_actions_preview_settings[] = array(
			'name'			=> 'moderation_actions_preview_avatars_posts_max',
			'title'			=> $db->escape_string($lang->moderation_actions_preview_avatars_posts_max),
			'description'	=> $db->escape_string($lang->moderation_actions_preview_avatars_posts_max_desc),
			'optionscode'	=> 'text',
			'value'			=> '40x40'
		);
		
		$moderation_actions_preview_settings[] = array(
			'name'			=> 'moderation_actions_preview_avatars_profile_max',
			'title'			=> $db->escape_string($lang->moderation_actions_preview_avatars_profile_max),
			'description'	=> $db->escape_string($lang->moderation_actions_preview_avatars_profile_max_desc),
			'optionscode'	=> 'text',
			'value'			=> '30x30'
		);
		
		$moderation_actions_preview_settings[] = array(
			'name'			=> 'moderation_actions_preview_allow_own',
			'title'			=> $db->escape_string($lang->moderation_actions_preview_allow_own),
			'description'	=> $db->escape_string($lang->moderation_actions_preview_allow_own_desc),
			'optionscode'	=> 'yesno',
			'value'			=> 1
		);
		
		$moderation_actions_preview_settings[] = array(
			'name'			=> 'moderation_actions_preview_profile_limit',
			'title'			=> $db->escape_string($lang->moderation_actions_preview_profile_limit),
			'description'	=> $db->escape_string($lang->moderation_actions_preview_profile_limit_desc),
			'optionscode'	=> 'numeric',
			'value'			=> 6
		);
		
		foreach($moderation_actions_preview_settings as &$current_setting)
		{
			$current_setting['sid'] = NULL;
			$current_setting['disporder'] = ++$d;
			$current_setting['gid'] = $gid;
		}
		
		$db->insert_query_multiple('settings', $moderation_actions_preview_settings);
		
		rebuild_settings();
	}
}

function moderation_actions_preview_deactivate()
{   
	require_once MYBB_ROOT.'/inc/adminfunctions_templates.php';
	find_replace_templatesets('postbit', '#\s*'.preg_quote("{\$post['moderation_actions_bef']}").'#i', '');
	find_replace_templatesets('postbit_classic', '#\s*'.preg_quote("{\$post['moderation_actions_bef']}").'#i', '');
	find_replace_templatesets('postbit', '#\s*'.preg_quote("{\$post['moderation_actions_aft']}").'#i', '');
	find_replace_templatesets('postbit_classic', '#\s*'.preg_quote("{\$post['moderation_actions_aft']}").'#i', '');
	find_replace_templatesets('member_profile', '#\s*'.preg_quote('{$moderation_actions}').'#i', '');
	find_replace_templatesets('usercp', '#\s*'.preg_quote('{$moderation_actions}').'#i', '');
}

function moderation_actions_preview_install()
{
	global $lang;
	
	$lang->load('moderation_actions_preview_acp');
	
	if(!file_exists(PLUGINLIBRARY))
	{
		flash_message($lang->pluginlibrary_missing, 'error');
		admin_redirect('index.php?module=config-plugins');
	}
	
	global $PL;
	$PL or require_once PLUGINLIBRARY;
	
	$PL->templates('moderationactionspreview', $lang->moderation_actions_preview, array(
		'ip' => '{$lang->postbit_ipaddress} <a href="{$ipsearchlink}" title="{$iptitle}">{$ipaddress}</a>',
		'avatar' => '<a href="{$cleanlink}"><img src="{$avimg[\'image\']}" {$avimg[\'width_height\']} alt="" style="vertical-align: middle; margin-right: 2px;" /></a> ',
		'post' => '{$lang->postbit_post} <a href="{$postlink}">#{$log[\'pid\']}</a>',
		'postbit_row' => '<div class="{$trowbackg}" style="padding: 5px; border-right: 0; border-top: 2px solid #CCC;">
	{$avatar}{$username}{$lang->comma}{$date} - {$action}{$leftp}{$ip}{$comma}{$postinfo}{$rightp}	
</div>',
		'profile_row' => '<tr>
	<td class="{$trowbackg}">
		{$avatar}{$username}{$lang->comma}{$date} - {$action}{$leftp}{$ip}{$comma}{$postinfo}{$rightp}	
	</td>
</tr>',
		'profile' => '<table class="tborder" border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}">
	<tr>
		<td class="thead"><strong>{$lang->moderation_actions_preview_profile}</strong></td>
	</tr>
	{$modactions}
</table>
<br />',
		'ucp' => '<br />
<table class="tborder" border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}">
	<tr>
		<td class="thead"><strong>{$lang->moderation_actions_preview_profile}</strong></td>
	</tr>
	{$modactions}
</table>'
	));
}

function moderation_actions_preview_is_installed()
{
	global $db;
	
	return $db->fetch_field($db->simple_select('templates', 'COUNT(1) AS cnt', "title ='moderationactionspreview_avatar'"), 'cnt');
}

function moderation_actions_preview_uninstall()
{   
	global $lang;
	
	$lang->load('moderation_actions_preview_acp');
	
	if(!file_exists(PLUGINLIBRARY))
	{
		flash_message($lang->pluginlibrary_missing, 'error');
		admin_redirect('index.php?module=config-plugins');
	}
	
	global $PL, $db;
	$PL or require_once PLUGINLIBRARY;
	
	$PL->templates_delete('moderationactionspreview');
	$db->delete_query('settings', "name LIKE 'moderation\_actions\_preview\_%'");
	$db->delete_query('settinggroups', "name = 'moderation_actions_preview'");
	
	rebuild_settings();
}

$plugins->add_hook('admin_settings_print_peekers', 'moderation_actions_preview_peekers');

function moderation_actions_preview_peekers($peekers)
{
	// Peeker for avatar settings
	$peekers[] = 'new Peeker($(".setting_moderation_actions_preview_avatars"), $("#row_setting_moderation_actions_preview_avatars_posts_max, #row_setting_moderation_actions_preview_avatars_profile_max"), 1, true)';
	
	return $peekers;
}

$plugins->add_hook('global_start', 'moderation_actions_preview_global');

function moderation_actions_preview_global()
{
	// Cache templateswhere required
	if(THIS_SCRIPT == 'showthread.php')
		$GLOBALS['templatelist'] .= !empty($GLOBALS['templatelist'])
								? ',moderationactionspreview_ip,moderationactionspreview_avatar,moderationactionspreview_post,moderationactionspreview_postbit_row'
								: 'moderationactionspreview_ip,moderationactionspreview_avatar,moderationactionspreview_post,moderationactionspreview_postbit_row';
	elseif(THIS_SCRIPT == 'member.php' && $GLOBALS['mybb']->get_input('action') == 'profile')
		$GLOBALS['templatelist'] .= !empty($GLOBALS['templatelist'])
								? ',moderationactionspreview_ip,moderationactionspreview_avatar,moderationactionspreview_post,moderationactionspreview_profile_row,moderationactionspreview_profile'
								: 'moderationactionspreview_ip,moderationactionspreview_avatar,moderationactionspreview_post,moderationactionspreview_profile_row,moderationactionspreview_profile';		
}

$plugins->add_hook('postbit', 'moderation_actions_preview_showthread');

function moderation_actions_preview_showthread(&$post)
{
	global $mybb;
	
	$post['moderation_actions_bef'] = $post['moderation_actions_aft'] = '';
	
	// Skip if a person can't view mod logs, also skip non-showthread calls (for example newthread.php's quick reply AJAX)
	if($mybb->usergroup['canviewmodlogs'] && THIS_SCRIPT == 'showthread.php')
	{
		static $modactionbefpids = array(), $modactionaftpids = array();
		
		if(empty($modactionbefpids))
		{	
			// Unsafely assume that the pagination variables were not modified by any plugin (may modify it in the future)..
			global $db, $page, $pages, $perpage;
			
			// Get all pids on the current page and one on the previous page (if it exists) sorted by ascending dateline
			$dtposts = array();
			$canviewdeleted = is_moderator($post['fid'], 'canviewdeleted');
			$canviewunapproved = is_moderator($post['fid'], 'canviewunapprove');
			
			if($page > 1)
				$startpost = ($page - 1) * $perpage - 1;
			else
			{
				$startpost = 0;
				$page = 1;
			}
			
			if(!$canviewdeleted && !$canviewunapproved)
				$postvis = ' AND visible = 1';
			elseif($canviewdeleted && $canviewunapproved)
				$postvis = ' AND visible IN(-1,0,1)';
			elseif(!$canviewdeleted && $canviewunapproved)
				$postvis = ' AND visible IN(0,1)';
			else	
				$postvis = ' AND visible IN(-1,1)';
		
			$q = $db->simple_select('posts', 'dateline, pid', "tid = {$post['tid']}{$postvis}", array('order_by' => 'dateline', 'limit_start' => $startpost, 'limit' => $perpage));
			
			while($p = $db->fetch_array($q))
				$dtposts[$p['pid']] = $p['dateline'];
			
			// Get first and last post info
			end($dtposts);
			$lastpid = key($dtposts);
			$lastdt = $page != $pages ? current($dtposts) : 0;
			reset($dtposts);
			$firstdt = $page > 1 ? current($dtposts) : 0;
			
			foreach($dtposts as $pid => $dateline)
				$modactionaftpids[$pid] = $modactionbefpids[$pid] = '';
				
			$avasql = $mybb->settings['moderation_actions_preview_avatars'] ? ' u.avatar, u.avatardimensions,' : '';
			$ipsql = $mybb->settings['moderation_actions_preview_ips'] && is_moderator($post['fid'], 'canviewips') ? ' m.ipaddress,' : '';
			// Skip logs younger than the last post from previous page (if it exists) and older than last post on non-last page
			$aftsql = $firstdt ? " AND m.dateline >= $firstdt" : '';
			$befsql = $lastdt ? " AND m.dateline < $lastdt" : '';
			
			$q = $db->write_query("SELECT u.username, u.usergroup, u.displaygroup,{$avasql} m.dateline, m.uid,{$ipsql} m.action, m.pid
				FROM {$db->table_prefix}moderatorlog m
				LEFT JOIN {$db->table_prefix}users u ON(u.uid = m.uid)
				WHERE m.tid = {$post['tid']}{$aftsql}{$befsql}
				ORDER BY m.dateline
			");
			
			while($log = $db->fetch_array($q))
			{	
				foreach($dtposts as $pid => $dateline)
				{	
					// Insert logs before suitable posts
					if($log['dateline'] <= $dateline)
					{
						$modactionbefpids[$pid] .= display_moderation_action($log, $mybb->settings['moderation_actions_preview_avatars_posts_max']);
						break;
					}
					// If it's the last post in the thread, also insert logs after it
					elseif($pid == $lastpid && $page == $pages)
						$modactionaftpids[$lastpid] .= display_moderation_action($log, $mybb->settings['moderation_actions_preview_avatars_posts_max']);
				}
			}
		}
		
		$post['moderation_actions_bef'] = $modactionbefpids[$post['pid']];
		$post['moderation_actions_aft'] = $modactionaftpids[$post['pid']];
	}
}

$plugins->add_hook('postbit_announcement', 'moderation_actions_preview_announcement');

function moderation_actions_preview_announcement(&$post)
{
	global $mybb;
	
	$post['moderation_actions_bef'] = $post['moderation_actions_aft'] = '';
	
	if($mybb->usergroup['canviewmodlogs'])
	{
		global $db;
		
		$avasql = $mybb->settings['moderation_actions_preview_avatars'] ? ' u.avatar, u.avatardimensions,' : '';
		$ipsql = $mybb->settings['moderation_actions_preview_ips'] && is_moderator($post['fid'], 'canviewips')  ? ' m.ipaddress,' : '';

		$q = $db->write_query("SELECT u.username, u.usergroup, u.displaygroup,{$avasql} m.dateline, m.uid,{$ipsql} m.action, m.data
			FROM {$db->table_prefix}moderatorlog m
			LEFT JOIN {$db->table_prefix}users u ON(u.uid = m.uid)
			WHERE m.data LIKE '%aid%'
			ORDER BY m.dateline
		");

		while($log = $db->fetch_array($q))
		{
			// Lovely serialization..
			$data = my_unserialize($log['data']);
			
			if($data['aid'] == $post['aid'])
			{
				if($log['dateline'] <= $post['dateline'])
					$post['moderation_actions_bef'] .= display_moderation_action($log, $mybb->settings['moderation_actions_preview_avatars_posts_max'], 'moderationactionspreview_postbit_row');
				else
					$post['moderation_actions_aft'] .= display_moderation_action($log, $mybb->settings['moderation_actions_preview_avatars_posts_max'], 'moderationactionspreview_postbit_row');
			}
		}		
	}
}

$plugins->add_hook('postbit_prev', 'moderation_actions_preview_noactions');
$plugins->add_hook('postbit_pm', 'moderation_actions_preview_noactions');

function moderation_actions_preview_noactions(&$post)
{
	$post['moderation_actions_bef'] = $post['moderation_actions_aft'] = '';
}

$plugins->add_hook('member_profile_end', 'moderation_actions_preview_profile');
$plugins->add_hook('usercp_end', 'moderation_actions_preview_profile');

function moderation_actions_preview_profile()
{
	global $mybb, $moderation_actions;
	
	$moderation_actions = '';
	$uid = $mybb->user['uid'];
	$templ = 'moderationactionspreview_ucp';
	
	if(THIS_SCRIPT == 'member.php')
	{
		$uid = $GLOBALS['memprofile']['uid'];
		$templ = 'moderationactionspreview_profile';
	}
	
	if($mybb->usergroup['canviewmodlogs'] || $mybb->settings['moderation_actions_preview_allow_own'] && $uid == $mybb->user['uid'])
	{
		global $db, $lang;
		
		$lang->load('moderation_actions_preview');
		
		$avasql = $mybb->settings['moderation_actions_preview_avatars'] ? ' u.avatar, u.avatardimensions,' : '';
		$ipsql = $mybb->settings['moderation_actions_preview_ips'] && $mybb->usergroup['issupermod'] || $mybb->usergroup['cancp'] ? ' m.ipaddress,' : '';
		$limit = (int)$mybb->settings['moderation_actions_preview_profile_limit'];
		$modactions = '';
		$lim = 0;
		
		if($limit > 0)
			$lang->moderation_actions_preview_profile = $lang->sprintf($lang->moderation_actions_preview_profile_limit, $limit);
		
		$q = $db->write_query("SELECT u.username, u.usergroup, u.displaygroup,{$avasql} m.dateline, m.uid,{$ipsql} m.action, m.data
			FROM {$db->table_prefix}moderatorlog m
			LEFT JOIN {$db->table_prefix}users u ON(u.uid = m.uid)
			WHERE m.data LIKE '%uid%'
			ORDER BY m.dateline DESC
		");
			
		while($log = $db->fetch_array($q))
		{
			// Lovely serialization..
			$data = my_unserialize($log['data']);
			
			if($data['uid'] == $uid)
			{
				$modactions .= display_moderation_action($log, $mybb->settings['moderation_actions_preview_avatars_profile_max'], 'moderationactionspreview_profile_row');
				++$lim;
				
				if($lim == $limit)
					break;
			}
		}
		
		if($modactions)
		{
			global $theme;
			
			eval('$moderation_actions = "'.$GLOBALS['templates']->get($templ).'";');
		}
	}
}

/*
Get moderator action HTML.

@param array - Log information (action, dateline, uid, username, usergroup, displaygroup, ip, avatar, avatardimensions, pid)
@param string - Maximal avatar dimensions (widthxheight).
@param string - Template to use for the moderation action row.
@return string - The resulting HTML, empty if there is nothing to display.
*/
function display_moderation_action($log, $maxavatarsize = '30x30', $template = 'moderationactionspreview_postbit_row')
{
	// No point in displaying anything if there is no action
	if(empty($log['action']))
		return '';
	
	global $templates, $lang;
	
	if(!isset($lang->moderation_actions_preview_unknown_acc))
		$lang->load('moderation_actions_preview');
	
	$date = my_date('relative', $log['dateline']);
	$action = htmlspecialchars_uni($log['action']);
	$postinfo = $avatar = $ip = $iptitle = $leftp = $rightp = $comma = '';
	$cleanlink = $ipsearchlink = '#';
	
	if(!empty($log['username']))
	{
		$username = build_profile_link(format_name(htmlspecialchars_uni($log['username']), $log['usergroup'], $log['displaygroup']), $log['uid']);
		$cleanlink = get_profile_link($log['uid']);
	}
	else
		$username = $lang->moderation_actions_preview_unknown_acc;
	
	if(!empty($log['ipaddress']))
	{
		global $mybb;
		
		$ipaddress = my_inet_ntop($GLOBALS['db']->unescape_binary($log['ipaddress']));
		
		if($mybb->usergroup['canmodcp'] && $mybb->usergroup['canuseipsearch'])
		{
			$ipsearchlink = "modcp.php?action=ipsearch&amp;ipaddress={$ipaddress}&amp;search_users=1";
			$iptitle = $lang->moderation_actions_preview_find_ip;
		}
		
		eval('$ip = "'.$templates->get('moderationactionspreview_ip', 1, 0).'";');
	}
				
	if(isset($log['avatar']))
	{
		$avimg = format_avatar($log['avatar'], $log['avatardimensions'], strtolower($maxavatarsize));
		eval('$avatar = "'.$templates->get('moderationactionspreview_avatar').'";');
	}
	
	if(!empty($log['pid']))
	{
		$postlink = get_post_link($log['pid'])."#pid{$log['pid']}";
		eval('$postinfo = "'.$templates->get('moderationactionspreview_post', 1, 0).'";');
	}
	
	if($ip || $postinfo)
	{
		$leftp = $lang->moderation_actions_preview_l;
		$rightp = $lang->moderation_actions_preview_r;
		
		if($ip && $postinfo)
			$comma = $lang->comma;
	}
	
	$trowbackg = alt_trow();
	
	eval('$templ = "'.$templates->get($template).'";');
	return $templ;
}