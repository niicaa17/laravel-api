<?php
    namespace App\Http\Resources;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    class ArtikelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
    return [
        'id_artikel' => $this->id_artikel,

            'judul' => $this->judul,
            'isi' => $this->isi,
            'gambar' => $this->gambar ? asset('storage/artikels/' . $this->gambar) : null,
            'created_at' => $this->created_at->toDateTimeString(),
    
        ];
    }
}