<?php

namespace App\Http\Requests\Web;

use App\Enums\GlobalConstant;
use App\Traits\ResponseHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property string $image
 */
class ChattingRequest extends FormRequest
{
    use ResponseHandler;
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => 'required_without_all:file,image',
            'image.*' => 'image|max:2048|mimes:'.str_replace('.', '', implode(',', GlobalConstant::IMAGE_EXTENSION)),
            'file.*' => 'file|max:2048|mimes:'.str_replace('.', '', implode(',', GlobalConstant::DOCUMENT_EXTENSION)),
        ];

    }

    public function messages(): array
    {
        return [
            'required_without_all' => translate('type_something').'!',
            'image.mimes' => translate('the_image_format_is_not_supported').' '.translate('supported_format_are').' '.str_replace('.', '', implode(',', GlobalConstant::IMAGE_EXTENSION)),
            'image.max' => translate('image_maximum_size_') . MAXIMUM_IMAGE_UPLOAD_SIZE,
            'file.mimes' => translate('the_file_format_is_not_supported').' '.translate('supported_format_are').' '.str_replace('.', '', implode(',', GlobalConstant::DOCUMENT_EXTENSION)),
            'file.max' => translate('file_maximum_size_') . MAXIMUM_IMAGE_UPLOAD_SIZE,
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $this->errorProcessor($validator)]));
    }

}
