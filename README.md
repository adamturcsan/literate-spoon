[![Build Status](https://travis-ci.org/adamturcsan/literate-spoon.svg?branch=master)](https://travis-ci.org/adamturcsan/literate-spoon)
[![Coverage Status](https://coveralls.io/repos/github/adamturcsan/literate-spoon/badge.svg?branch=master)](https://coveralls.io/github/adamturcsan/literate-spoon?branch=master)

# literate-spoon
SQL query builder

## Usage

```php
<?php

namespace Sample\Data\Model;

use LegoW\LiterateSpoon\Builder;
use LegoW\LiterateSpoon\Component\Direction;
use LegoW\LiterateSpoon\Component\Join;

class News {
    use SomeTrait\With\Database;

    const COL_NEWS_ID = 'news_id';
    const COL_PUBLISH_TIME = 'publish_time';
    const COL_TITLE = 'title';
    const COL_CONTENT = 'publish_time';

    private $columns = [
        self::COL_NEWS_ID,
        self::COL_PUBLISH_TIME,
        self::COL_TITLE,
        self::COL_CONTENT
    ];

    public function getNewsList(int $num, int $offset): array
    {
        $builder = new Builder();
        $select = $builder->select('news', [self::COL_PUBLISH_TIME, self::COL_TITLE]);
        $select->where()
                ->compareColumn('like', self::COL_TITLE, 'paramName')
                ->betweenColumn(self::COL_PUBLISH_TIME, 'param1', 'param2');
        $select->orderBy()
               ->setOrder(self::COL_PUBLISH_TIME, Direction::ASC);
        $select->limit($num, $offset);

        $query = $builder->asString();

        $statement = $this->db->prepare($query);
        $statement->execute([
            'paramName' => '%builder%',
            'param1'    => (new \DateTime('-1 year'))->format('Y-m-d H:i:s'),
            'param2'    => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);
        return $statement->fetchAll();
    }

    public function getNewsWithComments(int $newsId): array
    {
        $builder = new Builder();
        $select = $builder->select('news');
        $select->join('comments', Join::TYPE_LEFT)
            ->using(self::COL_NEWS_ID);
        $select->where()
            ->compareColumn('=', self::COL_NEWS_ID, 'newsId');
        $query = $builder->asString();
        $statement = $this->db->prepare($query);
        $statement->bindValue('newsId', $newsId);
        $statement->execute();
        return $statement->fetch();
    }

    public function add(string $title, string $content): int
    {
        $builder = new Builder();
        $builder->insert('news')
            ->addColumn(self::COL_TITLE)->addValuePlaceHolderFor('title')
            ->addColumn(self::COL_CONTENT)->addValuePlaceHolderFor('content')
            ->addColumn(self::COL_PUBLISH_TIME)->addValuePlaceHolderFor('publishTime');
        $query = $builder->asString();
        $statement = $this->db->prepare($query);
        $statement->bindValue('title', $title);
        $statement->bindValue('content', $content);
        $statement->bindValue('publishTime', (new DateTime())->format('Y-m-d H:i:s'));
        $statement->execute();
        return $this->db->lastInsertId();
    }

    public function update(int $newsId, array $data): bool
    {
        $builder = new Builder();
        $update = $builder->update('news');
        foreach ($this->columns as $columnName) {
            if ($columnName !== self::COL_NEWS_ID && array_key_exists($columnName, $data)) {
                $update->set($columnName, $columnName);
            }
        }
        $update->where()->compareColumn('=', self::COL_NEWS_ID, 'newsId');
        $query = $builder->asString();
        $statement = $this->db->prepare($query);
        foreach ($data as $columnName => $value) {
            if (array_key_exists($columnName, $this->columns)) {
                $statement->bindValue($columnName, $value);
            }
        }
        $statement->bindValue('newsId', $newsId);
        return $statement->execute();
    }
}
```
