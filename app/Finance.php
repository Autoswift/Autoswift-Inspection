<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
	protected $table ='finances';
    protected $fillable = ['chachees_number','chachees_number_photo','stamp_show','photo','selfie','approve_photo','user_id','reference_no','application_no','mobile_no','valuation_by','staff_name','financer_representative','place_of_valuation','report_date','make_model','inspection_date','registration_date','engine_number','color','seating_capacity','registerd_owner','financed_by','laden_wt','hypothecation','unladen_wt','tyres','owner_in_policy','fule_used','policy_no','mm_reading','validity','battery','policy_type','radiator','sum_insured','ac','tax_paid','steereo','vechile_condition','power_steering','major_accidentented','power_steering','major_accidentented','power_window','general_comment','total_amount','amount_paid','remaining_amount','amount','paid_person','paid_date','fair_amount','registration_no','air_bag','owner_serial_number','cube_capacity','left_tyer_quantity','left_tyer_company','left_quality','right_tyer_quantity','right_tyer_company','right_quality','c_engine_condition','c_cooling_system','c_suspension_system','c_electrical_system','c_wheel','c_chassis','c_cabin','c_condition_of_interiors','c_glass','c_paint','c_damage','location_address','axis','process','status','form_pdf','pdf_file','mobile_data','duplicate_reason','duplicate_entry','notice','videos'];
    protected $casts = [
    'created_at' => 'datetime:Y-m-d h:i:s',
    'updated_at' => 'datetime:Y-m-d h:i:s',
    ];
    public function valuation()
    {
        return $this->hasOne(Valuation::class, 'id','valuation_by');
    }
    public function declaration()
    {
        return $this->hasOne(Declaration::class, 'id','notice');
    }


}
