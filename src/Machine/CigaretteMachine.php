<?php

namespace App\Machine;

use mysql_xdevapi\Exception;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    public function execute(PurchaseTransactionInterface $purchaseTransaction){
        try{
            $purchaseTransaction->validation();

            $purchasedItem = new PurchasedItem($purchaseTransaction);

            return [
                'error' => false,
                'itemQuantity' => $purchasedItem->getItemQuantity(),
                'totalAmount' => $purchasedItem->getTotalAmount(),
                'change' => $purchasedItem->getChange(),
                'itemPrice' => self::ITEM_PRICE
            ];
        } catch (\Exception $e){
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }

    }
}