<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Ushahidi User Registration Validator
 *
 * Checks the consistency of the User before registration
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use Ushahidi\Core\Tool\Validator;
use Ushahidi\Core\Usecase\User\RegisterRepository;

class Ushahidi_Validator_User_Register extends Validator
{
	private $repo;

	public function __construct(RegisterRepository $repo)
	{
		$this->repo	= $repo;
	}

	protected function getRules()
	{
		
		return [
			'email' => [
				['not_empty'],
				['max_length', [':value', 150]],
				['email'],
				[[$this->repo, 'isUniqueEmail'], [':value']],
			],
			'username' => [
				['not_empty'],
				['max_length', [':value', 50]],
				['regex', [':value', '/^[a-z][a-z0-9._-]+[a-z0-9]$/i']],
				[[$this->repo, 'isUniqueUsername'], [':value']],
			],
			'password' => [
				['not_empty'],
				['min_length', [':value', 7]],
				['max_length', [':value', 72]]
			]
		];
	}
}
