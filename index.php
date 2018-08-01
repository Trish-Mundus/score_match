<?php 
function data(){
    require __DIR__ . '/data.php';
    return $data;
}
function A($team){
$party = data()[$team];
$detail = array(
'name' => $party['name'], 
'games' => $party['games'], 
'draw' => $party['draw'], 
//'chance' => round((($party['games']/100)*$party['win'])+(($party['games']/100)*rand(0,$party['draw'])),2), //шанс на выигрыш
//'loser' => round((($party['games']/100)*$party['defeat'])+(($party['games']/100)*rand(0,$party['draw'])),2), //шанс на проигрыш
'chance' => round($party['games']/(($party['win']/($party['defeat']+rand(0,$party['draw'])))),2), // вероятность победы где возможная ничья именно не с этой командой в рандоме
'loser' => round($party['games']/(($party['defeat']/($party['win']+rand(0,$party['draw'])))),2), // вероятность проигрыша где возможная ничья именно не с этой командой в рандоме
'power_attack' => round(($party['goals']['scored']/$party['games'])/$party['win'],2), // мощность атаки
'power_save' => round(($party['goals']['skiped']/$party['games'])/$party['win'],2) // мощность защиты
//'chance' => round($party['games']/(($party['win']/($party['defeat']+rand(0,$party['draw'])))),2), // вероятность победы где возможная ничья именно не с этой командой в рандоме
//'loser' => round($party['games']/(($party['defeat']/($party['win']+rand(0,$party['draw'])))),2), // вероятность проигрыша где возможная ничья именно не с этой командой в рандоме
//'power_attack' => round($party['goals']['scored']/$party['games'],2), // мощность атаки
//'power_save' => round($party['goals']['skiped']/$party['games'],2) // мощность защиты
);
//echo round(($party['goals']['scored']/$party['games'])/$party['win'],2),'M | ',round(($party['goals']['skiped']/$party['games'])/$party['win'],2),'M<br/>';
//echo round((($party['games']/100)*$party['win'])+(($party['games']/100)*rand(0,$party['draw'])),2),'% | ',round((($party['games']/100)*$party['defeat'])+(($party['games']/100)*rand(0,$party['draw'])),2),'%<br/>';
return $detail;
}
//$t = A($team);
//$samples = [$t['games']];
//$labels = [$t['goals']];
function match($c1, $c2){
//for($i=0;$i<=count(data());$i++){
//echo data()[$i]['goals']['scored'];
//}
$team1 = A($c1);
$team2 = A($c2);
$games = (int)min($team1['games'],$team2['games']); // вероятность кол-ва игр между командами
//$coef = $games/(($team1['chance'] + $team1['loser'])*($team2['chance'] + $team2['loser'])); // вероятность
//$random = $team1['draw']*$coef; // вероятность что ничья будет победой
//// кол-во голов за все игры между командами
//$goals_1_to_2 = abs((round((($team1['power_attack']/$team2['power_attack'])+($team1['power_save']/$team2['power_save']))*$random,0)));
//$goals_2_to_1 = abs((round((($team2['power_attack']/$team1['power_attack'])+($team2['power_save']/$team1['power_save']))*$random,0)));
$coef = $games/(($team1['chance'] - $team2['chance'])-($team1['loser'] - $team2['loser'])); // вероятность
$random = rand(0,($team1['draw']*$coef)); // вероятность что ничья будет победой
// кол-во голов за все игры между командами
$goals_1_to_2 = abs((round((($team1['power_attack']/$team2['power_attack'])+($team1['power_save']/$team2['power_save']))*$random,0)));
$goals_2_to_1 = abs((round((($team2['power_attack']/$team1['power_attack'])+($team2['power_save']/$team1['power_save']))*$random,0)));
//for($i=0;$i<=count(data());$i++){
return array((int)$goals_1_to_2,(int)$goals_2_to_1);
}
//function data(){
//    require __DIR__ . '/data.php';
//    return $data;
//}
$team1 = A(1);
$team2 = A(2);
$games = rand(0,(int)min($team1['games'],$team2['games']));
echo 'Если игр прошло мeжду командами: ', $games,'<hr/>';
if($games>0){
$score1 = 0.001;
$score2 = 0.001;
$score3 = 0.001;
$d = 0;
$d2 = 0;
$count = 0;
$rows = array();
//$f = array();
$s = array();
for($i=1;$i<=$games;$i++){
//for($i=1;$i<=5;$i++){
//print_r(match(1,2)[0]);
//$d += match(1,2)[0];
//$d2 += match(1,2)[1];
//$rows[] = match(1,2)[0];
//if (match(1,2)[0] > match(1,2)[1]){
//$score1 += 1;
//} else if (match(1,2)[0] < match(1,2)[1]){
//$score2 += 1;
//} else if (match(1,2)[0] == match(1,2)[1]) {$score3 += 1;}
//echo match(1,2)[0],' : ',match(1,2)[1],' вероятность счета - ','%','<br/>';
$rows[] = array('f'=>match(1,2)[0],'s'=>match(1,2)[1]);
//$s[] = array(match(1,2)[1]);
}
//function integ($a,$b){
//
//$A = A()
//
//return array($integ,$integ2);
//}
//print_r($f);
//print_r(array_count_values($rows));
//print_r($rows);
foreach($rows as $row){
echo $row['f'],' : ',$row['s'],' || ';
$f[] = $row['f'];
$s[] = $row['s'];
$d += $row['f'];
$d2 += $row['s'];
if ($row['f'] > $row['s']){
$score1 += 1;
} else if ($row['f'] < $row['s']){
$score2 += 1;
} else if ($row['f'] == $row['s']) {$score3 += 1;}
}
echo '<hr/>';
//print_r($f);
//print_r(array_count_values($f));
//echo ' - ';
//print_r(array_count_values($s));
//echo '<br/>';
//echo max(array_count_values($f)),' : ',max(array_count_values($s));
//echo '<br/>';
//print_r(array_count_values($f));
//echo ' - ';
//print_r(array_count_values($s));
//echo '<br/>';
//echo max(array_count_values($f)),' : ',min(array_count_values($f));
//echo '<br/>';
//echo max(array_count_values($s)),' : ',min(array_count_values($s));
//echo '<br/>';
//$fcount = array($f,);
//print_r($f);
//print_r(array_count_values ($rows));
$proc = round((100/count($rows))*$score1,0);
$proc2 = round((100/count($rows))*$score2,0);
$coef = floor($proc/10);
$coef2 = floor($proc2/10);
//$coef3 = round(100/$score3,2);
//$marj = round(100-((max($coef,$coef2)/100)*min($coef,$coef2)),2);
//$marj2 = round(($coef/$marj)+($coef2/$marj)+($coef3/$marj),2);
//echo '<hr/>Коэфицент ',$coef,' : ',$coef2,'<hr/>';
//echo '<hr/>Коэфицент$ ',round($coef3,2),' : ',round($coef2,0),'<hr/>';
echo 'Процент вероятности победы ',A(1)['name'],' ',$proc,'%','<br/>Процент вероятности победы ',A(2)['name'],' ',$proc2,'%<br/>';
//$scor1 = array_search(((max(array_count_values($f))+min(array_count_values($f)))/2),array_count_values($f));
//$scor2 = array_search(((max(array_count_values($s))+min(array_count_values($s)))/2),array_count_values($s));
$input1 = array_unique($f);
$input2 = array_unique($s);
$scor1 = array_search(((max(array_count_values($input1))+min(array_count_values($input1)))/2),array_count_values($f));
$scor2 = array_search(((max(array_count_values($input2))+min(array_count_values($input2)))/2),array_count_values($s));
echo 'Вероятный счет следующей игры- ',$scor1,' : ',$scor2;
echo '<br/>';
echo '<hr/>Побед I команды: ',round($score1,0),' | II команды: ',round($score2,0),' | Ничья: ',round($score3,0),'<br/>';
//$dataset = new KNearestNeighbors('data.php',1);
//
//foreach ($dataset->getSamples() as $sample) {
//    print_r($sample);
//}
}
else{echo 'У команд еще небыло совместного матча';}
?>
