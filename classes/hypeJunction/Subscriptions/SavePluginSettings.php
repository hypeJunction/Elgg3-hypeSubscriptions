<?php

namespace hypeJunction\Subscriptions;

use Elgg\Http\ResponseBuilder;
use Elgg\Request;

class SavePluginSettings {

	/**
	 * Save plugin settings
	 *
	 * @param Request $request
	 *
	 * @return ResponseBuilder
	 */
	public function __invoke(Request $request) {

		$params = $request->getParam('params', []);
		$config = $request->getParam('config', []);

		$plugin_id = $request->getParam('plugin_id');
		$plugin = elgg_get_plugin_from_id($plugin_id);

		if (!$plugin) {
			return elgg_error_response(elgg_echo('plugins:settings:save:fail', [$plugin_id]));
		}

		$plugin_name = $plugin->getDisplayName();

		foreach ($params as $k => $v) {
			if (!is_scalar($v)) {
				$v = serialize($v);
			}

			$result = $plugin->setSetting($k, $v);

			if (!$result) {
				return elgg_error_response(elgg_echo('plugins:settings:save:fail', [$plugin_name]));
			}
		}

		foreach ($config as $k => $v) {
			elgg_save_config($k, $v);
		}

		return elgg_ok_response('', elgg_echo('plugins:settings:save:ok', [$plugin_name]));
	}
}