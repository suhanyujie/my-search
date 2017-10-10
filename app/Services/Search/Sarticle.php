<?php
/**
 * Created by PhpStorm.
 * User: suhanyu
 * Date: 17/10/6
 * Time: 下午3:44
 */

namespace App\Services\Search;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Sarticle
 * @package App\Services\Search
 */
class Sarticle
{
    /**
     * @desc 每新增一个文章数据，就将其插入到es的文档中，建立索引
     * @param array $paramArr
     * @return bool
     */
    public function pushData($paramArr)
    {
        $options = [
            'uri'=>'/test1_index/test1/',
            'data'=>[],
        ];
        $options = array_merge($options, $paramArr);
        extract($options);
        $client = new GuzzleClient([
            'base_uri' => env('ELASTIC_SEARCH_URL', 'http://127.0.0.1:9200'),
        ]);
        $response = $client->request('PUT', $uri . $data['id'], ['body' => json_encode($data)]);
        if ( $response->getStatusCode() !== 200 ) {
            return false;
        } else {
            return true;
        }
    }
}