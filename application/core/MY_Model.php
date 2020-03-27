<?php

class MY_Model extends CI_Model
{

    protected $CI;

    function __construct()
    {
        parent::__construct();
        // $this->load->model('core/Core', 'core');
    }

    protected function loadCI()
    {
        return $this->CI =& get_instance();
    }


    protected function tableHandler()
    {

        //
    }

}

class tikTable
{
    protected $configuration;
    private $adapter;
    private $columns = [];
    private $actions = [];
    private $tableName;
    private $columnMapping = null;

    public function __construct($adapter, array $configuration)
    {
        $this->columns = isset($configuration['columns']) ? $configuration['columns'] : array();

        $this->adapter = $adapter;

        //get table name
        $this->tableName = $this->adapter->getTableName();

//		var_dump($this->columns);

        // set default configuration
        if (!isset($configuration['max_page_size'])) {
            $configuration['max_page_size'] = 1000;
        }
        if (!isset($configuration['default_page_size'])) {
            $configuration['default_page_size'] = 20;
        }
        $this->configuration = $configuration;
    }


    public function getColumns()
    {
        return $this->columns;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    private function setColumnsFromMaker($makerResult)
    {
        $columns = array();
        //get Maker Result
        if ($makerResult) {
            if (isset($makerResult['columns']) && !empty($makerResult['columns'])) {
                $this->columnMapping = $makerResult['columns'];
            }
        }
        return $columns;
    }


    /**
     * @param $context
     * @param array $arguments
     * @return array
     */
    private function getDataFromAdapter($context, array $arguments = array())
    {
        $db = $this->adapter->getDB();

        //select and filtering
        $makerResult = $this->adapter->makeDatatableQuery($this->adapter->getTableName(), $context, $db, $arguments);

        $this->setColumnsFromMaker($makerResult);

        return $db;
    }


    /**
     * Apply 'filters' parameters from arguments.
     * @param $db
     * @param $context
     * @param $arguments
     */
    private function applyFilters($db, $context, $arguments)
    {
        //set the table name
        $db->from($this->getTableName());

        //Use and for all filters
        foreach ($arguments['filters'] as $key => $value) {
            if ($key == null) {
                $db->where($value, null, FALSE);
            } else {
                if (is_array($value))
                    $db->where_in($key, $value);
                else
                    $db->where($key, $value);
            }
        }

        if (isset($arguments['filtersData'])) {
            foreach ($arguments['filtersData'] as $key => $value) {
                $column = ($this->getColumnName($key));
                //if array search in
                if (is_array($value)) {
                    $db->where_in($column, $value);
                    // if string but has */wildcard, use like query
                } else if (strpos($value, "*") !== false) {
                    //TODO: Respect wildcard character position.
                    $db->like($column, str_replace("*", "", $value));
                } else {
                    //use where for exact match.
                    $db->where($column, $value);
                }
            }
        }
    }


    /***
     * Get UI Filters specific data.
     * @param $context
     * @param $arguments
     * @return mixed
     */
    public function getUIFilters($context, $arguments, $ui_filter)
    {

        //Get all the columns for whom we need data.
        foreach ($ui_filter as $columnName => $uif) {
            if (isset($uif['enum']) && !is_array($uif['enum'])) {
                $db = $this->getDatagetDataFromAdapter($context, $arguments);
                $db->distinct();
                $db->select($this->getColumnName($columnName) . ' as ' . $columnName);

                //apply generic filters.
                $this->applyFilters($db, $context, $arguments);

                //get data
                $ui_filter[$columnName]['enum'] = array();

                $res = $db->get()->result_array();
                foreach ($res as $r) {
                    $label = empty($r[$columnName]) ? ' - ' : $r[$columnName];
                    $ui_filter[$columnName]['enum'][$label] = $r[$columnName];
                }

//				$db->reset();
            }
        }
        return $ui_filter;
    }

    public function getData($context, $filters)
    {
        $arguments = array(
            "filters" => $filters
        );
        $db = $this->getDataFromAdapter($context, $arguments);

        $columns = [];
        foreach ($this->columns as $col) {
            $columnName = $this->getColumnName($col['data']);
            $columns[$col['data']] = $columnName . ' as ' . $col['data'];
        }

        if (count($columns))
            $db->select(implode(', ', array_values($columns)));

        $this->applyFilters($db, $context, $arguments);
        return $items = $db->get()->result_array();
    }

    /**
     * Get data for datatable.
     * @param $context
     * @param $arguments
     * @return array
     */
    public function getDataTableData($context, $arguments)
    {
        $db = $this->getDataFromAdapter($context, $arguments);

        //TODO: Select based on columns.
        $columns = [];
        //Make sure all requested columns are present in columnMapping returned by method. Select only requested cols.
        foreach ($this->columns as $col) {
            $columnName = $this->getColumnName($col['data']);
            $columns[$col['data']] = $columnName . ' as ' . $col['data'];
        }

        //if any columns are present only then use specific select
        if (count($columns))
            $db->select(implode(', ', array_values($columns)));

        $this->applyFilters($db, $context, $arguments);

        // search
        $this->setSearch($db, $arguments);

        // filtering
        //$this->setFilters($db, $arguments);

        // get total count
        $count = $db->count_all_results(null, FALSE);

        // pagination
        $this->setLimits($db, $arguments);

        // ordering
        $this->setSort($db, $arguments);

        //echo $db->last_query();

        // get data
        $items = $db->get()->result_array();

        $result = [
            'draw' => $arguments['draw'],
            'data' => $items,
            'recordsFiltered' => $count,
            'recordsTotal' => $count,
        ];
        if (IS_DEV) {
            $result['dev'] = $db->last_query();
        }
        return $result;
    }

    /**
     * Returns mapped columns name, this is very helpful in case of column name mapping with joins.
     * Eg: user.fullname will be fullname in datatable - which will be translated back to user.fullname using
     * $columnMapping
     * @param $expectedName
     * @return mixed
     */
    protected function getColumnName($expectedName)
    {
        if ($this->columnMapping != null) {
            if (isset($this->columnMapping[$expectedName]))
                return $this->columnMapping[$expectedName];
            else
                throw  new Error("Mapping for " . $expectedName . ' not found in model columnMapping. Current mapping is : ' . json_encode($this->columnMapping));
        }
        return $expectedName;
    }

    /**
     * Compose wildcard search queries.
     * @param $db
     * @param $request
     */
    protected function setSearch($db, $request)
    {
        $like = null;
        if (isset($request['search']) && $request['search']) {
            $searchString = $request['search']['value'];
            if (empty($searchString)) return;

            foreach ($this->getColumns() as $index => $column) {
                if ($column['searchable']) {
                    //if not started the group start it.
                    if ($like == null) {
                        $db->group_start();
                        $db->like($this->getColumnName($column['data']), $searchString);
                        $like = true;
                    } else {
                        //in the group then use or.
                        $db->or_like($this->getColumnName($column['data']), $searchString);
                    }

                }
            }
            //if group started
            if ($like == true)
                $db->group_end();
        }
    }

    /**
     * Sort columns
     * @param $db
     * @param $request
     */
    protected function setSort($db, $request)
    {

        if (isset($request['order']) && $request['order']) {
            foreach ($request['order'] as $key => $order) {
                $column = $this->getColumns()[$order['column']];
                $db->order_by($this->getColumnName($column['data']), $order['dir']);
            }
        }
    }


    /**
     * Handle pagination
     * @param $db
     * @param array $request
     */
    protected function setLimits($db, array $request)
    {
        $limit = isset($request['length']) ? (int)$request['length'] : 0;
        if ($limit > $this->configuration['max_page_size']) {
            $limit = $this->configuration['max_page_size'];
        }
        if ($limit === 0) {
            $limit = $this->configuration['default_page_size'];
        }
        if ($limit == -1) {
            $limit = $this->configuration['max_page_size'];
        }
        $offset = isset($request['start']) ? (int)$request['start'] : 0;
        $db->limit($limit, $offset);
    }


    protected function setFilters($db, $request)
    {
//		$filters = [];
//		foreach ($this->getColumns() as $index => $column) {
//			$searchString = $request['sSearch_' . $index];
//			if ($column->isAllowSearch() && $searchString) {
//				$filters[$column->getDbName()] = [
//					'value' => $searchString,
//					'exactly' => $column->isExactlySearch()
//				];
//			}
//		}
//		$this->adapter->setFilters($filters);
    }
}


/**
 * Class BaseMySQL
 * Base class to offer basic setters for master
 */
class BaseMySQL_model extends MY_Model
{
    public function __construct($table)
    {
        parent::__construct();
        $this->table = $table;
    }

    /**
     * Add item and return ID.
     * @param $data
     * @return mixed
     */
    public function add($data)
    {

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Get By some conditions.
     * @param string|array $select
     * @param $where
     * @return mixed
     */
    public function getBy($select = null, $where = null, $limit=null)
    {
        if ($select == null) $select = "*";
        $res = $this->db->select($select)->where($where);
        if($limit)
            $res->limit($limit);
        return $res->get($this->table)->result_array();
    }

    /**
     * Get By OR
     * @param string|array $select
     * @param $where
     * @return mixed
     */
    public function getByOR($select = null, $where = null)
    {
        if ($select == null) $select = "*";
        return $this->db->select($select)->or_where($where)->get($this->table)->result_array();
    }


    /**
     * Get By ID
     * @param $id
     * @param null $fields
     * @return mixed
     */
    public function getByID($id, $fields = null)
    {
        return $this->getOneItem($this->getBy($fields, array('id' => $id)));
    }

    /**
     * @param $select
     * @return mixed
     */
    public function getAll($select = null)
    {
        if ($select == null) $select = "*";
        $query = $this->db->select($select)->get($this->table);
        return $query->result_array();
    }


    /**
     * Set status of specific element.
     * @param $id
     * @param int $status
     * @return mixed
     */
    public function setStatus($id, $status = 0)
    {
        $check = $this->db->set(array('status' => $status))->where(array('id' => $id))->update($this->table);
        return $check;
    }


    /**
     * Set specific field by ID
     * @param $id
     * @param array $fields
     * @return mixed
     */
    public function setByID($id, $fields = array())
    {
        $check = $this->db->set($fields)->where(array('id' => $id))->update($this->table);
        return $check;
    }

    /**
     * Set specific field by ID
     * @param $where
     * @return mixed
     */
    public function deleteBy($where = array())
    {
        $result = $this->db->where($where)->delete($this->table);
        return $result;
    }

    /**
     * Remove an item by id.
     * @param $id
     * @return mixed
     */
    public function deleteById($id)
    {
        $query = array('id' => $id);
        $result = $this->deleteBy($query);
        return $result;
    }

    /**
     * Returns first or last item from array, if nothing then null.
     * @param $res
     * @param bool $last true to return last item.
     * @return |null
     */
    static function getOneItem($res, $last = false)
    {
        if (!is_array($res) || count($res) == 0)
            return null;

        //if last is set, get last item
        return $res[$last ? count($res) - 1 : 0];
    }

    public function getTableName()
    {
        return $this->table;
    }

    public function getDB()
    {
        return $this->db;
    }

    /**
     * Returns a datatable adapter.
     * @param $options
     * @return tikTable
     */
    public function getDataTable($options)
    {
        return new tikTable($this, $options);
    }

    /**
     * Handle Tabler requests for specific model.
     *
     * Return can contain following key:
     *
     * 'columns' // it can be mapping of table column names, useful incase of joins.
     *        array('name'=>'users.name')
     *
     *
     * @param $table Tabler table
     * @param $db Database Database object of request.
     * @param $context User context
     * @param $arguments Arguments received
     * @return array Array
     */
    public function makeDatatableQuery($table, $context, $db, $arguments = null)
    {
//			throw new Error("Datatable Query Handler is not implemented.");
        return array();
    }
}


class_alias('BaseMySQL_model', 'BaseSetters_model');
