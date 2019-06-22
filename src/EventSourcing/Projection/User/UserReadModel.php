<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 18:39
 */

declare(strict_types=1);

namespace App\EventSourcing\Projection\User;

use App\EventSourcing\Infrastructure\Entity\User;
use App\EventSourcing\Projection\Table;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Prooph\EventStore\Projection\AbstractReadModel;

final class UserReadModel extends AbstractReadModel
{
    private $tableName = Table::USER;

    /**
     * @var \Doctrine\DBAL\Connection $connection
     */
    private $connection;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $entityManager->getConnection();
    }

    public function init(): void
    {
        $sql = <<<EOT
CREATE TABLE IF NOT EXISTS "$this->tableName" (
    id uuid NOT NULL,
    name varchar(100) NOT NULL,
    PRIMARY KEY (id)
);
EOT;

        $this->connection->prepare($sql)->execute();
    }

    public function isInitialized(): bool
    {
        $sql = <<<EOT
select exists (
    select 1
    from information_schema.tables
    where table_schema = 'public' and table_name = :tableName
);
EOT;

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('tableName', $this->tableName);
        $result = $stmt->fetch(FetchMode::STANDARD_OBJECT);

        return $result->exists ?? false;
    }

    public function reset(): void
    {
        $sql = <<<EOT
TRUNCATE TABLE "$this->tableName";
EOT;

        $this->connection->prepare($sql)->execute();
    }

    public function delete(): void
    {
        $sql = <<<EOT
DROP TABLE "$this->tableName";
EOT;

        $this->connection->prepare($sql)->execute();
    }

    protected function insert(array $data): void
    {
        /** @var \App\EventSourcing\Model\User\Event\UserWasCreated $event */
        $event = $data['event'];

        $this->connection->insert(Table::USER, [
            'id' => $event->userId()->toString(),
            'name' => $event->userName()->toString()
        ]);
    }
}
