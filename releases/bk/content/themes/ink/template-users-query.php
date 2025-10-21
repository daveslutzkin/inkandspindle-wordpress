<?php
/*
  Template Name: Users query
*/


if (!current_user_can("administrator")) exit;


$url = str_replace("?" . $_SERVER["QUERY_STRING"], "", $_SERVER["REQUEST_URI"]);
$offset = $_GET["offset"] ?? 0;

$form_ids = 1;
$search_criteria = [];
$sorting = null;
$paging = ["offset" => $offset, "page_size" => 200];
$total_count = null; //30;

$entries = GFAPI::get_entries($form_ids, $search_criteria, $sortin, $paging, $total_count);


$emails = array_map(function ($e) {
	return $e["3"];
}, $entries);
?>


<p>Users</p>

<textarea readonly style="width: 100%; height: 10em;"><?= join(", ", $emails) ?></textarea>
<p><small>Offset: <?= $offset ?>. Count: <?= count($emails) ?></small></p>

<a href="<?= $url ?>?offset=<?= ($offset + 1) ?>">Next page</a>

<hr />

<pre><?= print_r($entries, true) ?></pre>
