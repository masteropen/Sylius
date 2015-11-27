<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Grid\Definition;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class Grid
{
    /**
     * @var string
     */
    private $applicationName;

    /**
     * @var string
     */
    private $resourceName;

    /**
     * @var string
     */
    private $section;

    /**
     * @var string
     */
    private $driver;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $columns = array();

    /**
     * @var array
     */
    private $filters = array();

    /**
     * @var array
     */
    private $actions = array();

    /**
     * @var array
     */
    private $rowActions = array();

    /**
     * @var array
     */
    private $massActions = array();

    /**
     * @var array
     */
    private $sorting = array();

    /**
     * @var array
     */
    private $templates = array();

    /**
     * @param string $applicationName
     * @param string $resourceName
     * @param string $section
     * @param string $driver
     * @param array $columns
     * @param array $filters
     * @param array $actions
     * @param array $rowActions
     * @param array $massActions
     * @param array $sorting
     * @param array $templates
     * @param array $options
     */
    public function __construct($applicationName, $resourceName, $driver, array $columns, array $filters, array $actions, array $rowActions, array $massActions, array $sorting, array $templates, array $options)
    {
        $this->applicationName = $applicationName;
        $this->resourceName = $resourceName;
        $this->section = $section;
        $this->driver = $driver;

        foreach ($columns as $column) {
            if (!$column instanceof Column) {
                throw new \InvalidArgumentException('Expected Column definition instance.');
            }
        }

        foreach ($filters as $filter) {
            if (!$filter instanceof Filter) {
                throw new \InvalidArgumentException('Expected Filter definition instance.');
            }
        }

        foreach ($actions as $action) {
            if (!$action instanceof Action) {
                throw new \InvalidArgumentException('Expected Action definition instance.');
            }
        }

        foreach ($rowActions as $action) {
            if (!$action instanceof Action) {
                throw new \InvalidArgumentException('Expected Action definition instance.');
            }
        }

        foreach ($massActions as $action) {
            if (!$action instanceof Action) {
                throw new \InvalidArgumentException('Expected Action definition instance.');
            }
        }

        $this->columns = $columns;
        $this->filters = $filters;
        $this->actions = $actions;
        $this->rowActions = $rowActions;
        $this->massActions = $massActions;
        $this->sorting = $sorting;
        $this->templates = $templates;
        $this->options = $options;
    }

    /**
     * @param array $configuration
     *
     * @return Grid
     */
    public static function createFromArray(array $configuration)
    {
        $columns = array();
        $filters = array();
        $actions = array();
        $rowActions = array();
        $massActions = array();

        foreach ($configuration['columns'] as $name => $columnConfiguration) {
            $columns[$name] = Column::createFromArray($name, $columnConfiguration);
        }
        foreach ($configuration['filters'] as $name => $filterConfiguration) {
            $filters[$name] = Filter::createFromArray($name, $filterConfiguration);
        }
        foreach ($configuration['actions'] as $name => $actionConfiguration) {
            $actions[$name] = Action::createFromArray($name, $actionConfiguration);
        }
        foreach ($configuration['row_actions'] as $name => $actionConfiguration) {
            $rowActions[$name] = Action::createFromArray($name, $actionConfiguration);
        }

        if (array_key_exists('mass_actions', $configuration)) {
            foreach ($configuration['mass_actions'] as $name => $actionConfiguration) {
                $massActions[$name] = Action::createFromArray($name, $actionConfiguration);
            }
        }

        $sorting = array_key_exists('sorting', $configuration) ? $configuration['sorting'] : array();
        $templates = array_key_exists('templates', $configuration) ? $configuration['templates'] : array();
        $options = array_key_exists('options', $configuration) ? $configuration['options'] : array();

        list($applicationName, $resourceName) = explode('.', $configuration['resource']);

        $section = (isset($configuration['options']['module'])) ? '_'.$configuration['options']['module'].'_' : '_';

        return new self($applicationName, $resourceName, $section, $configuration['driver'], $columns, $filters, $actions, $sorting, $options);
    }

    /**
     * @return string
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param string $name
     *
     * @return Column
     */
    public function getColumn($name)
    {
        return $this->columns[$name];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasColumn($name)
    {
        return isset($this->columns[$name]);
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param string $name
     */
    public function getFilter($name)
    {
        return $this->filters[$name];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasFilter($name)
    {
        return isset($this->filters[$name]);
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return array
     */
    public function getRowActions()
    {
        return $this->rowActions;
    }

    /**
     * @return array
     */
    public function getMassActions()
    {
        return $this->massActions;
    }

    /**
     * @return array
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
