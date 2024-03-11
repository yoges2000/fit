<?php
require_once '../includes/connection.php';

$query = "SELECT MC_LENGTH,MC_PARENTID FROM STD_MACHINES WHERE MC_ID='{$_SESSION['mc_id']}'";
$res = mysqli_query($fit, $query);
$row = mysqli_fetch_assoc($res);
$out['LENGTH'] = $row['MC_LENGTH'];
$out['TIME'] = array();
$out['TIME'][0] = date("h:i:s");
$out['TIME'][1] = date("A");

$rollpid=$row['MC_PARENTID'];
$qryroll = "SELECT ROLL_DOFF_LENGTH,SUM(ROLL_LENGTH) AS ROLL_LENGTH FROM ROLL WHERE ROLL_PARENTID='$rollpid'";
$rollres = mysqli_query($fit, $qryroll);
$rollrow = mysqli_fetch_assoc($rollres);
$ballen=round($rollrow['ROLL_DOFF_LENGTH']-$rollrow['ROLL_LENGTH']-$row['MC_LENGTH'],2);
$out['BAL_LENGTH']=($ballen>0)?$ballen:0;


echo json_encode($out);


