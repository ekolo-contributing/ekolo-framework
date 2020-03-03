<?php
    $app = require __DIR__.'/bootstrap/app.php';

    use Ekolo\Framework\Bootstrap\Middleware;

    $model->find()->where()->and([
        'id' => 2,
        'email' => 'ddffff'
    ]);

    $predicate = [
        'where' => [
            'and' => [
                'id' => 2,
                'nom' => 'bolenge'
            ],
            'or' => [
                'id' => 3,
                'prenom' => 'mbuyu'
            ]
        ]
    ];

    $sql = 'SELECT * FROM';

    if (!empty($where = $predicate['where'])) {
        $sql .= ' WHERE ';
        $i = 1;
        $valuesExecute = [];

        if (!empty($where['condition'])) {
            $field = array_key_last($where['condition']);
            debug($field);
            foreach ($where['condition'] as $field => $value) {
                $valuesExecute[$field] = $value;
                $sql .= $field.' = :'.$field;
            }
        }

        if (!empty($where['and'])) {
            $sql .= !empty($where['condition']) ? ' AND ' : '';
            $sql .= '(';

            foreach ($where['and'] as $field => $value) {
                $i++;
                $valuesExecute[$field] = $value;
                $addAnd = ($i <= count($where['and'])) ? ' AND ' : '';
                $sql .= $field.' = :'.$field.$addAnd;
            }

            $sql .= ')';
        }

        if (!empty($where['or'])) {
            $i = 1;
            $sql .= !empty($where['and']) && ($i <= 2) ? ' OR ' : '';
            $sql .= '(';

            foreach ($where['or'] as $field => $value) {
                $i++;
                $addOr = $i <= count($where['or']) ? ' OR ' : '';
                $fieldExecute = key_exists($field, $valuesExecute) ? $field.$i : $field;
                $sql .= $field.' = :'.$fieldExecute.$addOr;
                $valuesExecute[$fieldExecute] = $value;
            }

            $sql .= ')';
        }

        debug($sql);

        $and = !empty($where['and']) ? implode('AND', $where['and']) : '';
    }

    $users = require './routes/users.php';

    $app->middleware('errors', function (Middleware $middleware) {
        $middleware->getError();
    });
    
    $app->use('/', $users);