
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title-html')</title>
		<style>
			.page_break { page-break-before: always; },

			#header{
				width:100%;
				height: 90px;
				background:#eee;
			}
			#content{
				position:relative;
				margin:0px 20px;
			}

			#footer{
				position:relative;
				background:#eee;
				height:40px;
				line-height:40px;
				color:#000;
				text-align:center;
			}

			/*CONTENT SECTION*/
			.title{
				color:#696969; 
				font-weight:bold; 
				text-decoration:none; 
				font-size:30px; 
				line-height:60px; 
				padding:20px;
				text-align:center;
			}
		</style>
		@stack('styles')
	</head>
	<body>
		<div id="header">
			<a href="#" class="title">@yield('title')</a>
			<img style="width:100;float:right" class="title" src="{{public_path('assets\src\img\logo-skin-care.png')}}" />
		</div>
		@yield('content')
		
	</body>
	</html>