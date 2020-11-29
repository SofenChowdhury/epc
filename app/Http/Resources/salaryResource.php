<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class salaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'basic_percentage' =>$this->basic_percentage,
            'basic'=>$this->basic,
            'medical_percentage' =>$this->medical_percentage,
            'medical' => $this->medical,
            'provident_fund_percentage' =>$this->provident_fund_percentage,
            'provident_fund' =>$this->provident_fund,
            'conveyance' =>$this->conveyance,
            'tax_amount' =>$this->tax_amount,
            'tax_payable' =>$this->tax_payable,
            'previous_salary' =>$this->total_salary,
        ];
    }
}
