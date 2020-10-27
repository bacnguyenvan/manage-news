<?php

namespace App\Http\Services;

class GSSService {

	public $testData = '{"hits":1,"page":1,"size":20,"items":[{"id":"10002"}],"facets":{"facet_publish_date":[{"value":"2020/02","count":1},{"value":"2020","count":1}],"author":[{"id":"23","name":"首藤惠","count":1},{"id":"254","name":"蔵元康雄","count":1},{"id":"324","name":"山田洋暉","count":1},{"id":"3453","name":"鹿毛雄二","count":1},{"id":"3455","name":"大場昭義","count":1}],"article_type":[{"id":"9","name":"論文","count":1}],"topic":[{"id":"A0001","name":"アクティブ運用","count":1},{"id":"A0002","name":"アナリスト","count":1}]},"banner":{},"related_words":[]}';

	public function request($inputs, $path) 
	{
		$gssUrl = config('app.gss_url');
		$url = $gssUrl . $path;

		if(!empty($inputs['keyword'])) {
			$params = $this->convertInputsToUrl($inputs);
			$url .= '?'.$params;
		}
		$ch = $this->prepareRequest($url);
		
		$res = curl_exec($ch);
		curl_close($ch);

		//test data at local
		if(config('app.env') == 'local') {
			$res = $this->testData;
		}
		$data = json_decode($res, true);

		return $data;
	}

	public function convertInputsToUrl($inputs)
	{
		$key = 'q';
		$value = $inputs['keyword'];

		if($inputs['field'] != 'all') {
			$keyKeyword .= '_'.$inputs['fields'];
		}
		$params = [
			$key => $value
		];

		return http_build_query($params);
	}

	public function prepareRequest($url) {
		$ch = curl_init();
		$headers = [
			'Content-Type: application/json;charset=UTF-8',
			'Accept: application/json'
		];
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		return $ch;
	}
}