<?php

namespace App\Http\Controllers\MySearch;

use App\Libs\Error\ErrorCode;
use App\Models\MySearch\OilUser;
use App\Services\Search\Sarticle;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\MySearch\Article as ArticleModel;
use GuzzleHttp\Client as GuzzleClient;

class Cindex extends Controller
{
    
    /**
     * @var Sarticle
     */
    private $sArticle;
    
    public function __construct(Sarticle $sArticle)
    {
        $this->sArticle = $sArticle;
    }

    /**
     * @desc 根据id 从es中获取一个数据
     * @param Request $request
     * @param   string $keyword
     * @return json
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(Request $request)
    {
        $input = $request->input();
        $keyword = empty($input['keyword']) ? '' : $input['keyword'];
        try {
            $client = new GuzzleClient([
                'base_uri' => 'http://127.0.0.1:9200',
            ]);
            $responseArr = [
                'status'  => ErrorCode::NO_ERROR,
                'message' => '初始化message！',
            ];
            $docIndexName = 'test1_index';
            $docIndexType = 'test1';
            $queryUri = sprintf('/%s/%s/_search',$docIndexName, $docIndexType);
            $queryUri = $queryUri.'?q=content:' . $keyword;
            $response = $client->request('get', $queryUri);
            $body = $response->getBody()->getContents();
        } catch (\Exception $e ) {
            return response()->json([
                'status'=>$e->getCode(),
                'message'=>$e->getMessage(),
            ]);
        }
        $responseArr['data'] = json_decode($body);
        if ($response->getStatusCode() !== 200) {
            $responseArr['status']  = $response->getStatusCode();
            $responseArr['message'] = $response->getReasonPhrase();
        } else {
            $responseArr['status']  = 1;
            $responseArr['message'] = '查询成功！';
        }
        
        return response()->json($responseArr);
    }
    
    /**
     * @desc 用户保存文章内容
     * @param Request $request
     * @return json
     */
    public function store(Request $request)
    {
        $input       = $request->input();
        $result      = ArticleModel::create($input);
        $responseArr = [
            'status'  => ErrorCode::NO_ERROR,
            'message' => '',
        ];
        if ($result instanceof ArticleModel) {
            $responseArr['message'] = '新增内容成功！';
            // 加入到es文档中建立索引
            $result = $this->sArticle->pushData([
                'data' => $result->toArray(),
            ]);
            if ($result != 1) {
                $responseArr['status']  = ErrorCode::NORMAL_ERROR;
                $responseArr['message'] = $result['message'];
            }
        } else {
            $responseArr['message'] = '新增内容失败！';
        }

        return response()->json($responseArr);
    }
    
    /**
     * @desc: 入口方法
     * @author:Samuel Su(suhanyu)
     * @date:17/6/26
     * @param void
     * @return mixed
     */
    public function test2()
    {
        return [23];
        
        $count = 0;
        for ( $i = 0; $i <= 21; $i++ ) {
            $offset = 1000 * $i;
            echo $offset . PHP_EOL;
            $sql = 'select * from users limit ' . $offset . ',1000';
            $users = DB::select($sql);
            foreach ( $users as $k => $row ) {
                if ( $row->dealer_name != trim($row->dealer_name) ) {
                    $count++;
                }
            }
            sleep(0.5);
        }
        
        return $count;
    }
}
