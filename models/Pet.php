<?php namespace GoodNello\Pets\Models;

use Model;

/**
 * Pet Model
 */
class Pet extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'goodnello_pets_pets';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */

    public $belongsTo = [
        'user' => ['RainLab\User\Models\User']
    ];

}
