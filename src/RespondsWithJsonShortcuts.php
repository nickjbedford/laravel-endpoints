<?php
	
	namespace YetAnother\Laravel;
	
	use Illuminate\Http\JsonResponse;
	use Throwable;
	use YetAnother\Laravel\Traits\RespondsWithJson;
	
	trait RespondsWithJsonShortcuts
	{
		use RespondsWithJson;
		
		/**
		 * Returns a JSON response indicating success.
		 * @param mixed|null $data An optional data payload for the client.
		 * @return JsonResponse
		 */
		protected function success(mixed $data = null): JsonResponse
		{
			return response()->json($this->jsonSuccess($data)->toArray());
		}
		
		/**
		 * Returns a JSON response indicating failure with an optional error code and data payload.
		 * @param string $errorMessage The error message to display to the user.
		 * @param string|null $errorCode An optional error code for the client to use in handling the error.
		 * @param array $errorData An optional data payload with further information
		 * @return JsonResponse
		 */
		protected function error(string $errorMessage, ?string $errorCode = null, array $errorData = []): JsonResponse
		{
			return response()->json($this->jsonFailure($errorMessage, $errorCode, $errorData)->toArray());
		}
		
		/**
		 * Returns a JSON response indication failure from an exception, with optional debugging data
		 * about the exception included in the error data payload.
		 * @param Throwable $exception The exception that was thrown.
		 * @param bool|null $includeDebugData Whether or not to include the debugging information about the
		 * exception in the error payload. This will default to the JsonResponse::$debugMode value.
		 * @return JsonResponse
		 */
		protected function exception(Throwable $exception, ?bool $includeDebugData = null): JsonResponse
		{
			report($exception);
			return response()->json($this->jsonException($exception, $includeDebugData)->toArray());
		}
	}
