<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use phpseclib3\Crypt\RSA;

class HomeController extends Controller
{
    /**
     * Обработчик запросов
     *
     * @param  Request $request Данные, переданные в запросе
     * @return ResponseFactory
     */
    public function RSA(Request $request)
    {
        //Валидация исходных данных.
        $request->validate([
            'function' => 'required',
            'key_len' => 'required|numeric',
            'src' => 'required'
        ]);

        //Инициализация переменных.
        $func = $request->post('function');
        $key_len = $request->post('key_len');
        $src = $request->post('src');

        //Валидация длинны ключа.
        if ($key_len != 512 && $key_len != 1024 && $key_len != 2048 && $key_len != 4096)
        {
            return response('Invalid key_len', 422);
        }

        if ($func != 'encrypt' && $func != 'decrypt')
        {
            return response('Invalid method', 422);
        }

        //Выполнение выбранного метода.
        return response($this->$func($src, $key_len));
    }


    /**
     * Шифрование данных
     *
     * @param  string $src Исходное сообщение
     * @param  int $key_len Длина ключа
     * @return string
     */
    public function encrypt(string $src, int $key_len): string
    {
        //Генерация пары клчюей.
        $RSA = RSA::createKey($key_len);

        //Сохранение ключа в сессию.
        Session::put('key', $RSA);

        //Шифрование сообщения.
        $res = $RSA->getPublicKey()->encrypt($src);

        //Шифрование ответа в base64.
        $res = base64_encode($res);

        return $res;
    }

    /**
     * Дешифрование данных
     *
     * @param  string $src Зашифрованное сообщение.
     * @return string
     */
    public function decrypt(string $src): string
    {
        //Дешифрование сообщения из base64.
        $src = base64_decode($src);

        //Берём приватный ключ из сессии.
        $key = Session::get('key');

        //Объект класса RSA.
        $RSA = RSA::loadPrivateKey($key);

        //Дешифрование сообщения
        $res = $RSA->decrypt($src);

        return $res;
    }
}
