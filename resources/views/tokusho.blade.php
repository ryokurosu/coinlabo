@extends('layouts.app')

@section('title')特定商取引法に基づく表記@stop

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="noindex,nofollow">
@endsection


@section('content')
<div class="page-title"><h1>@yield('title')</h1></div>
<div class="col-xs-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table table-striped table-bordered">
				<tbody>
					<tr>
						<td>販売業者名</td>
						<td>株式会社Patriot</td>
					</tr>
					<tr>
						<td>所在地</td>
						<td>〒130-0013 東京都墨田区錦糸1-2-1
						アルカセントラル 14F　</td>
					</tr>
					<tr>
						<td>問い合わせ受付時間</td>
						<td>9:00~18:00</td>
					</tr>
					<tr>
						<td>メールアドレス</td>
						<td>contact@s-patriot.com</td>
					</tr>
					<tr>
						<td>ホームページURL</td>
						<td>http://coinlabo.biz</td>
					</tr>
					<tr>
						<td>お届け時期</td>
						<td>入金確認後、直ちに商品を発送いたします。</td>
					</tr>
					<tr>
						<td>お支払方法</td>
						<td>各記載に従います。</td>
					</tr>
					<tr>
						<td>お申込みの有効期限</td>
						<td>７日以内にお願いいたします。<br>
						７日間入金がない場合は、キャンセルとさせていただきます。</td>
					</tr>
					<tr>
						<td>返品・交換・キャンセル等</td>
						<td>商品発送後の返品・返却等はお受けいたしかねます。<br>
						商品が不良の場合のみ返金いたします。キャンセルは注文後２４時間以内に限り受付いたします。</td>
					</tr>
					
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
