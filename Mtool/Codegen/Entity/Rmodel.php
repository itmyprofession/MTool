<?php 
/**
 * Mage Tool
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Mtool
 * @package    Mtool_Codegen
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Resource model code generator
 *
 * @category   Mtool
 * @package    Mtool_Codegen
 * @subpackage Entity
 * @author     Daniel Kocherga <dan@oggettoweb.com>
 */
class Mtool_Codegen_Entity_Rmodel extends Mtool_Codegen_Entity_Model
{
    /**
     * Rewrite resource model
     *
     * @param string $originNamespace
     * @param string $originPath
     * @param string $path
     * @param Mtool_Codegen_Entity_Module $module
     */
    public function rewrite($originNamespace, $originPath, $path, Mtool_Codegen_Entity_Module $module)
    {
        // Find origin class prefix
        $resourceModel = $this->lookupOriginEntityClass($originNamespace, $module->findThroughModules('config.xml'), 'resourceModel');
        $classPrefix = $this->lookupOriginEntityClass($resourceModel, $module->findThroughModules('config.xml'));

        // Create own class
        $originPathSteps = $this->_ucPath(explode('_', $originPath));
        $originClassName = implode('_', $originPathSteps);
        $params = array(
            'original_class_name' => "{$classPrefix}_{$originClassName}"
        );
        $className = $this->createClass($path, $this->_rewriteTemplate, $module, $params);

        //Register rewrite in config
        $config = new Mtool_Codegen_Config($module->getConfigPath('config.xml'));
        $config->set("global/{$this->_configNamespace}/{$resourceModel}/rewrite/{$originPath}", $className);
    }
}
