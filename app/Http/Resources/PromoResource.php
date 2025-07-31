<?php
    namespace App\Http\Resources;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    class PromoResource extends JsonResource
{
    public function toArray(Request $request): array

{
    return [
        'id' => $this->id_promo,
        'uraian' => $this->uraian,
        'tanggal' => $this->tanggal,
        'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}