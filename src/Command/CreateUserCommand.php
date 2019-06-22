<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-22 13:54
 */

namespace App\Command;

use App\EventSourcing\Model\User\Command\CreateUser;
use Prooph\ServiceBus\CommandBus;
use Prooph\Common\Messaging\MessageFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateUserCommand extends Command
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
            ->setName('users:create')
            ->setDescription('Create a new user')
            ->addOption('user_name', 'u', InputOption::VALUE_REQUIRED, 'Name of new user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption('user_name');

        $command = $this->messageFactory->createMessageFromArray(CreateUser::class, [
            'payload' => [
                'user_id' => Uuid::uuid4()->toString(),
                'name' => $name,
            ]
        ]);
        $this->commandBus->dispatch($command);
    }
}
