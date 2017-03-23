[![Build Status](https://travis-ci.org/adamturcsan/literate-spoon.svg?branch=master)](https://travis-ci.org/adamturcsan/literate-spoon)
[![Coverage Status](https://coveralls.io/repos/github/adamturcsan/literate-spoon/badge.svg?branch=master)](https://coveralls.io/github/adamturcsan/literate-spoon?branch=master)

# literate-spoon
SQL query builder

## Usage

```php
<?php

    use LegoW\LiterateSpoon\Builder;
    use LegoW\LiterateSpoon\Component;

    class TestClass {
        use SomeTrait\With\Database;

        public function getNewsList($num, $offset)
        {
            $builder = new Builder();
            $select = new Component\Select('news', ['publishTime', 'title']);
            $select->where()
                   ->compareColumn('like', 'title', 'paramName')
                   ->between('publishTime', 'param1', 'param2');
            $select->orderBy()
                   ->setOrder('publishTime', Component\Direction::ASC);
            $select->limit($num, $offset);
            $builder->addComponent($select); // SELECT `publishTime`, `title` FROM news WHERE (`title` like :paramName) AND (`pubishTime` BETWEEN :param1 AND :param2) LIMIT 1, 10;
            $query = $builder->asString();

            $statement = $this->db->prepare($query);
            $result = $statement->execute([
                'paramName' => '%',
                'param1'    => (new \DateTime('-1 year'))->format('Y-d-m H:i:s'),
                'param2'    => (new \DateTime())->format('Y-d-m H:i:s'),
            ]);
        }
    }
```
