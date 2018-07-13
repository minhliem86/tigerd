<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public $table = 'products';

    protected $guarded = ['id'];


    public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Attribute','product_attribute','product_id', 'attribute_id');
    }

    public function values()
    {
        return $this->belongsToMany('App\Models\AttributeValue', 'product_value', 'product_id', 'attribute_value_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\OrderProduct', 'order_products', 'product_id', 'order_id')->withPivot('quantity','unit_price')->withTimestamps();
    }
    public function meta_configs()
    {
        return $this->morphMany('App\Models\MetaConfiguration', 'metable');
    }

    public function photos()
    {
        return $this->morphMany('App\Models\Photo','photoable');
    }

    public function product_links()
    {
        return $this->hasMany('App\Models\ProductLink');
    }

    public function testimonials()
    {
        return $this->hasMany('App\Models\CustomerIdea', 'product_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($product){
            if(!$product->photos->isEmpty()){
                foreach($product->photos as $item_photo){
                    \App\Models\Photo::destroy($item_photo->id);
                }
            }

            $product->meta_configs()->delete();
            $obj_att_value = \App\Models\AttributeValue::where('product_id',$product->id)->get();
            if(!$obj_att_value->isEmpty()){
                foreach($obj_att_value as $each_item){
                    $each_item->delete();
                }
            }
        });
    }
}
