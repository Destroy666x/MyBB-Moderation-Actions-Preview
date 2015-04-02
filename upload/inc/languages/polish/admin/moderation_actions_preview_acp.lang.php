<?php

/*
Nazwa: Pokaż akcje moderatorów
Autor: Destroy666
Wersja: 1.1
Wymagania: Plugin Library
Informacje: Plugin dla skryptu MyBB, zakodowany dla wersji 1.8.x (może także działać w 1.6.x/1.4.x po zmianach).
Wyświetla akcje moderatorów posortowane wg daty w postach/ogłoszeniach/profilach (w podobny sposób do github).
7 nowych szablonów, 6 zmian w szablonach, 6 nowych ustawień
Licencja: GNU GPL v3, 29 June 2007. Więcej informacji w pliku LICENSE.md.
Support: officjalne forum MyBB - http://community.mybb.com/mods.php?action=profile&uid=58253 (nie odpowiadam na PM, tylko na posty)
Zgłaszanie błędów: mój github - https://github.com/Destroy666x

© 2015 - date("Y")
*/

$l['moderation_actions_preview'] = 'Pokaż akcje moderatorów';
$l['moderation_actions_preview_info'] = 'Wyświetla akcje moderatorów posortowane wg daty w postach/ogłoszeniach/profilach.';
$l['pluginlibrary_missing'] = '<strong>Uwaga:</strong> Modyfikacja wymaga biblioteki Plugin Library do dodawania/usuwania szablonów. Można ją pobrać <a href="https://github.com/frostschutz/MyBB-PluginLibrary/archive/master.zip">tutaj</a>.';

$l['moderation_actions_preview_settings'] = 'Ustawienia dla pluginu "Pokaż akcje moderatorów".';
$l['moderation_actions_preview_ips'] = 'Pokaż adresy IP?';
$l['moderation_actions_preview_ips_desc'] = 'Ustaw na Tak aby wyświetlić adresy IP. Tylko odpowiednie grupy będą w stanie je zobaczyć.';
$l['moderation_actions_preview_avatars'] = 'Pokaż avatary?';
$l['moderation_actions_preview_avatars_desc'] = 'Ustaw na Tak aby wyświetlić avatary.';
$l['moderation_actions_preview_avatars_posts_max'] = 'Maksymalne wymiary avatarów w postach i ogłoszeniach';
$l['moderation_actions_preview_avatars_posts_max_desc'] = 'Podaj maksymalną szerokość i wysokość avatarów w postach i ogłoszeniach. Wymiary rozdziel znakiem x.';
$l['moderation_actions_preview_avatars_profile_max'] = 'Maksymalne wymiary avatarów w profilach i panel użytkownika';
$l['moderation_actions_preview_avatars_profile_max_desc'] = 'Podaj maksymalną szerokość i wysokość avatarów w profilach i panelu użytkownika. Wymiary rozdziel znakiem x.';
$l['moderation_actions_preview_allow_own'] = 'Zezwól wszystkim użytkownikom na przeglądanie akcji związanych z własnym kontem?';
$l['moderation_actions_preview_allow_own_desc'] = 'Ustaw na Tak aby zezwolić przeglądanie akcji związanych z własnym kontem w profilu i panelu użytkownika bez uprawnienia grupy <b>Może przeglądać wpisy w logach moderatorów?</b>.';
$l['moderation_actions_preview_profile_limit'] = 'Maksymalna liczba akcji moderatorów w profilach i panelu użytkownika';
$l['moderation_actions_preview_profile_limit_desc'] = 'Podaj maksymalną liczbę akcji moderatorów w profilach i panelu użytkownika. 0 dla nieskończoności.';
