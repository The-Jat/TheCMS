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

    'accepted' => ':attribute doit être accepté.',
    'accepted_if' => ':attribute doit être accepté lorsque :other vaut :value.',
    'active_url' => ':attribute est pas une URL valide.',
    'after' => 'Le :attribute doit être une date postérieure à :date.',
    'after_or_equal' => 'Le :attribute doit être une date postérieure ou égale à :date.',
    'alpha' => 'Le :attribute ne doit contenir que des lettres.',
    'alpha_dash' => 'Le :attribute ne doit contenir que des lettres, des chiffres, des tirets et des traits de soulignement.',
    'alpha_num' => 'Le :attribute ne doit contenir que des lettres et des chiffres.',
    'array' => 'Le :attribute doit être un tableau.',
    'before' => 'Le :attribute doit être une date avant :date.',
    'before_or_equal' => 'Le :attribute doit être une date antérieure ou égale à :date.',
    'between' => [
        'array' => 'Le :attribute doit avoir entre :min et :max éléments.',
        'file' => 'Le :attribute doit être compris entre :min et :max kilo-octets.',
        'numeric' => 'Le :attribute doit être compris entre :min et :max.',
        'string' => 'Le :attribute doit être compris entre :min et :max caractères.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => 'Le :attribute n\"est pas une date valide.',
    'date_equals' => 'Le :attribute doit être une date égale à :date.',
    'date_format' => 'Le :attribute ne correspond pas au format :format.',
    'declined' => 'Le :attribute doit être refusé.',
    'declined_if' => 'Le :attribute doit être refusé lorsque :other vaut :value.',
    'different' => 'Le :attribute et :other doivent être différents.',
    'digits' => 'Le :attribute doit être :digits chiffres.',
    'digits_between' => 'Le :attribute doit être compris entre :min et :max chiffres.',
    'dimensions' => 'L\":attribute a des dimensions d\"image invalides.',
    'distinct' => 'Le champ :attribute a une valeur en double.',
    'doesnt_start_with' => 'Le :attribute ne peut pas commencer par l\"un des éléments following: :values.',
    'email' => 'Le :attribute doit être une adresse e-mail valide.',
    'ends_with' => 'Le :attribute doit se terminer par l\"un des éléments following : :values.',
    'enum' => 'L\"attribute sélectionné n\"est pas valide.',
    'exists' => 'L\"attribute sélectionné n\"est pas valide.',
    'file' => 'Le :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
        'array' => 'Le :attribute doit avoir plus de :value éléments.',
        'file' => 'Le :attribute doit être supérieur à :value kilo-octets.',
        'numeric' => 'Le :attribut doit être supérieur à :valeur.',
        'string' => 'Le :attribut doit être supérieur à :value caractères.',
    ],
    'gte' => [
        'array' => 'Le :attribute doit avoir :value articles ou plus.',
        'file' => 'Le :attribute doit être supérieur ou égal à :value kilo-octets.',
        'numeric' => 'Le :attribute doit être supérieur ou égal à :value.',
        'string' => 'Le :attribute doit être supérieur ou égal à :value caractères.',
    ],
    'image' => 'Le :attribute Doit être une image.',
    'in' => 'Le choisie :attribute est invalide.',
    'in_array' => 'Le :attribute le champ n\'existe pas dans :other.',
    'integer' => 'Le :attribute must be an integer.',
    'ip' => 'Le :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le :attribute doit être une chaîne JSON valide.',
    'lt' => [
        'array' => 'Le :attribute doit avoir moins de :value éléments.',
        'file' => 'Le :attribute doit être inférieur à :value kilo-octets.',
        'numeric' => 'Le :attribute doit être inférieur à :value.',
        'string' => 'Le :attribute doit être inférieur à :value caractères.',
    ],
    'lte' => [
        'array' => 'Le :attribute ne doit pas avoir plus de :value de valeur.',
        'file' => 'Le :attribute doit être inférieur ou égal à :value kilo-octets.',
        'numeric' => 'Le :attribute doit être inférieur ou égal à :value.',
        'string' => 'Le :attribute doit être inférieur ou égal à :value personnages.',
    ],
    'mac_address' => 'Le :attribute doit être une adresse MAC valide.',
    'max' => [
        'array' => 'Le :attribute ne doit pas avoir plus de :max choses.',
        'file' => 'Le :attribute ne doit pas être supérieur à :max kilo-octets.',
        'numeric' => 'Le :attribute ne doit pas être supérieur à :max.',
        'string' => 'Le :attribute ne doit pas être supérieur à :max personnages.',
    ],
    'mimes' => 'Le :attribute doit être un fichier de type: :values.',
    'mimetypes' => 'Le :attribute doit être un fichier de type: :values.',
    'min' => [
        'array' => 'Le :attribute doit avoir au moins :min choses.',
        'file' => 'Le :attribute doit être au moins :min kilo-octets.',
        'numeric' => 'Le :attribute doit être au moins :min.',
        'string' => 'Le :attribute doit être au moins :min personnages.',
    ],
    'multiple_of' => 'Le :attribute doit être un multiple de :value.',
    'not_in' => 'La sélection :attribute est invalide.',
    'not_regex' => 'Le :attribute le format n\'est pas valide.',
    'numeric' => 'Le :attribute doit être un nombre.',
    'password' => [
        'letters' => 'Le :attribute doit contenir au moins une lettre.',
        'mixed' => 'Le :attribute doit contenir au moins une majuscule et une minuscule.',
        'numbers' => 'Le :attribute doit contenir au moins un chiffre.',
        'symbols' => 'Le :attribute doit contenir au moins un symbole.',
        'uncompromised' => 'Le donné :attribute est apparu dans une fuite de données. Veuillez choisir un autre :attribute.',
    ],
    'present' => 'Le :attribute le champ doit être présent.',
    'prohibited' => 'Le :attribute le terrain est interdit.',
    'prohibited_if' => 'Le :attribute champ est interdit lorsque :other est :value.',
    'prohibited_unless' => 'Le :attribute champ est interdit sauf si :other est dans :values.',
    'prohibits' => 'Le :attribute champ interdit :other d\'être présent.',
    'regex' => 'Le :attribute le format n\'est pas valide.',
    'required' => 'Le :attribute Champ requis.',
    'required_array_keys' => 'Le :attribute le champ doit contenir des entrées pour: :values.',
    'required_if' => 'Le :attribute champ est obligatoire lorsque :other est :value.',
    'required_unless' => 'Le :attribute champ est obligatoire sauf si :other est dans :values.',
    'required_with' => 'Le :attribute champ est obligatoire lorsque :values est présent.',
    'required_with_all' => 'Le :attribute champ est obligatoire lorsque :values sont présents.',
    'required_without' => 'Le :attribute champ est obligatoire lorsque :values n\'est pas présent.',
    'required_without_all' => 'Le :attribute champ est obligatoire lorsqu\'aucun des :values sont présents.',
    'same' => 'Le :attribute et :other doit correspondre.',
    'size' => [
        'array' => 'Le :attribute doit contenir :size articles.',
        'file' => 'Le :attribute doit être :size kilo-octets.',
        'numeric' => 'Le :attribute doit être :size.',
        'string' => 'Le :attribute doit être :size personnages.',
    ],
    'starts_with' => 'Le :attribute doit commencer par l\'un des éléments suivants: :values.',
    'string' => 'Le :attribute doit être une chaîne.',
    'timezone' => 'Le :attribute doit être un fuseau horaire valide.',
    'unique' => 'Le :attribute a déjà été pris.',
    'uploaded' => 'Le :attribute échec du téléchargement.',
    'url' => 'Le :attribute doit être une URL valide.',
    'uuid' => 'Le :attribute doit être un UUID valide.',

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

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
