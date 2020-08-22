<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Response::macro('success', function ($data, $message = "", $status = null) {
            $response = [
                'success' => true,
            ];
            if (!empty($message)) {
                $response['message'] = $message;
            }
            if($status == null){
                $method = request()->getMethod();
                switch ($method){
                    case 'PUT':
                        $status = 200;
                        break;
                    case 'POST' :
                        $status = 201;
                        break;
                    default:
                        $status = 200;
                        break;
                }
            }
            $response['data'] = $data;
            return Response::json($response, $status);
        });

        Response::macro('error', function ($message, $status = 400, $erros = [], $data = []) {

            $response['success'] = false;
            $response['message'] = $message;
            if (!empty($erros)) {
                $response['errors'] = $erros;
            }
            if (!empty($data)) {
                $response['data'] = $data;
            }

            return Response::json($response, $status);
        });
    }
}
