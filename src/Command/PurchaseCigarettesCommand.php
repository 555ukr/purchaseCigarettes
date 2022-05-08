<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));


        $cigaretteMachine = new CigaretteMachine();

        $purchaseTransaction = new PurchaseTransaction($itemCount, $amount);

        $result = $cigaretteMachine->execute($purchaseTransaction);

        if ($result['error']){
            $output->writeln($result['message']);
        } else {
            $output->writeln("You bought <info>{$result['itemQuantity']}</info> packs of cigarettes for<info>{$result['totalAmount']}</info>, each for <info>{$result['itemPrice']}</info>. ");
            $output->writeln('Your change is:');

            $table = new Table($output);
            $table
                ->setHeaders(array('Coins', 'Count'))
                ->setRows(
                    $result['change']
                )
            ;
            $table->render();
        }
    }
}