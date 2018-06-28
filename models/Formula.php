<?php

namespace app\models;

use yii\db\Query;

class Formula
{

    public static function test()
    {
        $VM_IDS = ["906_FON_MTH_VOLLEYBALL"];
        $DATE_FROM = '2018-05-01';

        $IS_UNIQUE_ONLY = 1;
        $PROCESS_TENNIS = 1;
        $PROCESS_SOCCER = 0;

        $_bets = [];

        foreach($VM_IDS as $vm_id){
            echo "[+] Loading results for $vm_id ... ";

            $query = new Query();
            $rows = $query
                ->select('*')
                ->from('forks_stakes')
                ->where(['vm_id' => $vm_id])
                ->andWhere(['>=', 'added_at', $DATE_FROM])
                ->andWhere(['bet_result' => [-1, 1]])
                ->all();

            $_bets = $rows;

        }

        echo sprintf("%d row(s)\n", count($rows));



        $total = 0;
        $win = 0;
        $lose = 0;
        $total_win = 0.0;
        $total_lose = 0.0;
        $total_size = 0.0;



        foreach ($_bets as $_bet) {
            #list($time, $id, $sport, $event_name, $bet_name, $cf, $size, $return, $status)= $_bet;
            list($time, $id, $sport, $event_name, $bet_name, $cf, $size, $return, $status) = array(
                $_bet['added_at'],
                $_bet['id'],
                '',
                $_bet['event_name'],
                $_bet['bet_name'],
                $_bet['real_cf'],
                $_bet['amount'],
                '',
                $_bet['bet_result']
            );


            list($date, $_time) = explode(" ", $time);
            if ($date > '23.04') {
                #    continue;
            }

            #if($size < 500){
            #    continue;
            #}

            if (!in_array($status, array(1, -1))) {
                #echo $str . "\n";
                #print_r(explode(",", $str));
                //continue;
            }

            #if(floatval($cf) >= 1.85){
            #if(floatval($cf) < 1.5 or floatval($cf) > 3.5){
            #if(floatval($cf) <= 2){
            #if(floatval($cf) > 1.5){

            #if(floatval($cf) < 1.5 or floatval($cf) > 2.0){
            #    if(floatval($cf) < 1.5 or floatval($cf) > 1.75){
            #if(floatval($cf) < 2.0 or floatval($cf) > 2.5){
            #if(floatval($cf) < 2.5 or floatval($cf) > 3.5){

            if (floatval($cf) < 3.5 ) {
                #    continue;
            }

            # <= 2, sport=1
            # sport = 4, filter=<>
            # sport = 3

            $filter = ""; $filter2 = "";

            #$filter2 = "^TOTALS__";
            #$filter2 = "^SET_[0-9]+__WIN__";
            #$filter2 = "^SET_[0-9]+__TOTALS__";
            #$filter2 = "^WIN__";
            #$filter2 = "^GAME__";
            #$filter2 = "^HANDICAP__";
            #$filter2 = "^SET_[0-9]+__HANDICAP";

            $stop_filters = array(
                #"^WIN__"
            );


            if (!preg_match("!$filter!", $event_name)) {
                //continue;
            }

            if (!preg_match("!$filter2!", $bet_name)) {
                //continue;
            }

            $_stop = false;
            foreach ($stop_filters as $stop_filter){
                if (preg_match("!$stop_filter!", $bet_name)) {
                    //$_stop = true;
                }
            }
            if ($_stop) {
                //continue;
            }

            #if((!$PROCESS_TENNIS and $sport == 4) or (!$PROCESS_SOCCER and $sport == 1)){
            #    continue;
            #}

            //echo "$cf|$status|$sport|$event_name - $bet_name|$time\n";



            $total += 1;
            $is_win = ($status == 1);
            $size = 100;
            $return = $is_win ? ($size * floatval($cf)) : 0;
            $total_size += $size;


            if ($is_win) {
                $win += 1;
                $total_win += ($return - $size);
            } else {
                $lose += 1;
                $total_lose += -$size;
            }
        }

        echo "\n\n";

        $win_percent = ($total > 0 ? (1.0*$win/$total)*100 : 0.0);
        $lose_percent = ($total > 0 ? (1.0*$lose/$total)*100 : 0.0);

        $size_avg = ($total > 0 ? $total_size/$total : 0.0);

        $win_avg = ($win > 0 ? ($total_win/$win) : 0.0);
        $lose_avg = ($win > 0 ? ($total_lose/$lose) : 0.0);

        $income = $total_win + $total_lose;
        $income_avg = $total > 0 ? $income/$total : 0.0;

        $ROI = ($income_avg/$size_avg)*100;
        $PROFIT_RATIO = abs(($win_percent/$lose_percent)*($win_avg/$lose_avg));


        echo sprintf("[#] AVG STAKE SIZE: %.2f p.\n", $size_avg);
        echo "<br>";
        echo sprintf("[#] WIN  : %d / %d = %.1f%% (AVG = %.2f p.)\n", $win, $total, $win_percent, $win_avg);
        echo "<br>";
        echo sprintf("[#] LOSE : %d / %d = %.1f%% (AVG = %.2f p.)\n", $lose, $total, $lose_percent, $lose_avg);
        echo "<br>";
        echo sprintf("[#] TOTAL WIN: %.2f p.\n", $total_win);
        echo "<br>";
        echo sprintf("[#] TOTAL LOSE: %.2f p.\n", $total_lose);
        echo "<br>";
        echo sprintf("[#] TOTAL INCOME: %.2f p. (AVG=%.3f) (ROI=%.2f%%)\n", $income, $income_avg, $ROI);
        echo "<br>";
        echo sprintf("[#] RATIO: %.2f\n", $PROFIT_RATIO);
        echo "<br>";

    }


}
