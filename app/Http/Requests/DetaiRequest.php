<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class DetaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    protected function prepareForValidation(): void
    {
        $dateFields = ['TGbatdau', 'TGketthuc'];
        $tiendoDates = ['Tgbatdaucv', 'Tgketthuccv'];
        foreach ($dateFields as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => $this->formatDate($this->$field),
                ]);
            }
        }
        if ($this->has('tiendo')) {
            $tiendo = $this->input('tiendo');
            foreach ($tiendo as $index => $item) {
                foreach ($tiendoDates as $dateField) {
                    if (!empty($item[$dateField])) {
                        $tiendo[$index][$dateField] = $this->formatDate($item[$dateField]);
                    }
                }
            }
            $this->merge([
                'tiendo' => $tiendo
            ]);
        }
    }
    private function formatDate($value)
    {
        try {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return $value;
        }
    }
    public function rules()
    {
        return [
            'id_dt' => 'nullable|integer',
            'loaidetai' => 'required|integer',
            'linhvuc' => 'required|integer',
            'hovaten' => 'required|string|max:255',
            'Donvi' => 'required|string|max:255',
            'Sodienthoai' => 'required|string|max:20',
            'Email' => 'required|email',
            'TGbatdau' => 'required|date_format:Y-m-d',
            'TGketthuc' => 'required|date_format:Y-m-d|after:TGbatdau',
            'Sogiotacgia' => 'required|numeric|min:0',
            'sothang' => 'required|numeric|min:0',
            'Trangthai' => 'required|string',

            'thanhvien' => 'nullable|array',
            'thanhvien.*.tenthanhvien' => 'required|string',
            'thanhvien.*.sogio' => 'required|numeric|min:0',

            'tiendo' => 'nullable|array',
            'tiendo.*.ndcongviec' => 'required|string',
            'tiendo.*.nguoithuchien' => 'required|string',
            'tiendo.*.thang' => 'required|string',
            'tiendo.*.Tgbatdaucv' => 'nullable|date_format:Y-m-d',
            'tiendo.*.Tgketthuccv' => 'nullable|date_format:Y-m-d|after_or_equal:tiendo.*.Tgbatdaucv',

            'tiendo.*.kinhphi' => 'nullable|array',
            'tiendo.*.kinhphi.*.noidungchi' => 'required|string',
            'tiendo.*.kinhphi.*.DVT' => 'required|string',
            'tiendo.*.kinhphi.*.Soluong' => 'required|numeric|min:1',
            'tiendo.*.kinhphi.*.dongia' => 'required|numeric|min:0',
            'tiendo.*.kinhphi.*.thanhtien' => 'required|numeric|min:0',
        ];
    }
}
