<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
<head>
<?php include_once(APPPATH . 'views/includes/head.php'); ?>
</head>
<body>
<div class="navigation">
<?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
</div>
<div class="container">
<div class="container-inner">
<div id="fieldservice-read">
<table>
<colgroup>
<col span="1" style="width: 65px;" />
<col span="1" style="width: 300px;" />
<col span="1" style="width: 240px;" />
<col span="1" style="width: 140px;" />
<col span="1" style="width: 100px;" />
<col span="1" style="width: 60px;" />
</colgroup>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Locality</th>
<th>City</th>
<th>Last Visit</th>
<th>Priority</th>
</tr>
</thead>
<tbody>
<?php foreach ($foreigne as $key => $value): ?>
<tr>
<td>
<?php print $value['for_id']; ?>
</td>
<td>
<?php print $value['for_name']; ?>
</td>
<td>
<?php print $value['for_sublocality']; ?>
</td>
<td>
<?php print $value['for_locality']; ?>
</td>
<td>
<?php print !empty($value['vis_date']) ? date('d/m/Y', strtotime($value['vis_date'])) : "Not made yet."; ?>
</td>
<td class="<?php print $value['color']; ?>">&nbsp;</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<div id="fieldservice-work">
<div class="fieldservice-work-view">
<?php if (count($listings) > 0): ?>
<table>
<colgroup>
<col span="1" style="width: 65px;" />
<col span="1" style="width: 100px;" />
<col span="1" style="width: 200px;" />
<col span="1" style="width: 485px;" />
<col span="1" style="width: 50px;" />
</colgroup>
<thead>
<tr>
<th>ID</th>
<th>Date</th>
<th>Conductor</th>
<th>Contacts</th>
<th>Options</th>
</tr>
</thead>
<tbody>
<?php foreach ($listings as $key => $value): ?>
<tr>
<td>
<?php print $value->fia_iden; ?>
</td>
<td>
<?php print date('d/m/Y', strtotime($value->fia_date)); ?>
</td>
<td>
<?php print $value->fia_cond; ?>
</td>
<td>
<ul class="fieldsearch-visits">
<?php foreach ($value->fie_foreigners_ as $key_ => $value_): ?>
<li class="<?php print $value_[1]; ?>">
<a href="<?php print site_url("profile/contact/{$value_[0]}"); ?>">
<?php print $value_[0]; ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</td>
<td>
<?php if ($value->fia_show): ?>
<div class="btn-group">
<ul>
<li>
<a target="_blank" class="btn-info" href="/fieldservice/printer/<?php print $value->fia_iden; ?>">
<!--<i class="icon-print">
</i>Print-->
</a>
</li>
</ul>
</div>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p>No field service assegned yet.</p>
<?php endif; ?>
</div>
<div class="fieldservice-work-form">
<form action="<?php print $this->config->base_url(); ?>fieldservice/addWork" method="post">
<fieldset>
<dl>
<dt>
<label for="fia_cond">Conductor</label>
</dt>
<dd style="width: 310px;">
<input type="text" name="fia_cond" />
</dd>
</dl>
<dl>
<dt>
<label for="fia_date">Date</label>
</dt>
<dd style="width: 100px;">
<input type="text" name="fia_date" />
</dd>
</dl>
</fieldset>
<input type="hidden" class="fia_fore" name="fia_fore" value="<?php print implode(",", $for_list); ?>" />
<input type="hidden" class="fis_iden" name="fis_iden" value="<?php print $identify; ?>" />
<input type="submit" value="Submit" />
</form>
</div>
</div>
</div>
</div>
<?php include_once(APPPATH . 'views/includes/footer.php'); ?>
</body>
</html>