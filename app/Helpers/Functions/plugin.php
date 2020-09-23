<?php
/**
 * Laravel Classified
 *  All Rights Reserved
 *
 * 
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice
 * 
 */

/**
 * @param null $category
 * @param bool $checkInstalled
 * @return array
 */
function plugin_list($category = null, $checkInstalled = false)
{
	$plugins = [];
	
	// Load all Plugins Services Provider
	$list = \File::glob(config('larapen.core.plugin.path') . '*', GLOB_ONLYDIR);
	
	if (count($list) > 0) {
		foreach ($list as $pluginPath) {
			// Get plugin folder name
			$pluginFolderName = strtolower(last(explode(DIRECTORY_SEPARATOR, $pluginPath)));
			
			// Get plugin details
			$plugin = load_plugin($pluginFolderName);
			if (empty($plugin)) {
				continue;
			}
			
			// Filter for category
			if (!is_null($category) && $plugin->category != $category) {
				continue;
			}
			
			// Check installed plugins
			try {
				$plugin->installed = call_user_func($plugin->class . '::installed');
			} catch (\Exception $e) {
				continue;
			}
			
			// Filter for installed plugins
			if ($checkInstalled && $plugin->installed != true) {
				continue;
			}
			
			$plugins[$plugin->name] = $plugin;
		}
	}
	
	return $plugins;
}

/**
 * @param null $category
 * @return array
 */
function plugin_installed_list($category = null)
{
	return plugin_list($category, true);
}

/**
 * Get the plugin details
 * @param $name
 * @return null
 */
function load_plugin($name)
{
	try {
		// Get the plugin init data
		$pluginFolderPath = plugin_path($name);
		$pluginData = file_get_contents($pluginFolderPath . '/init.json');
		$pluginData = json_decode($pluginData);
		
		// Plugin details
		$plugin = [
			'name'          => $pluginData->name,
			'version'       => $pluginData->version,
			'display_name'  => $pluginData->display_name,
			'description'   => $pluginData->description,
			'author'        => $pluginData->author,
			'category'      => $pluginData->category,
			'has_installer' => (isset($pluginData->has_installer) && $pluginData->has_installer == true) ? true : false,
			'installed'     => null,
			'activated'     => true,
			'options'       => null,
			'item_id'       => (isset($pluginData->item_id)) ? $pluginData->item_id : null,
			'provider'      => plugin_namespace($pluginData->name, ucfirst($pluginData->name) . 'ServiceProvider'),
			'class'         => plugin_namespace($pluginData->name, ucfirst($pluginData->name)),
		];
		$plugin = \App\Helpers\ArrayHelper::toObject($plugin);
		
	} catch (\Exception $e) {
		$plugin = null;
	}
	
	return $plugin;
}

/**
 * Get the plugin details (Only if it's installed)
 * @param $name
 * @return null
 */
function load_installed_plugin($name)
{
	$plugin = load_plugin($name);
	if (empty($plugin)) {
		return null;
	}
	
	if (isset($plugin->has_installer) && $plugin->has_installer) {
		try {
			$installed = call_user_func($plugin->class . '::installed');
			
			return ($installed) ? $plugin : null;
		} catch (\Exception $e) {
			return null;
		}
	} else {
		return $plugin;
	}
}

/**
 * @param $pluginFolderName
 * @param $localNamespace
 * @return string
 */
function plugin_namespace($pluginFolderName, $localNamespace = null)
{
	if (!is_null($localNamespace)) {
		return config('larapen.core.plugin.namespace') . $pluginFolderName . '\\' . $localNamespace;
	} else {
		return config('larapen.core.plugin.namespace') . $pluginFolderName;
	}
}

/**
 * Get a file of the plugin
 * @param $pluginFolderName
 * @param $localPath
 * @return string
 */
function plugin_path($pluginFolderName, $localPath = null)
{
	return config('larapen.core.plugin.path') . $pluginFolderName . '/' . $localPath;
}

/**
 * Check if plugin exists
 * @param $pluginFolderName
 * @param null $path
 * @return mixed
 */
function plugin_exists($pluginFolderName, $path = null)
{
	$fullPath = config('larapen.core.plugin.path') . $pluginFolderName . '/' . $path;
	
	return \File::exists($fullPath);
}

/**
 * Get plugins settings values (with HTML)
 * @param $setting
 * @param $out
 * @return mixed
 */
function plugin_setting_value_html($setting, $out)
{
	$plugins = plugin_installed_list();
	if (!empty($plugins)) {
		foreach ($plugins as $key => $plugin) {
			
			$pluginMethodNames = preg_grep('#^get(.+)ValueHtml$#', get_class_methods($plugin->class));
			
			if (!empty($pluginMethodNames)) {
				foreach ($pluginMethodNames as $method) {
					try {
						$out = call_user_func($plugin->class . '::' . $method, $setting, $out);
						
						return $out;
					} catch (\Exception $e) {
						continue;
					}
				}
			}
		}
	}
	
	return $out;
}

/**
 * Set plugins settings values
 * @param $value
 * @param $setting
 * @return bool|mixed
 */
function plugin_set_setting_value($value, $setting)
{
	$plugins = plugin_installed_list();
	if (!empty($plugins)) {
		foreach ($plugins as $key => $plugin) {
			
			$pluginMethodNames = preg_grep('#^set(.+)Value$#', get_class_methods($plugin->class));
			
			if (!empty($pluginMethodNames)) {
				foreach ($pluginMethodNames as $method) {
					try {
						$value = call_user_func($plugin->class . '::' . $method, $value, $setting);
					} catch (\Exception $e) {
						continue;
					}
				}
			}
		}
	}
	
	return $value;
}

/**
 * Check if the plugin attribute exists in the setting object
 * @param $attributes
 * @param $pluginAttrName
 * @return bool
 */
function plugin_setting_field_exists($attributes, $pluginAttrName)
{
	$attributes = jsonToArray($attributes);
	
	if (count($attributes) > 0) {
		foreach ($attributes as $key => $field) {
			if (isset($field['name']) && $field['name'] == $pluginAttrName) {
				return true;
			}
		}
	}
	
	return false;
}

/**
 * Create the plugin attribute in the setting object
 * @param $attributes
 * @param $pluginAttrArray
 * @return string
 */
function plugin_setting_field_create($attributes, $pluginAttrArray)
{
	$attributes = jsonToArray($attributes);
	
	$attributes[] = $pluginAttrArray;
	
	$attributes = json_encode($attributes);
	
	return $attributes;
}

/**
 * Remove the plugin attribute from the setting object
 * @param $attributes
 * @param $pluginAttrName
 * @return string
 */
function plugin_setting_field_delete($attributes, $pluginAttrName)
{
	$attributes = jsonToArray($attributes);
	
	// Get plugin's Setting field array
	$pluginAttrArray = \Illuminate\Support\Arr::where($attributes, function ($value, $key) use ($pluginAttrName) {
		return isset($value['name']) && $value['name'] == $pluginAttrName;
	});
	
	// Remove the plugin Setting field array
	\Illuminate\Support\Arr::forget($attributes, array_keys($pluginAttrArray));
	
	$attributes = json_encode($attributes);
	
	return $attributes;
}

/**
 * Remove the plugin attribute value from the setting object values
 * @param $values
 * @param $pluginAttrName
 * @return mixed
 */
function plugin_setting_value_delete($values, $pluginAttrName)
{
	$values = jsonToArray($values);
	
	// Remove the plugin Setting field array
	if (isset($values[$pluginAttrName])) {
		unset($values[$pluginAttrName]);
	}
	
	return $values;
}

/**
 * Clear the key file
 * @param $name
 */
function plugin_clear_uninstall($name)
{
	$path = storage_path('framework/plugins/' . strtolower($name));
	if (\File::exists($path)) {
		\File::delete($path);
	}
}
