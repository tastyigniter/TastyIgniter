<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Migrations;

use Illuminate\Database\Migrations\DatabaseMigrationRepository as BaseDatabaseMigrationRepository;
use Override;

class DatabaseMigrationRepository extends BaseDatabaseMigrationRepository
{
    protected $group;

    public function prepareMigrationTable(): void
    {
        if (!$this->getConnection()->getSchemaBuilder()->hasColumn($this->table, 'group')) {
            return;
        }

        $this->getConnection()
            ->table($this->table)
            ->whereNotNull('group')
            ->get()
            ->each(function($row) {
                if ($group = array_get(['System' => 'igniter.system', 'Admin' => 'igniter.admin'], $row->group, $row->group)) {
                    $group .= '::';
                }

                $this->getConnection()
                    ->table($this->table)
                    ->where('id', $row->id)
                    ->update(['migration' => $group.$row->migration]);
            });

        $this->getConnection()->getSchemaBuilder()->dropColumns($this->table, ['group']);
    }

    #[Override]
    public function getRan()
    {
        $builder = $this->table();

        if (!is_null($this->group)) {
            $builder->where('migration', 'like', $this->group.'::%');
        }

        return $builder
            ->orderBy('batch', 'asc')
            ->orderBy('migration', 'asc')
            ->pluck('migration')->all();
    }

    /**
     * Get the module or extension the migration belongs to.
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set the module or extension the migration belongs to.
     *
     * @param string $name
     */
    public function setGroup($name): void
    {
        $this->group = $name;
    }
}
