<?php

namespace Larapen\Admin\app\Http\Controllers\Features;

use App\Models\Language;

trait Reorder
{
	/**
	 * Reorder the items in the database using the Nested Set pattern.
	 * Database columns needed: id, parent_id, lft, rgt, depth, name/title
	 *
	 * @param null $lang
	 * @param null $parentId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function reorder($parentId = null, $lang = null)
	{
		$this->xPanel->hasAccessOrFail('reorder');
		
		// Get given lang if 'parentEntity' doesn't exists
		if (!$this->xPanel->hasParentEntity()) {
			$lang = $parentId;
		}
		
		// If lang is not set, get the default language
		if (empty($lang)) {
			$lang = \Lang::locale();
		}
		
		// Get all languages (for order onglets)
		if (property_exists($this->xPanel->model, 'translatable')) {
			$this->data['languages'] = Language::where('active', 1)->get();
			$this->data['active_language'] = $lang;
		}
		
		// Get all results for that entity
		$this->data['entries'] = $this->xPanel->getEntries($lang);
		$this->data['parent_id'] = $this->parentId;
		
		$this->data['xPanel'] = $this->xPanel;
		$this->data['title'] = trans('admin.reorder') . ' ' . $this->xPanel->entityName;
		
		return view('admin::panel.reorder', $this->data);
	}
	
	/**
	 * Save the new order, using the Nested Set pattern.
	 *
	 * Database columns needed: id, parent_id, lft, rgt, depth, name/title
	 *
	 * @return bool|string
	 */
	public function saveReorder()
	{
		// if reorder_table_permission is false, abort
		$this->xPanel->hasAccessOrFail('reorder');
		
		$model = $this->xPanel->model;
		$count = 0;
		$allEntries = request()->input('tree');
		
		if (is_array($allEntries) && count($allEntries)) {
			foreach ($allEntries as $key => $entry) {
				if ($entry['item_id'] != '' && $entry['item_id'] != null) {
					$entry['parent_id'] = $this->parentId;
					$item = $model::find($entry['item_id']);
					if ($item->getConnection()->getSchemaBuilder()->hasColumn($item->getTable(), 'parent_id')) {
						$item->parent_id = $entry['parent_id'];
					}
					$item->depth = $entry['depth'];
					$item->lft = $entry['left'];
					$item->rgt = $entry['right'];
					$item->save();
					
					$count++;
				}
			}
		} else {
			return false;
		}
		
		return trans('admin.reorder_success_for_x_items', ['count' => $count]);
	}
}
