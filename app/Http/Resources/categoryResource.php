<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class categoryResource extends JsonResource
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
////                'id'=>$this->id,
//                'category_reference_no'=>$this->category_reference_no,
//                'category_name'=>$this->category_name,
//                'coa_header'=>subCategoryAccountsResource::collection($this->header),
////->AccountsResource::collection($this->accounts),

                'id'=>$this->id,
                'coa_reference_no'=>$this->coa_reference_no,
                'coa_name'=>$this->coa_name,
            ];
    }
}
