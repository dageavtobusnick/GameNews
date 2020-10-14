<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use http\Env;
use Illuminate\Http\Request;
use ATehnix\VkClient\Client;
use Illuminate\Support\Facades\Config;

class PostsController extends Controller
{
    public function AutoCreatePost(){
        $posts=$this->GetPosts();
            foreach ($posts as $post){
                $model=new Posts();
                $model->postId=$post['id'];
                $model->sourceId=$post['from_id'];
                $model->hostId=$post['owner_id'];
                if(array_key_exists('signer_id',$posts))
                $model->authorId=$post['signer_id'];
                $model->date=$post['date'];
                $model->text=$post['text'];
                if(array_key_exists('attachments',$posts))
                $model->attachments=json_encode($post['attachments'],JSON_UNESCAPED_UNICODE);
                if(array_key_exists('copyright',$posts))
                $model->copyright=$post['copyright'];
                $model->save();
        }
        return $this->GetPosts()[0]['id'];
    }

    public function GetPosts(){
        $vk = new Client();
        $count=10;
        $vk->setDefaultToken(Config::get('constants.vkTocken'));
        $responseGroup1 = $vk->request('groups.getById',array(
            'group_ids' => 'urfumemes'));
        $response = $vk->request('wall.get',array('owner_id' => -$responseGroup1['response'][0]['id'],'offset'=>1,'count'=>$count));
        return $response['response']['items'];
    }
}
