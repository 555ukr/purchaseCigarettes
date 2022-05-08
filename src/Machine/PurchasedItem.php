<?php


namespace App\Machine;


class PurchasedItem implements PurchasedItemInterface
{
    public $purchaseTransaction;
    private $availableCoins = [0.01, 0.02, 0.05, 0.10, 0.20, 0.50];

    public function __construct(PurchaseTransactionInterface $purchaseTransaction){
        $this->purchaseTransaction = $purchaseTransaction;
    }
    /**
     * @return integer
     */
    public function getItemQuantity(){
        return $this->purchaseTransaction->getItemQuantity();
    }

    /**
     * @return float
     */
    public function getTotalAmount(){
        return $this->purchaseTransaction->getItemQuantity() * CigaretteMachine::ITEM_PRICE;
    }

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array
     */
    public function getChange(){
        $totalChange = $this->purchaseTransaction->getPaidAmount() - $this->getTotalAmount();
        $countCount = [];
        $formatCountChange = [];

        while ($totalChange != 0) {
            $closestCoin =  $this->getClosest($totalChange);
            $countCount[] = "{$closestCoin}";
            $totalChange = round($totalChange - $closestCoin, 2);
        }

        foreach (array_count_values($countCount) as $key => $value){
            $formatCountChange[] = array (
                $key,
                $value,
            );
        }
        return $formatCountChange;
    }

    private function getClosest($search) {
        $closest = 0.01;

        foreach ($this->availableCoins as $coin) {
            if ($coin <= $search) {
                $closest = $coin;
            }
        }
        return $closest;
    }
}