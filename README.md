[![Build Status](https://travis-ci.org/adamturcsan/literate-spoon.svg?branch=master)](https://travis-ci.org/adamturcsan/literate-spoon)
[![Coverage Status](https://coveralls.io/repos/github/adamturcsan/literate-spoon/badge.svg?branch=master)](https://coveralls.io/github/adamturcsan/literate-spoon?branch=master)

# literate-spoon
SQL query builder

## Usage

```php
<?php

    use LegoW\LiterateSpoon\Builder;
    use LegoW\LiterateSpoon\Component\Direction;

    class TestClass {
        use SomeTrait\With\Database;

        public function getNewsList($num, $offset)
        {
            $builder = new Builder();
            $select = $builder->select('news', ['publishTime', 'title']);
            $select->where()
                    ->compareColumn('like', 'title', 'paramName')
                    ->betweenColumn('publishTime', 'param1', 'param2');
            $select->orderBy()
                   ->setOrder('publishTime', Direction::ASC);
            $select->limit($num, $offset);

            $query = $builder->asString();

            $statement = $this->db->prepare($query);
            $result = $statement->execute([
                'paramName' => '%builder%',
                'param1'    => (new \DateTime('-1 year'))->format('Y-d-m H:i:s'),
                'param2'    => (new \DateTime())->format('Y-d-m H:i:s'),
            ]);
        }
    }
```
