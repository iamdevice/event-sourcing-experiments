<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 19:38
 */

declare(strict_types=1);

namespace App\Command;

use App\EventSourcing\Model\User\Command\ChangeUserName;
use Prooph\Common\Messaging\MessageFactory;
use Prooph\ServiceBus\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeUserNameCommand extends Command
{
    /**
     * @var \Prooph\ServiceBus\CommandBus $commandBus
     */
    private $commandBus;

    /**
     * @var \Prooph\Common\Messaging\MessageFactory $messageFactory
     */
    private $messageFactory;

    public function __construct(
        CommandBus $commandBus,
        MessageFactory $messageFactory
    ) {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->messageFactory = $messageFactory;
    }

    protected function configure(): void
    {
        $this
            ->setName('users:change-name')
            ->setDescription('Change user name')
            ->addOption('user_id', null, InputOption::VALUE_REQUIRED, 'User ID')
            ->addOption('user_name', 'u', InputOption::VALUE_REQUIRED, 'New name for user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getOption('user_id');
        $name = $input->getOption('user_name');

        $command = $this->messageFactory->createMessageFromArray(ChangeUserName::class, [
            'payload' => [
                'user_id' => $userId,
                'name' => $name,
            ]
        ]);
        $this->commandBus->dispatch($command);
    }
}
