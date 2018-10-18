<?php

namespace App;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use ElasticquentTrait;

    protected $primaryKey = 'provider_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','name', 'street_name','town','county','region',
        'postcode','type','description','balance',
        'historic_county','open_hour','close_hour','prices','keywords', 'visits'
    ];

    protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ]
            ],
            'analyzer' => [
                'default' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                    ],
                ],
            ],
        ],
    ];

    protected $mappingProperties = array(
        'title' => array(
            'type' => 'string',
            'analyzer' => 'standard'
        )
    );

    function getIndexName()
    {
        return 'providers_index';
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}