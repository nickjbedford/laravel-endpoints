<?php
	
	namespace YetAnother\Laravel;
	
	enum Method : string
	{
		case Get = 'GET';
		case Head = 'HEAD';
		case Post = 'POST';
		case Put = 'PUT';
		case Patch = 'PATCH';
		case Delete = 'DELETE';
	}
