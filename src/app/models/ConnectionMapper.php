<?php
Namespace Models
{
    Class ConnectionMapper
    {
        private $db = null;

        public function __construct($db)
        {
            $this->db = $db;
        }

        public function fetch()
        {
            try {
                $res = $this->db->query('SELECT * FROM products LIMIT 1', \PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                Throw New \Exception(print_r("Error: " . $e, 1));
            }

            return $res->fetch();
        }
    }
}
