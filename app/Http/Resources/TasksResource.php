<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\CommentsResourceSimple;
use App\Http\Resources\UsersResourceSimple;

class TasksResource extends ResourceCollection
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
                'data' => [
                    'type' => 'tasks',
                    'id' => $item->id,
                    'attributes'=> [
                        'title' => $item->title,
                        'created' => $item->created_at->toDateTimeString(),
                        'updated' => $item->updated_at->toDateTimeString(),
                    ],
                    'relationships' => [
                        'assignee' => [
                            'data' => new UsersResourceSimple($item->assignee)
                        ],
                        'comments' => [
                            'data' => new CommentsResourceSimple($item->comments)
                        ]
                    ]
                ],
                'included' => [
                    new UsersResource($item->assignee),
                    new CommentsResource($item->comments)
                ]
            ];
        });
    }
}
