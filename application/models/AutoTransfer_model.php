<?php
class AutoTransfer_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->fa = $this->load->database('test_new_fa02', true);
    }
    public function GetPlan($line_cd){
        $this->TBK_FA01 = $this->load->database('test_new_fa02', true);
        $sql = "SELECT   * ,
        sup_work_plan_supply_dev.IND_ROW as IND_ROW,
          ISNULL(pa.prd_qty, 0) AS prd_qty_sum ,
          sup_work_plan_supply_dev.WORK_ODR_DLV_DATE AS ORIGINAL_PLAN,
          ISNULL(ppap.seq_no, 0) AS seq_no,
          (select SUM(abs(qty)) from production_defect_detail where flg_defact = '1' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NC,
      (select SUM(abs(qty)) from production_defect_detail where flg_defact = '2' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NG
                FROM
                    sup_work_plan_supply_dev,
                    control_prod_plan as cp
                        LEFT JOIN (
                            SELECT
                                wi_plan,
                                SUM (qty) AS prd_qty
                            FROM
                                production_actual_detail
                            WHERE
                                line_cd = '$line_cd'
                            AND updated_date > DATEADD(MONTH, - 1, GETDATE())
                            GROUP BY
                                wi_plan
                        ) AS pa ON cp.WI = pa.wi_plan
                        LEFT JOIN production_actual AS ppap ON cp.WI = ppap.WI
                where  
                    cp.id_plan = sup_work_plan_supply_dev.IND_ROW and 
                    cp.line_cd = '$line_cd' and 
                    cp.status_flg = '0' and 
                    sup_work_plan_supply_dev.PRD_COMP_FLG <> '9'
                    order by cp.order_flg asc";
            $query = $this->TBK_FA01->query($sql);
            $get = $query->result_array();
           foreach ($get as $key => $value) {
              $this->updateSupworkplan_work_plan($value["WI"] , "0");
           }
    }
    public function transferProduction($line_cd) {
        $data = $this->getCurrentDateActual($line_cd);
        foreach ($data as $key => $value) {
            if ($value->PRD_COMP_FLG != 9) {
                $plan = $value->QTY;
                $currentActual = $this->getCurrentActual($value->wi_plan);
    
                [$real, $comp_flg] = ($currentActual + $value->total_qty) >= $plan ? [$plan - $currentActual, 1] : [$value->total_qty, 0];
              
                $this->insertProductionActual((object)[
                    "wi" => $value->wi_plan,
                    "line_cd" => $value->LINE_CD,
                    "item_cd" => $value->ITEM_CD,
                    "plan" => $value->QTY,
                    "actual" => $real,
                    "seq" => $value->pwi_seq_no,
                    "shift" => $value->pwi_shift,
                    "manpower" => $value->manpower,
                    "st_date" => $value->start_time,
                    "st_time" => $value->start_time,
                    "end_date" => $value->end_time,
                    "end_time" => $value->end_time,
                    "lot" => $value->pwi_lot_no,
                    "comp_flg" => $comp_flg,
                    "updated_date" => date('Y-m-d H:i:s'),
                ]);

                if ($comp_flg) {
                    $this->updateSupworkplan($value->wi_plan , "9" );
                }else{
                    $this->updateSupworkplan($value->wi_plan  , "0");
                }
            }
        }

        return 1;
    }
    public function updateSupworkplan($wi , $flg) {
        $this->fa->query("UPDATE sup_work_plan_supply_dev SET PRD_COMP_FLG = $flg WHERE WI = ?", [$wi]);
    }
    public function updateSupworkplan_work_plan($wi , $flg) {
        // $this->fa->query("UPDATE sup_work_plan_supply_dev SET PRD_COMP_FLG = $flg WHERE WI = ?", [$wi]);
    }
    public function insertProductionActual($data) {
        $sql = "INSERT INTO production_actual 
                    (wi, line_cd, item_cd, plan_qty, act_qty, seq_no, shift_prd, manpower_no, prd_st_date, prd_st_time, prd_end_date, prd_end_time, 
                    lot_no, comp_flg, transfer_flg, del_flg, updated_date, prd_flg, close_lot_flg, avarage_eff, avarage_act_prd_time)
                VALUES ('{$data->wi}', '{$data->line_cd}', '{$data->item_cd}', {$data->plan}, {$data->actual}, {$data->seq}, '{$data->shift}', 
                    {$data->manpower}, '{$data->st_date}', '{$data->st_time}', '{$data->end_date}', '{$data->end_time}', '{$data->lot}', '{$data->comp_flg}', 
                    '1', '0', '$data->updated_date', '1', '2', 0, 0)";
        $this->fa->query($sql, $data);
    }

    public function getCurrentActual($wi) {
        $sql = "SELECT ISNULL(SUM(act_qty), 0) AS sum_qty FROM production_actual WHERE wi = '$wi'";
        $result = $this->fa->query($sql);
        return $result->row('sum_qty');
    }

    public function getProductionLot($lot_dt) {
        $_YEARS = ["J", "A", "B", "C", "D", "E", "F", "G", "H", "I"];
        $_MONTH = ["L", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K"];
    
        $dateTime = new DateTime($lot_dt);
    
        $hour = $dateTime->format('G');
    
        if ($hour <= 7) {
            $onlyDate = clone $dateTime;
            $onlyDate->sub(new DateInterval('P1D'));
            $dateTime = $onlyDate;
        }
    
        $D = $dateTime->format('d');
        $M = $dateTime->format('n');
        $Y = $dateTime->format('Y') % 10;
    
        return $_YEARS[$Y % 10] . $_MONTH[$M % 12] . $D;
    }
    

   public function getCurrentDateActual($line_cd) {
       $currentDate = date('Y-m-d H:i:s');
       $dellot =  $this->getProductionLot(date('Y-m-d', strtotime('-1 day', strtotime($currentDate))));
       $lot = $this->getProductionLot($currentDate);
            $sql = "SELECT
                    prad.pwi_id,
                    prad.wi_plan,
                    SUM ( prad.qty ) AS total_qty,
                    MIN ( prad.st_time ) AS start_time,
                    MAX ( prad.end_time ) AS end_time,
                    pedr.manpower,
                    spd.LINE_CD,                              
                    spd.ITEM_CD,
                    spd.QTY,
                    spd.PRD_COMP_FLG,
                    pwi.pwi_seq_no,
                    pwi.pwi_shift,
                    pwi.pwi_lot_no,
                    pwi.ind_row,
                    pa.id
                FROM
                    production_actual_detail prad
                    LEFT JOIN production_working_info pwi ON prad.pwi_id = pwi.pwi_id 
                    LEFT JOIN sup_work_plan_supply_dev spd ON pwi.ind_row = spd.IND_ROW
                    LEFT JOIN (
                    SELECT
                        pwi_id,
                        ISNULL(COUNT ( id ), 0) AS manpower
                    FROM
                        production_emp_detail_realtime 
                    GROUP BY
                        pwi_id
                    ) pedr ON prad.pwi_id = pedr.pwi_id 
                    LEFT JOIN production_actual pa ON prad.wi_plan = pa.wi AND prad.seq_no = pa.seq_no AND pwi.pwi_lot_no = pa.lot_no
                WHERE pwi.pwi_lot_no BETWEEN '$dellot' and '$lot'  AND pa.id IS NULL AND prad.line_cd = '$line_cd'
                GROUP BY
                    prad.pwi_id,
                    prad.wi_plan,
                    pedr.manpower,
                    spd.LINE_CD,
                    spd.ITEM_CD,
                    spd.QTY,
                    spd.PRD_COMP_FLG,
                    pwi.pwi_seq_no,
                    pwi.pwi_shift,
                    pwi.pwi_lot_no,
                    pwi.ind_row,
                    pa.id";

        $query = $this->fa->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return [];
    }
}