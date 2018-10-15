<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\UsersResource;

class CommentsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->map(function ($item) {
            return [
                'type'=>'comments',
                'id' => $item->id,
                'attributes'=> [
                    'body' => $item->comment,
                    'created' => $item->created_at->toDateTimeString(),
                    'updated' => $item->updated_at->toDateTimeString()
                ],
                'relationships' => [
                    'author' => new UsersResource($item->author)
                ]
            ];
        });
    }
}
