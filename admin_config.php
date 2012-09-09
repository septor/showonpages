<?php

if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER.'userclass_class.php');
include_lan(e_PLUGIN."showonpages/languages/".e_LANGUAGE.".php");

if(e_QUERY){
	$tmp = explode('.', e_QUERY);
	$action = $tmp[0];
	$id = $tmp[1];
	unset($tmp);
}

if(isset($_POST['addcontent'])){
	$pages = ($_POST['pages'][0] == "*" ? "*" : $tp->toDB($_POST['pages']));
	$message = ($sql->db_Insert("showonpages_content", "NULL, '".$tp->toDB($_POST['code'])."', '".$tp->toDB($_POST['description'])."', '".$pages."', '".intval($_POST['userclass'])."'")) ? SOPLAN_CONFIG_01 : SOPLAN_CONFIG_02;
}

if(isset($_POST['editcontent'])){
	$pages = ($_POST['pages'][0] == "*" ? "*" : $tp->toDB($_POST['pages']));
	$message = ($sql->db_Update("showonpages_content", "code='".$tp->toDB($_POST['code'])."', description='".$tp->toDB($_POST['description'])."', pages='".$pages."', userclass='".intval($_POST['userclass'])."' WHERE id=".intval($_POST['id']))) ? SOPLAN_CONFIG_03 : SOPLAN_CONFIG_04;
}

if(isset($_POST['main_delete'])){
	$delete_id = array_keys($_POST['main_delete']);
	$message = ($sql2->db_Delete("showonpages_content", "id=".intval($delete_id[0]))) ? SOPLAN_CONFIG_05 : SOPLAN_CONFIG_06;
}

if(isset($message)){
	$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

$add = "<div style='text-align:center'>
<form method='post' action='".e_SELF."'>
<table style='width:75%' class='fborder'>
<tr>
<td style='width:50%' class='forumheader3'>".SOPLAN_CONFIG_07."<br /><br /><i>".SOPLAN_CONFIG_08."<br /><br />".SOPLAN_CONFIG_09."</td>
<td style='width:50%; text-align:right' class='forumheader3'>
<textarea style='height: 150px;' class='tbox' name='code'></textarea>
</td>
</tr>
<tr>
<td style='width:50%' class='forumheader3'>".SOPLAN_CONFIG_10."<br /><br /><i>".SOPLAN_CONFIG_11."</i></td>
<td style='width:50%; text-align:right' class='forumheader3'>
<input type='text' name='description' class='tbox' style='width: 90%;' />
</td>
</tr>
<tr>
<td style='width:50%' class='forumheader3'>".SOPLAN_CONFIG_12."<br /><br /><i>".SOPLAN_CONFIG_13."<br />".SOPLAN_CONFIG_14."<br />".SOPLAN_CONFIG_15."<br /><br />".SOPLAN_CONFIG_16."</i></td>
<td style='width:50%; text-align:right' class='forumheader3'>
<input type='text' name='pages' class='tbox' style='width: 90%;' />
</td>
</tr>
<tr>
<td style='width:50%' class='forumheader3'>".SOPLAN_CONFIG_17."<br /><br /><i>".SOPLAN_CONFIG_18."</i></td>
<td style='width:50%; text-align:right' class='forumheader3'>
".r_userclass('userclass', 0, 'off', 'public,nobody,guest,member,admin,main,classes')."
</td>
</tr>
<tr>
<td colspan='2' style='text-align:center' class='forumheader'>
<input class='button' type='submit' name='addcontent' value='".SOPLAN_CONFIG_19."' />
</td>
</tr>
</table>
</form>
</div>";

$list = "<div style='text-align:center'>
<table style='width:75%' class='fborder'>";
if($action == "edit"){
	$list .= "<tr>
	<td style='width:5%;' class='fcaption'>".SOPLAN_CONFIG_20."</td>
	<td style='width:45%;' class='fcaption'>".SOPLAN_CONFIG_21."</td>
	<td style='width:20%;' class='fcaption'>".SOPLAN_CONFIG_22."</td>
	<td style='width:20%;' class='fcaption'>".SOPLAN_CONFIG_23."</td>
	<td style='width:10%;' class='fcaption'>&nbsp;</td>
	</tr>";
}else{
	$list .= "<tr>
	<td style='width:5%;' class='fcaption'>".SOPLAN_CONFIG_20."</td>
	<td style='width:55%;' class='fcaption'>".SOPLAN_CONFIG_21."</td>
	<td style='width:30%;' class='fcaption'>".SOPLAN_CONFIG_22."</td>
	<td style='width:10%;' class='fcaption'>&nbsp;</td>
	</tr>";
}

if($sql->db_Count("showonpages_content", "(*)") > 0){
	$sql->db_Select("showonpages_content", "*", "ORDER BY id ASC", "no-where");
	while($row = $sql->db_Fetch()){
		if($action == "edit" && $id == $row['id']){
			$list .= "<form method='post' action='".e_SELF."'>
			<tr>
			<td class='forumheader3' style='text-align:center;'>".$row['id']."</td>
			<td class='forumheader3' style='text-align:center;'>".SOPLAN_CONFIG_10." <input type='text' class='tbox' name='description' value='".$row['description']."' /><br /><textarea style='height:".(strlen($row['code']) / 2)."px;' class='tbox' name='code'>".$tp->toForm($row['code'])."</textarea></td>
			<td class='forumheader3'><input type='text' class='tbox' name='pages' value='".$row['pages']."' /></td>
			<td class='forumheader3'>".r_userclass('userclass', $row['userclass'], 'off', 'public,nobody,guest,member,admin,main,classes')."</td>
			<td class='forumheader3' style='text-align:center;'>
			<input type='hidden' name='id' value='".$row['id']."' />
			<input type='submit' class='button' name='editcontent' value='".SOPLAN_CONFIG_24."' />
			</td>
			</tr>
			</form>";
		}else{
			$list .= "<form method='post' action='".e_SELF."'>
			<tr>
			<td class='forumheader3' style='text-align:center;'>".$row['id']."</td>
			<td class='forumheader3' style='text-align:center;'><a onclick='expandit(\"sopcc_".$row['id']."\");'>".$row['description']."</a><div id='sopcc_".$row['id']."' style='display:none;'><textarea style='height:".(strlen($row['code']) / 2)."px;' class='tbox'>".$tp->toForm($row['code'])."</textarea></div></td>
			<td class='forumheader3'>".$row['pages']."</td>
			<td class='forumheader3' style='text-align:center;'>
			<a href='".e_SELF."?edit.".$row['id']."'>".ADMIN_EDIT_ICON."</a>
			<input type='image' title='".LAN_DELETE."' name='main_delete[".$row['id']."]' src='".e_PLUGIN."showonpages/images/delete_16.png' onclick=\"return jsconfirm('".SOPLAN_CONFIG_25." [ID: ".$row['id']." ]')\"/>
			</td>
			</tr>
			</form>";
		}
	}
}else{
	$list .= "<tr>
	<td colspan='4' style='text-align:center;' class='forumheader3'>".SOPLAN_CONFIG_26."</td>
	</tr>";
}
$list .= "</table>
</div>";

$ns->tablerender(SOPLAN_CONFIGCAPTION_01, $add);
$ns->tablerender(SOPLAN_CONFIGCAPTION_02, $list);

require_once(e_ADMIN."footer.php");
?>
