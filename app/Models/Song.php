<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Song
 *
 * @property int $id
 * @property string $name
 * @property int $album_is
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereAlbumIs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $album_id
 * @property string $download_url
 * @property string|null $size
 * @property string|null $duration
 * @property int $number
 * @property-read \App\Models\Album $album
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereDownloadUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Song whereSize($value)
 */
class Song extends Model
{
    use ElasticquentTrait;

    protected $mappingProperties = [
        'id'    => [
            'type' => 'integer'
        ],
        'song'  => [
            'type' => 'string',
        ],
        'album' => [
            'type' => 'string',
        ],
        'band'  => [
            'type' => 'string',
        ],
        'year'  => [
            'type' => 'string',
        ],
    ];

    function getIndexDocumentData()
    {
        return array(
            'id'    => $this->id,
            'song'  => $this->name,
            'album' => $this->album->name,
            'band'  => $this->album->band->name,
            'year'  => $this->album->year
        );
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
