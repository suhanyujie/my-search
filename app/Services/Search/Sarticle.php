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
     * @return array
     */
    public function pushData($paramArr)
    {
        $options = [
            'docIndexName' => 'test1_index',
            'docIndexType' => 'test1',
            'data'         => [],
        ];
        $options = array_merge($options, $paramArr);
        extract($options);
        $esUri = sprintf("/%s/%s/%d", $options['docIndexName'], $options['docIndexType'],$options['data']['id']);
        $bodyStr = json_encode($options['data'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        try{
            $client = new GuzzleClient([
                'base_uri' => env('ELASTIC_SEARCH_URL', 'http://127.0.0.1:9200'),
            ]);
            $response = $client->request('PUT', $esUri, ['body' =>$bodyStr ]);
            if ( $response->getStatusCode() !== 200 ) {
                return ['status'=>200138,'message'=>'请求的返回httpCode为'.$response->getStatusCode()];
            } else {
                return ['status'=>1,'message'=>'加入es成功！'];
            }
        }catch (\Exception $e) {
            return ['status'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }
}
