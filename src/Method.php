<?php
	
	namespace YetAnother\Laravel;
	
	/**
	 * The HTTP methods supported by endpoints.
	 */
	enum Method : string
	{
		case Get = 'GET';
		case Head = 'HEAD';
		case Query = 'QUERY';
		case Post = 'POST';
		case Put = 'PUT';
		case Patch = 'PATCH';
		case Delete = 'DELETE';
	}