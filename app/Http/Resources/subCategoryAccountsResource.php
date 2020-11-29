<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class subCategoryAccountsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
//                'id'=>$this->id,
                'header_reference_no'=>$this->header_reference_no,
                'header_name'=>$this->header_name,
                'coa'=>accountsResource::collection($this->coa),
            ];
    }
}
