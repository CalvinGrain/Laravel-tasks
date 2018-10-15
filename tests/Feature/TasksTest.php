<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    public function output($data)
    {
        fwrite(STDOUT, $data . "\n");
    }

    public function action($user_id, $method, $url, $data=[])
    {
        return $this->actingAs(\App\Users::find($user_id),'api')->json($method, $url, $data);
    }

    public function testTaskPost()
    {
        $response = $this->action(3,'post','api/tasks',[
            'assignee_id' => 1,
            'title' => 'Wake up neo!',
            'description' => 'Follow the white rabbit!',
        ]);

        $this->assertContains('OK',$response->getContent());
        $response->assertStatus(201);

        $response = $this->action(2,'post','api/tasks',[
            'assignee_id' => 1,
            'title' => 'Visit Oracle',
            'description' => 'Checking if you are the one',
        ]);

        $this->assertContains('OK',$response->getContent());
        $response->assertStatus(201);
    }

    public function testTaskPostValidationFail()
    {
        $response = $this->action(3,'post','api/tasks',[
            'assignee_id' => 1,
            'title' => 'Whatever'
        ]);

        $response->assertStatus(400);
    }

    public function testTasksGet()
    {
        $response = $this->action(1,'get','api');
        $response->assertStatus(200);
    }

    public function testTasksGetFilterAssignee()
    {
        $response = $this->action(1,'get','api/?filter[assignee_id]=1');
        $response->assertStatus(200);
        $data = json_decode($response->getContent());

        foreach ($data->data as $item)
        {
            if($item->data->relationships->assignee->data->id == 1) $this->assertTrue(TRUE);
            else $this->assertTrue(FALSE);
        }
    }

    public function testTasksGetFilterTitle()
    {
        $response = $this->action(1,'get','api/?filter[title]=Wake');
        $response->assertStatus(200);
        $data = json_decode($response->getContent());

        foreach ($data->data as $item)
        {
            if($item->data->attributes->title == 'Wake up neo!') $this->assertTrue(TRUE);
            else $this->assertTrue(FALSE);
        }
    }

    public function testCommentPost()
    {
        $response = $this->action(1,'post','api/tasks/1/comments',[
            'author_id' => 1,
            'comment' => 'What?'
        ]);

        $this->assertContains('OK',$response->getContent());
        $response->assertStatus(201);

        $response = $this->action(4,'post','api/tasks/2/comments',[
            'author_id' => 4,
            'comment' => 'You are not the one!'
        ]);

        $this->assertContains('OK',$response->getContent());
        $response->assertStatus(201);

        $response = $this->action(5,'post','api/tasks/2/comments',[
            'author_id' => 5,
            'comment' => 'LOL'
        ]);

        $this->assertContains('OK',$response->getContent());
        $response->assertStatus(201);
    }
}
