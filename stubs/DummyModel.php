<?php

namespace DummyAppNamespace;

class DummyModel extends \Eloquent
{
    /**
     * @type string
     */
    protected $table = "DummyPluralSlug";
    
    /**
     * @type array
     */
    protected $guarded = ['id'];
    
    /**
     * @type array
     */
    protected $fillable;
    
    /**
     * @type array
     */
    protected $casts = [];
    
    /**
     * @type array
     */
    protected $dates = [];
    
    /**
     * @type bool
     */
    public $timestamps;
}
