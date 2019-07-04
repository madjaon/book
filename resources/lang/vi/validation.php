<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'        => 'The :attribute must be accepted.',
    'active_url'      => 'The :attribute is not a valid URL.',
    'after'           => 'The :attribute must be a date after :date.',
    'after_or_equal'  => 'The :attribute must be a date after or equal to :date.',
    'alpha'           => 'The :attribute may only contain letters.',
    'alpha_dash'      => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'       => 'The :attribute may only contain letters and numbers.',
    'array'           => 'The :attribute must be an array.',
    'before'          => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between'         => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'        => 'The :attribute field must be true or false.',
    'confirmed'      => 'Trường :attribute xác nhận không khớp.',
    'date'           => 'The :attribute is not a valid date.',
    'date_format'    => 'The :attribute does not match the format :format.',
    'different'      => 'The :attribute and :other must be different.',
    'digits'         => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions'     => 'The :attribute has invalid image dimensions.',
    'distinct'       => 'The :attribute field has a duplicate value.',
    'email'          => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'exists'         => 'The selected :attribute is invalid.',
    'file'           => 'The :attribute must be a file.',
    'filled'         => 'The :attribute field must have a value.',
    'image'          => 'The :attribute must be an image.',
    'in'             => 'The selected :attribute is invalid.',
    'in_array'       => 'The :attribute field does not exist in :other.',
    'integer'        => 'Trường :attribute phải là số nguyên.',
    'ip'             => 'The :attribute must be a valid IP address.',
    'json'           => 'The :attribute must be a valid JSON string.',
    'max'            => [
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'file'    => 'File :attribute không được lớn hơn :max kilobytes.',
        'string'  => 'Trường :attribute không được lớn hơn :max ký tự.',
        'array'   => 'Mảng :attribute không được nhiều hơn :max phần tử.',
    ],
    'mimes'     => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min'       => [
        'numeric' => 'Trường :attribute không được nhỏ hơn :min.',
        'file'    => 'File :attribute không được nhỏ hơn :min kilobytes.',
        'string'  => 'Trường :attribute không được nhỏ hơn :min ký tự.',
        'array'   => 'Mảng :attribute không được ít hơn :min phần tử.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'Trường :attribute phải là số.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'Trường :attribute là yêu cầu bắt buộc.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'Trường :attribute và :other phải khớp.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'   => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique'   => 'Trường :attribute đã được sử dụng.',
    'uploaded' => 'The :attribute failed to upload.',
    'url'      => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    'nameRequired'          => 'Bắt buộc phải nhập tiêu đề.',
    'nameMax'               => 'Tiêu đề không được quá :values ký tự.',
    'slugRequired'          => 'Bắt buộc phải nhập đường dẫn.',
    'slugMax'               => 'Đường dẫn không được quá :values ký tự.',
    'slugUnique'            => 'Đường dẫn đã được sử dụng.',
    'summaryMax'            => 'Mô tả ngắn không được quá :values ký tự.',
    'imageMax'              => 'Đường dẫn ảnh đại diện không được quá :values ký tự.',
    'metaTitleMax'          => 'Thẻ Meta Title không được quá :values ký tự.',
    'metaKeywordMax'        => 'Thẻ Meta Keyword không được quá :values ký tự.',
    'metaDescriptionMax'    => 'Thẻ Meta Description không được quá :values ký tự.',
    'metaImageMax'          => 'Thẻ Meta Image không được quá :values ký tự.',
    'typeMainIdRequired'    => 'Bắt buộc phải chọn thể loại chính (primary).',
    'positionRequired'      => 'Bắt buộc phải chọn vị trí.',

    'fullnameRequired'      => 'Bắt buộc phải nhập họ tên.',
    'fullnameMax'           => 'Họ tên không được quá :values ký tự.',
    'emailRequired'         => 'Bắt buộc phải nhập địa chỉ Email.',
    'emailFormat'           => 'Địa chỉ Email phải hợp lệ.',
    'emailMax'              => 'Địa chỉ Email không được quá :values ký tự.',
    'msgRequired'           => 'Bắt buộc phải nhập tin nhắn.',
    'msgMax'                => 'Tin nhắn không được quá :values ký tự.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
