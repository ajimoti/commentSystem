<?php 

if (! function_exists('json')) {
    /**
     * Format json response for consistency.
     *
     * @param  array    $data       (array or object of response to send)
     * @param  string   $message    (message)
     * @param  int      $statusCode (Status code for request)
     *
     * @return object
     */
	function json($data, string $message = '', int $statusCode = 200)
    {
        return response()->json([
            'status'    => $statusCode,
            'message'   => $message,
            'data'      => $data,
        ], $statusCode);
    }
}

if (! function_exists('message')) {
    /**
     * Send a json message 
     *
     * @param  string   $message    (message)
     * @param  int      $statusCode (Status code for request)
     *
     * @return object
     */
	function message(string $message, int $statusCode = 200)
    {
        return json([], $message, $statusCode);
    }
}

if (! function_exists('paginated_links')) {
    /**
     * Gather the meta data for paginated response.
     *
     * @param  LengthAwarePaginator  $paginated
     * @return array
     */
    function paginated_links($paginated)
    {
        return [
            'current_page' => $paginated->currentPage(),
            'first_page_url' => $paginated->url($paginated->firstItem()),
            'last_page' => $paginated->lastItem(),
            'last_page_url' => $paginated->url($paginated->lastItem()),
            'next_page_url' => $paginated->nextPageUrl(),
            'per_page' => $paginated->perPage(),
            'previous_page_url' => $paginated->previousPageUrl(),
            'current' => $paginated->currentPage(),
            'total' => $paginated->total(),
        ];
    }

}