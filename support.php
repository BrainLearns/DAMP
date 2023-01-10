<?php
function GetFileName($sno)
{
  $ftr=fopen('test_cell_info.txt',"r") or die("Unable to open index file!");
  //$val=fread($ftr,filesize("test_detr.txt"));
  $j=0;
  while($j <= $sno)
  {
   $fname=fgets($ftr);
   $j=$j+1;
  }
  fclose($ftr);
  //$fname=explode(" ",$fname);
  //$fname=implode("/",array_slice($fname, 4, 6));
  //echo $fname[0];
  //echo $fname[1];
  return $fname;
}

function RetrieveData($sno,$filename)
{
  $filename=$filename.".txt";
  $cc=GetFileName($sno);
  $cc=explode(" ",$cc);
  $ftr=fopen($filename,"r") or die("Unable to open index file!");
  $j=0;
  while($j <= $sno)
  {
   $savedres=fgets($ftr);
   $j=$j+1;
  }
  fclose($ftr);
  $savedres=explode("\n",$savedres);
  $savedres=$savedres[0];
  $savedres=strval(implode(" ",array_slice(explode(" ",$savedres), 1, $cc[1])));
  return $savedres;
}

function SaveData($sno,$data,$filename)
{
  $filename=$filename.".txt";
  $data=explode(" ",$data);
  unset($data[0]);
  $data=implode(" ",$data);
  $cc=GetFileName($sno);
  $cc=explode(" ",$cc);
  $ftr=fopen($filename,"r") or die("Unable to open write file!");
  $ftw=fopen("t".$filename,"w+") or die("Unable to open write file!");
  $j=0;
  while(!feof($ftr))
  {
   if ($j < $sno) {
     $fname=fgets($ftr);
     fputs($ftw,$fname);
   }
   else if ($j == $sno) {
     $fname=fgets($ftr);
     fputs($ftw,$cc[0]." ".$data."\n");
   }
   else {
     $fname=fgets($ftr);
     fputs($ftw,$fname);
   }
   $j=$j+1;
  }
  fclose($ftr);
  fclose($ftw);
  rename("t".$filename,$filename);
}

function ReadBBox($sno)
{
  $ftr=fopen('cell_pos.txt',"r") or die("Unable to open write file!");
  $j=0;
  while($j <= $sno)
  {
   $savedres=fgets($ftr);
   $j=$j+1;
  }
  fclose($ftr);
  return $savedres;
}

?>
