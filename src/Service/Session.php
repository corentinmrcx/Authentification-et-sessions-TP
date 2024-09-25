<?php
declare(strict_types=1);

namespace Service;

use Service\Exception\SessionException;

class Session
{
    public static function start(): void
    {
        switch (session_status()){
            case PHP_SESSION_ACTIVE:
                echo "Session already started";
                break;

            case PHP_SESSION_NONE:
                if (headers_sent()){
                    throw new SessionException('Session is disabled');
                }
                else {
                    try{
                        session_start();
                    }
                    catch (\Exception $e){
                        throw new SessionException();
                    }
                }
                break;

            case PHP_SESSION_DISABLED:
                throw new SessionException("Session not active");


            default:
                throw new SessionException();
        }
    }
}