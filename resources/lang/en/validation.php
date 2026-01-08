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

    'accepted' => '必須接受 :attribute。',
    'active_url' => ':attribute 不是有效的 URL。',
    'after' => ':attribute 必須是 :date 之後的日期。',
    'after_or_equal' => ':attribute 必須是 :date 之後或等於 :date 的日期。',
    'alpha' => ':attribute 只能包含字母。',
    'alpha_dash' => ':attribute 只能包含字母、數字與連字號。',
    'alpha_num' => ':attribute 只能包含字母與數字。',
    'array' => ':attribute 必須是陣列。',
    'before' => ':attribute 必須是 :date 之前的日期。',
    'before_or_equal' => ':attribute 必須是 :date 之前或等於 :date 的日期。',
    'between' => [
        'numeric' => ':attribute 必須介於 :min 到 :max 之間。',
        'file' => ':attribute 必須介於 :min 到 :max KB 之間。',
        'string' => ':attribute 必須介於 :min 到 :max 個字元之間。',
        'array' => ':attribute 必須包含 :min 到 :max 個項目。',
    ],
    'boolean' => ':attribute 欄位必須為 true 或 false。',
    'confirmed' => ':attribute 的確認欄位不一致。',
    'date' => ':attribute 不是有效的日期。',
    'date_format' => ':attribute 不符合格式 :format。',
    'different' => ':attribute 與 :other 必須不同。',
    'digits' => ':attribute 必須是 :digits 位數。',
    'digits_between' => ':attribute 必須介於 :min 到 :max 位數之間。',
    'dimensions' => ':attribute 的圖片尺寸無效。',
    'distinct' => ':attribute 欄位有重複的值。',
    'email' => ':attribute 必須是有效的電子郵件地址。',
    'exists' => '所選的 :attribute 無效。',
    'file' => ':attribute 必須是檔案。',
    'filled' => ':attribute 欄位為必填。',
    'image' => ':attribute 必須是圖片。',
    'in' => '所選的 :attribute 無效。',
    'in_array' => ':attribute 欄位不存在於 :other 中。',
    'integer' => ':attribute 必須是整數。',
    'ip' => ':attribute 必須是有效的 IP 位址。',
    'json' => ':attribute 必須是有效的 JSON 字串。',
    'max' => [
        'numeric' => ':attribute 不得大於 :max。',
        'file' => ':attribute 不得大於 :max KB。',
        'string' => ':attribute 不得大於 :max 個字元。',
        'array' => ':attribute 不得超過 :max 個項目。',
    ],
    'mimes' => ':attribute 必須為以下類型的檔案：:values。',
    'mimetypes' => ':attribute 必須為以下類型的檔案：:values。',
    'min' => [
        'numeric' => ':attribute 至少必須為 :min。',
        'file' => ':attribute 至少必須為 :min KB。',
        'string' => ':attribute 至少必須為 :min 個字元。',
        'array' => ':attribute 至少必須包含 :min 個項目。',
    ],
    'not_in' => '所選的 :attribute 無效。',
    'numeric' => ':attribute 必須是數字。',
    'present' => ':attribute 欄位必須存在。',
    'regex' => ':attribute 格式無效。',
    'required' => ':attribute 欄位為必填。',
    'required_if' => '當 :other 為 :value 時，:attribute 欄位為必填。',
    'required_unless' => '除非 :other 在 :values 之中，否則 :attribute 欄位為必填。',
    'required_with' => '當 :values 存在時，:attribute 欄位為必填。',
    'required_with_all' => '當 :values 存在時，:attribute 欄位為必填。',
    'required_without' => '當 :values 不存在時，:attribute 欄位為必填。',
    'required_without_all' => '當 :values 都不存在時，:attribute 欄位為必填。',
    'same' => ':attribute 與 :other 必須一致。',
    'size' => [
        'numeric' => ':attribute 必須是 :size。',
        'file' => ':attribute 必須是 :size KB。',
        'string' => ':attribute 必須是 :size 個字元。',
        'array' => ':attribute 必須包含 :size 個項目。',
    ],
    'string' => ':attribute 必須是字串。',
    'timezone' => ':attribute 必須是有效的時區。',
    'unique' => ':attribute 已被使用。',
    'uploaded' => ':attribute 上傳失敗。',
    'url' => ':attribute 格式無效。',

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

    // Internal validation logic for Pterodactyl
    'internal' => [
        'variable_value' => ':env 變數',
        'invalid_password' => '此帳號的密碼不正確。',
    ],
];
