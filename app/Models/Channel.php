<?php

namespace App\Models;


use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


use Illuminate\Support\Str;

use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Channel extends ModelBase implements HasMedia
{

   use InteractsWithMedia, HasFactory;

    protected $guarded = [];


    public function user()
    {

        return $this->belongsTo(User::class);

    }


    public function image() {

        if($this->media()->first()) {
            return $this->media->first()->getFullUrl('thumb');
        }


        return null;
    }

    public function editable() {
        if(! auth()->check()) return false;
        return $this->user_id == auth()->user()->id;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }



}
