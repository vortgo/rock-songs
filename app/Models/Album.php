<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Album
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string $cover
 * @property int $band_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album whereBandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Album whereYear($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Band $band
 */
class Album extends Model
{
    public $timestamps = true;

    public function band()
    {
        return $this->belongsTo(Band::class);
    }

    public function getCover()
    {
        if (strpos($this->cover, 'http') === false) {
            return 'http://www.heavy-music.ru/' . $this->cover;
        }
        return $this->cover;
    }
}
