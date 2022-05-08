<?php


namespace App\Machine;


class PurchaseTransaction implements PurchaseTransactionInterface
{
    private $itemCount;
    private $amount;

    public function __construct(int $itemCount, float $amount){
        $this->itemCount = $itemCount;
        $this->amount = $amount;
    }

    /**
     * @throws \Exception
     */
    public function validation(){
        if ((CigaretteMachine::ITEM_PRICE * $this->itemCount) > $this->amount){
            throw new \Exception('Invalid price or item amount...');;
        }
    }

    /**
     * @return int
     */
    public function getItemQuantity(){
        return $this->itemCount;
    }

    /**
     * @return float
     */
    public function getPaidAmount(){
        return $this->amount;
    }
}