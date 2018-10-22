<?php

namespace SF\Context\Database;


use SF\Context\CoroutineContext;
use SF\Contracts\Context\Context;
use SF\Database\Transaction;

class TransactionContext implements Context
{
    private static $contexts = [];

    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return Transaction|null
     */
    public static function getTransaction()
    {
        return self::$contexts[CoroutineContext::getStackTopId()] ?? null;
    }


    public function enter()
    {
        self::$contexts[CoroutineContext::getStackTopId()] = $this->transaction;
    }

    public function exitContext()
    {
        $this->transaction = null;
        unset(self::$contexts[CoroutineContext::getStackTopId()]);
    }



}