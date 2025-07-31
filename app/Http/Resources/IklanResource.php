<?php
    namespace App\Http\Resources;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    class IklanResource extends JsonResource
{
    public function toArray(Request $request): array
{
    return [
            'id' => $this->id_iklan,
            'uraian' => $this->uraian,
            'gambar' => $this->gambar ? asset('storage/iklans/' . $this->gambar) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}