<?php

namespace App\Http\Controllers\phpsdk\test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\phpsdk\serviceIMPL\RemoteSignServiceImpl;
use App\Http\Controllers\phpsdk\common\Receiver;
use App\Http\Controllers\phpsdk\common\Helper as helper;
use App\Http\Controllers\phpsdk\common\SDKClient;
use App\Http\Controllers\phpsdk\common\Util;
use Illuminate\Support\Facades\Storage;


class RemoteSignTest extends Controller
{
/* IMPORTANT : READ ME

		login to https://cloud.qiyuesuo.me/company/apisetting
		setting the whitelist to your webserver!!!!!!

		for $results returned from qys please refer to http://open.qiyuesuo.com/document/2323093682498781193 for debugging

		this test function demonstrated 4 features of the platform
		In practice, you should seperate those features into different functions

		The flow of the functions:
		 uploading the local contract to QYS server ->returned documentId,
		 which you should store in db. But for testing purpose it will be stored in $documentIdGenerated

		 the 2nd feature is sign by platform, you should optain sealId and set signing location

		 THe 3rd feature is sign by user, you should have collected user info and their sealImageBase64 image for signiture to use.

		 The 4th feature contract checking, where it will return a url to their site to see

*/
	public function test() {
		//refer to ../common/Util.phpsdk

		$url = Util::url;
		$accessKey = Util::accessKey;
		$accessSecret = Util::accessSecret;

		$SDk = new SDKClient($accessKey, $accessSecret, $url);
		$remoteSignServiceImpl = new RemoteSignServiceImpl($SDk);

		//***********************************************************************1.1 由本地PDF文件创建
		//Part 1:  Upload Document to server and obtain documentId
		/*
		potential return
		响应码		描述
		0				请求成功 success
		1001		请求失败 fail (might be IP whitelist issue)
		1005		无效的请求参数 (invalid arguement)
		*/
		$file_name = '/3.pdf';
		$a1 = helper::get_millistime();

		//hardcoded for 3.pdf
		$file_name= storage_path() . '/app/3.pdf';


		$post_data = array(
		    "subject" => "xushuaiRemote文件创建", //合同主题 subject of the contract
		    "expireTime" => "2017-08-08",//合同过期时间；过期未结束签署，则作废，不传该参数则默认30天后过期。 expiretime
		    "docName" => "languageRemote",//合同文件名称 contract name
			//合同文件 local file
			"file" =>  new \CURLFile(realpath($file_name))

			//
		);
		$result =  $remoteSignServiceImpl->createByLocal($post_data);
		$a2 = helper::get_millistime();
		$a3 = $a2-$a1;
		print_r($result);
		print_r("**************耗时 time spent：".$a3); //time spent
		print_r("<br>");


/*important this is for testing purpose, this is the returned id from the above generation, you should store this id in db */
		$documentIdGenerated = $result['documentId'];



		//***********************************************************************2.1 运营方签署
		/*
		 * 指定坐标位置签署
		 * --------------------------------------------------------------
		 * 平台签署,带签名外观
		 * --------------------------------------------------------------
		 */
//part 2, signing by platform

/*
potential return
0	请求成功		success
1001	请求失败 fail (might be IP whitelist issue)
1005	无效的请求参数 invalid arguement
1402	校验签名失败，无效的PDF文件 invalid pdf document
1601	账户余额不足	Your balance is insufficient

*/

//setting offset for signiture location
	$templates = array(
            'offsetX'=>0.2,
            'offsetY'=>0.2,
            'page'=>1				//sign on page onw
        );
        $post_data = array(
					//you should use your own documentID
            "documentId" => $documentIdGenerated,//合同文件在契约锁的唯一标识
            "visible" => true,//带签名外观,visible:印章是否可见 , is signature visible
            "sealId" => "2317930302195048503",//印章在契约锁的唯一标识 sealID for platform
            "location" => json_encode($templates)//印章坐标位置；JSON字符串，如：{"offsetX":0.5,"offsetY":0.5,"page":1}；
        );									//setting location

        $result =  $remoteSignServiceImpl->signByPlatform($post_data);
        print_r($result);
		//***********************************************************************2.3 个人用户签署
		/* 指定坐标位置签署
		 * --------------------------------------------------------------
		 * 个人用户签署,带签名外观
		 * --------------------------------------------------------------
		 */

		 //part 3, signing by user

		 /*
		 potential return
		 0	请求成功		success
		 1001	请求失败 fail (might be IP whitelist issue)
		 1005	无效的请求参数 invalid arguement
		 1402	校验签名失败，无效的PDF文件 invalid pdf document
		 1601	账户余额不足	Your balance is insufficient

		 */

		 //location of signature
		$templates = array(
			'offsetX'=>0.7,
		    'offsetY'=>0.2,
			'page'=>1
		);
		//user details
		$person = array(
			'name'=>'丁武',//用户姓名
		    'mobile'=>'45782136589'//手机号
		);
		$post_data = array(
								//use your own documentId
		    "documentId" => $documentIdGenerated,
		    "visible" => true, 	//is signature visible
				//image of signature of user
			"sealImageBase64" 	 =>"iVBORw0KGgoAAAANSUhEUgAAALQAAABkCAYAAAAv8xodAAABh0lEQVR42u3dUW7CQAxF0ex/02EBgFDETGI/nyPxVxXVvkwAFXEcAAAAAAAAAAAAAAAAAAAAAAAAAMBO548b73OiSbzCvjYnGoQ7bYHmEhxs8vLMZGiwXRdoFmJtszwPZEGau5n1iNnVzfxav4NgKdfn/+1nWRz2yvvB7G4bmsUIGou59SrKgCuBgwBBCxpBi9mCLEfQgjYvMxO0eWFB5oUFmZcFWZBZWZJZYUnzZuWdEUG3n5X/pRZ06zn5gICg28/Jp4YELVxRC7pLsCvuF0E/EvWO+0XQW6NePSMxP7TcqX/77ge9mAUddQUTtKBjghazoAWNoKvORtCCjn/+jKAFjWFXeKCbsaCdznixImiLM3BPNwTtdPaiW9CCFrSgPd1A0E5nCzT4ikH7UICgS52on36fzyIKuuzp7ItRb1rMv5czQfuq6VYnzeRL2DngZnEhwzjdsg+k1GGIZ/BroNRHt9PNuxlxCxWuqCOXLFxRWz7ZUYOgoWLUEBM0AAAAAAAAAABQyAu58uZgb5mSegAAAABJRU5ErkJggg==",
		    "person" => json_encode($person),//个人用户信息；JSON字符串
			"location" => json_encode($templates)
		);
		$result =  $remoteSignServiceImpl->signByPerson($post_data);
		print_r($result);



//***********************************************************************6.2 获取查看合同页面的链接
//part 4: viewing document

        	$post_data = array(
						//use your own $documentIdGenerated
		    "documentId" => $documentIdGenerated//String	合同文件在契约锁的唯一标识
		);
		$result =  $remoteSignServiceImpl->viewUrl($post_data);
		print_r($result);


    }
}
